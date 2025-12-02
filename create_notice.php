

<?php
ob_start();
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include 'database/database.php';
include 'header.php';

$error = '';


if(isset($_POST['add_notice'])){
    $title = mysqli_real_escape_string($conn, $_POST['title']);

    if(isset($_FILES['file']) && $_FILES['file']['error'] == 0){
        $file_tmp = $_FILES['file']['tmp_name'];
        $file_name = basename($_FILES['file']['name']);
        $file_type = mime_content_type($file_tmp);
        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        
        $allowed_mimes = ['application/pdf', 'image/jpeg', 'image/png'];
        $allowed_exts = ['pdf', 'jpg', 'jpeg', 'png'];

        if(in_array($file_type, $allowed_mimes) && in_array($ext, $allowed_exts)){
            $folder = 'uploads/notices/';
            if(!is_dir($folder)) mkdir($folder, 0777, true);

            $filename = time().'_'.$file_name;
            $filepath = $folder.$filename;

            if(move_uploaded_file($file_tmp, $filepath)){
                mysqli_query($conn, "INSERT INTO notices (title, file_path, date) VALUES ('$title', '$filepath', NOW())");
                header('Location: manage_notices.php');
                exit();
            } else {
                $error = "Failed to upload file. Check folder permissions.";
            }
        } else {
            $error = "Invalid file type. Only PDF, JPG, and PNG files are allowed.";
        }
    } else {
        $error = "Please upload a file.";
    }
}


?>

<main class="create-notice-view">
    <?php include 'admin_sidebar.php'; ?>

    <?php if($error): ?>
        <div class="popup" style="display:flex;">
            <div class="popup-content">
                <p><?php echo htmlspecialchars($error); ?></p>
                <button onclick="document.querySelector('.popup').style.display='none'">OK</button>
            </div>
        </div>
    <?php endif; ?>

    <div class="create-notice-content">
        
            <h1 class="create-notice-title">Add New Notice</h1>
        

        <form action="" method="post" enctype="multipart/form-data" class="manual-form">
            <label>Notice Title:</label>
            <input type="text" name="title" required>

            <label>Upload File (PDF/JPG/PNG):</label>
            <input type="file" name="file" accept=".pdf,.jpg,.jpeg,.png" required>

            <input type="submit" name="add_notice" value="Add Notice">
        </form>
    </div>
</main>

<?php include 'footer.php'; ?>

<?php ob_end_flush(); ?>

