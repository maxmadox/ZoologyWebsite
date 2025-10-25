<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include 'database/database.php';

if(isset($_POST['update_student'])) {
    $id = $_POST['user_id'];
    $full_name = $_POST['full_name'];
    $course = $_POST['course'];
    $semester = $_POST['semester'];
    $dob = $_POST['dob'];
    $year = $_POST['year'];
    $snp_id = $_POST['snp_id'];
    $email = $_POST['email'];
    $phone = $_POST['phone_number'];

    $query = "UPDATE students SET 
                full_name='$full_name',
                course='$course',
                semester='$semester',
                dob='$dob',
                year='$year',
                snp_id='$snp_id',
                email='$email',
                phone_number='$phone'
              WHERE user_id='$id'";

    mysqli_query($conn, $query);

    header('Location: manage_students.php');
    exit();
}
?>
