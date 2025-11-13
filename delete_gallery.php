<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include 'database/database.php';

if(isset($_GET['id'])) {
    $id = intval($_GET['id']);

    
    $result = mysqli_query($conn, "SELECT image_path FROM gallery WHERE id = $id");
    if($row = mysqli_fetch_assoc($result)) {
        $imagePath = $row['image_path'];
        if(file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    
    mysqli_query($conn, "DELETE FROM gallery WHERE id = $id");
}

header('Location: manage_gallery.php');
exit();
?>
