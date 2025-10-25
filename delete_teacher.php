<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include 'database/database.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    
    $result = mysqli_query($conn, "SELECT email FROM teachers WHERE user_id='$id'");
    if($row = mysqli_fetch_assoc($result)) {
        $email = $row['email'];

        
        mysqli_query($conn, "DELETE FROM teachers WHERE user_id='$id'");

       
        mysqli_query($conn, "DELETE FROM users WHERE username='$email' AND role='teacher'");
    }

    header('Location: manage_teachers.php');
    exit();
} else {
    header('Location: manage_teachers.php');
    exit();
}
?>
