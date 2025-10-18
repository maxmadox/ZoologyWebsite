<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include 'database/database.php';

// MANUAL ENTRY
if(isset($_POST['add_student'])) {
    $full_name = $_POST['full_name'];
    $course = $_POST['course'];
    $semester = $_POST['semester'];
    $year = $_POST['year'];
    $roll_number = $_POST['roll_number'];
    $email = $_POST['email'];
    $phone = $_POST['phone_number'];
    $dob = $_POST['dob'];

    // Check if student exists
    $check = mysqli_query($conn, "SELECT * FROM students WHERE roll_number='$roll_number'");
    if(mysqli_num_rows($check) == 0){
        // Insert new student
        mysqli_query($conn, "INSERT INTO students (full_name, course, semester, year, roll_number, email, phone_number, dob) 
                             VALUES ('$full_name','$course','$semester','$year','$roll_number','$email','$phone','$dob')");
    } else {
        // Update existing student
        mysqli_query($conn, "UPDATE students SET full_name='$full_name', course='$course', semester='$semester', 
                             year='$year', email='$email', phone_number='$phone', dob='$dob'
                             WHERE roll_number='$roll_number'");
    }

    // Handle login user
    $default_password = password_hash(str_replace('-', '', $dob), PASSWORD_DEFAULT);
    $check_user = mysqli_query($conn, "SELECT * FROM users WHERE username='$roll_number' AND role='student'");
    if(mysqli_num_rows($check_user) == 0){
        mysqli_query($conn, "INSERT INTO users (username, password, role, status) 
                             VALUES ('$roll_number', '$default_password', 'student', 'active')");
    } else {
        mysqli_query($conn, "UPDATE users SET password='$default_password', status='active' 
                             WHERE username='$roll_number' AND role='student'");
    }

    header('Location: manage_students.php');
    exit();
}

// FILE UPLOAD
if(isset($_POST['upload_file']) && isset($_FILES['student_file'])) {
    $fileName = $_FILES['student_file']['tmp_name'];

    if($_FILES['student_file']['type'] === 'text/csv' || strpos($_FILES['student_file']['name'], '.csv') !== false) {
        $file = fopen($fileName, "r");
        fgetcsv($file); // Skip header row

        while(($row = fgetcsv($file)) !== false) {
            $full_name = $row[0];
            $course = $row[1];
            $semester = $row[2];
            $year = $row[3];
            $roll_number = $row[4];
            $email = $row[5];
            $phone = $row[6];
            $dob = $row[7];

            // Check if student exists
            $check = mysqli_query($conn, "SELECT * FROM students WHERE roll_number='$roll_number'");
            if(mysqli_num_rows($check) == 0){
                // Insert
                mysqli_query($conn, "INSERT INTO students (full_name, course, semester, year, roll_number, email, phone_number, dob)
                                     VALUES ('$full_name','$course','$semester','$year','$roll_number','$email','$phone','$dob')");
            } else {
                // Update existing
                mysqli_query($conn, "UPDATE students SET full_name='$full_name', course='$course', semester='$semester', 
                                     year='$year', email='$email', phone_number='$phone', dob='$dob'
                                     WHERE roll_number='$roll_number'");
            }

            // Handle login user
            $default_password = password_hash(str_replace('-', '', $dob), PASSWORD_DEFAULT);
            $check_user = mysqli_query($conn, "SELECT * FROM users WHERE username='$roll_number' AND role='student'");
            if(mysqli_num_rows($check_user) == 0){
                mysqli_query($conn, "INSERT INTO users (username, password, role, status)
                                     VALUES ('$roll_number', '$default_password', 'student', 'active')");
            } else {
                mysqli_query($conn, "UPDATE users SET password='$default_password', status='active'
                                     WHERE username='$roll_number' AND role='student'");
            }
        }
        fclose($file);
        header('Location: manage_students.php');
        exit();
    } else {
        header("Location: add_student.php?error=invalidfile");
        exit();
    }
}
?>
