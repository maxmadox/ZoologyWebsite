<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include 'database/database.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $targetDir = "uploads/gallery/";

    if(!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $fileName = time() . "_" . basename($_FILES["image"]["name"]);
    $targetFilePath = $targetDir . $fileName;

    $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

    if(in_array($fileType, $allowedTypes)) {
        if(move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
            $query = "INSERT INTO gallery (title, image_path) VALUES ('$title', '$targetFilePath')";
            mysqli_query($conn, $query);
            header('Location: manage_gallery.php');
            exit();
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "Only JPG, JPEG, PNG, and GIF files are allowed.";
    }
}
?>
