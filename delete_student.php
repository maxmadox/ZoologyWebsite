<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include 'database/database.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    // Get roll_number of the student before deletion
    $result = mysqli_query($conn, "SELECT roll_number FROM students WHERE user_id='$id'");
    if($row = mysqli_fetch_assoc($result)) {
        $roll_number = $row['roll_number'];

        // Delete student from students table
        mysqli_query($conn, "DELETE FROM students WHERE user_id='$id'");

        // Delete corresponding login from users table
        mysqli_query($conn, "DELETE FROM users WHERE username='$roll_number' AND role='student'");
    }
}

header('Location: manage_students.php');
exit();
?>
