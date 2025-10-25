<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include 'database/database.php';


function getNextStudentId($conn) {
    $result = mysqli_query($conn, "SELECT MAX(user_id) AS max_id FROM students");
    $row = mysqli_fetch_assoc($result);
    $next_id = $row['max_id'] ?? 100;

    return ($next_id < 100) ? 101 : $next_id + 1;
}


if(isset($_POST['add_student'])) {
    $full_name = $_POST['full_name'];
    $course = $_POST['course'];
    $semester = $_POST['semester'];
    $dob = $_POST['dob'];       
    $year = $_POST['year'];
    $snp_id = $_POST['snp_id'];
    $email = $_POST['email'];
    $phone = $_POST['phone_number'];

    
    $check = mysqli_query($conn, "SELECT * FROM students WHERE snp_id='$snp_id'");
    if(mysqli_num_rows($check) == 0){
        $student_id = getNextStudentId($conn);

        mysqli_query($conn, "INSERT INTO students (user_id, full_name, course, semester, dob, year, snp_id, email, phone_number) 
                             VALUES ($student_id,'$full_name','$course','$semester','$dob','$year','$snp_id','$email','$phone')");

        $default_password = password_hash(str_replace('-', '', $dob), PASSWORD_DEFAULT);
        mysqli_query($conn, "INSERT INTO users (id, username, password, role, status) 
                             VALUES ($student_id,'$snp_id','$default_password','student','active')");
    } else {
        mysqli_query($conn, "UPDATE students SET full_name='$full_name', course='$course', semester='$semester', 
                             dob='$dob', year='$year', email='$email', phone_number='$phone'
                             WHERE snp_id='$snp_id'");

        $default_password = password_hash(str_replace('-', '', $dob), PASSWORD_DEFAULT);
        mysqli_query($conn, "UPDATE users SET password='$default_password', status='active' 
                             WHERE username='$snp_id' AND role='student'");
    }

    header('Location: manage_students.php');
    exit();
}


if(isset($_POST['upload_file']) && isset($_FILES['student_file'])) {
    $fileName = $_FILES['student_file']['tmp_name'];

    if($_FILES['student_file']['type'] === 'text/csv' || strpos($_FILES['student_file']['name'], '.csv') !== false) {
        $file = fopen($fileName, "r");
        fgetcsv($file); 

        while(($row = fgetcsv($file)) !== false) {
            $full_name = $row[0];
            $course = $row[1];
            $semester = $row[2];
            $dob = $row[3];       
            $year = $row[4];
            $snp_id = $row[5];
            $email = $row[6];
            $phone = $row[7];

            $check = mysqli_query($conn, "SELECT * FROM students WHERE snp_id='$snp_id'");
            if(mysqli_num_rows($check) == 0){
                $student_id = getNextStudentId($conn);

                mysqli_query($conn, "INSERT INTO students (user_id, full_name, course, semester, dob, year, snp_id, email, phone_number)
                                     VALUES ($student_id,'$full_name','$course','$semester','$dob','$year','$snp_id','$email','$phone')");

                $default_password = password_hash(str_replace('-', '', $dob), PASSWORD_DEFAULT);
                mysqli_query($conn, "INSERT INTO users (id, username, password, role, status)
                                     VALUES ($student_id,'$snp_id','$default_password','student','active')");
            } else {
                mysqli_query($conn, "UPDATE students SET full_name='$full_name', course='$course', semester='$semester', 
                                     dob='$dob', year='$year', email='$email', phone_number='$phone'
                                     WHERE snp_id='$snp_id'");

                $default_password = password_hash(str_replace('-', '', $dob), PASSWORD_DEFAULT);
                mysqli_query($conn, "UPDATE users SET password='$default_password', status='active'
                                     WHERE username='$snp_id' AND role='student'");
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
