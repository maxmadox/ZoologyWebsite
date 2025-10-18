<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include 'database/database.php';

if(isset($_POST['add_notice'])) {
    $title = trim($_POST['title']);
    $date = date('Y-m-d');

    if(empty($title) || !isset($_FILES['notice_file'])) {
        header("Location: create_notice.php?error=emptyfields");
        exit();
    }

    $file_name = $_FILES['notice_file']['name'];
    $file_tmp = $_FILES['notice_file']['tmp_name'];
    $file_type = $_FILES['notice_file']['type'];

    // Allow PDF and images only
    $allowed_types = ['application/pdf', 'image/jpeg', 'image/png', 'image/jpg'];
    if(!in_array($file_type, $allowed_types)) {
        header("Location: create_notice.php?error=invalidfile");
        exit();
    }

    // Create destination folder if not exists
    $upload_dir = "uploads/notices/";
    if(!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Make unique file name
    $unique_name = time() . "_" . basename($file_name);
    $destination = $upload_dir . $unique_name;

    if(move_uploaded_file($file_tmp, $destination)) {
        // Insert into database
        $stmt = mysqli_prepare($conn, "INSERT INTO notices (title, file_path, date) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sss", $title, $destination, $date);
        if(mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            // Redirect to manage notices after success
            header("Location: manage_notices.php?success=1");
            exit();
        } else {
            mysqli_stmt_close($stmt);
            header("Location: create_notice.php?error=dberror");
            exit();
        }
    } else {
        header("Location: create_notice.php?error=uploadfail");
        exit();
    }
} else {
    header("Location: create_notice.php");
    exit();
}
?>
