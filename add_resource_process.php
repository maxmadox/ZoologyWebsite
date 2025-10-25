<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    header('Location: login.php');
    exit();
}

include 'database/database.php';

if(isset($_POST['add_resource'])) {
    $title = trim($_POST['title']);
    $type = $_POST['type'];
    $date = date('Y-m-d');

    if(empty($title) || empty($type)) {
        header("Location: create_resource.php?error=emptyfields");
        exit();
    }

    
    if($type == 'file' && isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $file_name = $_FILES['file']['name'];
        $file_tmp = $_FILES['file']['tmp_name'];
        $file_type = $_FILES['file']['type'];
        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

       $allowed_mimes = [
            'application/pdf',
            'image/jpeg',
            'image/png',
            'application/msword', 
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 
            'application/vnd.ms-powerpoint', 
            'application/vnd.openxmlformats-officedocument.presentationml.presentation'
        ];

        $allowed_exts = ['pdf', 'jpg', 'jpeg', 'png', 'doc', 'docx', 'ppt', 'pptx'];


        if(in_array($file_type, $allowed_mimes) && in_array($ext, $allowed_exts)) {
            $upload_dir = "uploads/resources/";
            if(!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

            $unique_name = time() . "_" . basename($file_name);
            $destination = $upload_dir . $unique_name;

            if(move_uploaded_file($file_tmp, $destination)) {
                $stmt = mysqli_prepare($conn, "INSERT INTO resources (title, type, file_path, date) VALUES (?, 'file', ?, ?)");
                mysqli_stmt_bind_param($stmt, "sss", $title, $destination, $date);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);

                header("Location: manage_resources.php?success=1");
                exit();
            } else {
                header("Location: create_resource.php?error=uploadfail");
                exit();
            }
        } else {
            header("Location: create_resource.php?error=invalidfile");
            exit();
        }
    }

  
    elseif($type == 'link') {
        $link = trim($_POST['link']);
        if(empty($link)) {
            header("Location: create_resource.php?error=emptylink");
            exit();
        }

        $stmt = mysqli_prepare($conn, "INSERT INTO resources (title, type, link_url, date) VALUES (?, 'link', ?, ?)");
        mysqli_stmt_bind_param($stmt, "sss", $title, $link, $date);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("Location: manage_resources.php?success=1");
        exit();
    }

    else {
        header("Location: create_resource.php?error=invalidtype");
        exit();
    }
} else {
    header("Location: create_resource.php");
    exit();
}
?>
