<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include 'database/database.php';
include 'header.php';

$error = '';

// Handle form submission
if(isset($_POST['add_notice'])){
    $title = mysqli_real_escape_string($conn, $_POST['title']);

    if(isset($_FILES['file']) && $_FILES['file']['error'] == 0){
        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $allowed = ['pdf','jpg','jpeg','png'];

        if(in_array(strtolower($ext), $allowed)){
            $folder = 'uploads/notices/';
            if(!is_dir($folder)) mkdir($folder, 0777, true);

            $filename = time().'_'.basename($_FILES['file']['name']);
            $filepath = $folder.$filename;

            if(move_uploaded_file($_FILES['file']['tmp_name'], $filepath)){
                mysqli_query($conn, "INSERT INTO notices (title, file_path, date) VALUES ('$title','$filepath',NOW())");

                // Redirect to manage notices after adding
                header('Location: manage_notices.php');
                exit();
            } else {
                $error = "Failed to upload the file.";
            }
        } else {
            $error = "Invalid file type! Only PDF, JPG, JPEG, PNG are allowed.";
        }
    } else {
        $error = "Please upload a file!";
    }
}
?>

<main class="admin-dashboard-container">
    <?php include 'admin_sidebar.php'; ?>

    <?php if($error): ?>
        <div class="popup" style="display:flex;">
            <div class="popup-content">
                <p><?php echo htmlspecialchars($error); ?></p>
                <button onclick="document.querySelector('.popup').style.display='none'">OK</button>
            </div>
        </div>
    <?php endif; ?>

    <div class="admin-content">
        <div class="add-student-header">
            <h1 class="admintitle">Add New Notice</h1>
        </div>

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
