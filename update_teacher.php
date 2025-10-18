<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include 'database/database.php';

if(isset($_POST['update_teacher'])) {
    $id = $_POST['user_id'];
    $full_name = $_POST['full_name'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $phone = $_POST['phone_number'];

    $query = "UPDATE teachers 
              SET full_name='$full_name', dob='$dob', email='$email', phone_number='$phone'
              WHERE user_id=$id";
    mysqli_query($conn, $query);

    header('Location: manage_teachers.php');
    exit();
}
?>
