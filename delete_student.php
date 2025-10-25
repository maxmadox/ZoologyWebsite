<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include 'database/database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    
    $result = mysqli_query($conn, "SELECT snp_id FROM students WHERE user_id='$id'");
    if ($row = mysqli_fetch_assoc($result)) {
        $snp_id = $row['snp_id'];

        
        mysqli_query($conn, "DELETE FROM attendance WHERE student_id='$id'");

        
        mysqli_query($conn, "DELETE FROM students WHERE user_id='$id'");

        
        mysqli_query($conn, "DELETE FROM users WHERE username='$snp_id' AND role='student'");
    }
}

header('Location: manage_students.php');
exit();
?>
