<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include 'database/database.php';

if(isset($_GET['id'])){
    $id = intval($_GET['id']);
    
    // Delete file from server
    $res = mysqli_query($conn, "SELECT file_path FROM notices WHERE id=$id");
    if($row = mysqli_fetch_assoc($res)){
        if(file_exists($row['file_path'])){
            unlink($row['file_path']);
        }
    }

    // Delete database record
    mysqli_query($conn, "DELETE FROM notices WHERE id=$id");
}

header('Location: manage_notices.php');
exit();
?>
