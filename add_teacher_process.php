<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include 'database/database.php';

// ------------------------------
// MANUAL ENTRY
// ------------------------------
if(isset($_POST['add_teacher'])) {
    $full_name = $_POST['full_name'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $phone = $_POST['phone_number'];

    // Step 1: Check if teacher exists by email
    $check = mysqli_query($conn, "SELECT * FROM teachers WHERE email='$email'");
    
    if(mysqli_num_rows($check) > 0){
        // Teacher exists → update info
        mysqli_query($conn, "UPDATE teachers 
                             SET full_name='$full_name', dob='$dob', phone_number='$phone'
                             WHERE email='$email'");

        // Update login credentials if needed
        $default_password = password_hash(str_replace('-', '', $dob), PASSWORD_DEFAULT);
        mysqli_query($conn, "UPDATE users 
                             SET password='$default_password'
                             WHERE username='$email' AND role='teacher'");
    } else {
        // Teacher does not exist → insert new
        mysqli_query($conn, "INSERT INTO teachers (full_name, dob, email, phone_number) 
                             VALUES ('$full_name', '$dob', '$email', '$phone')");

        // Auto-create login credentials
        $default_password = password_hash(str_replace('-', '', $dob), PASSWORD_DEFAULT);
        mysqli_query($conn, "INSERT INTO users (username, password, role, status) 
                             VALUES ('$email', '$default_password', 'teacher', 'active')");
    }

    header('Location: manage_teachers.php');
    exit();
}

// ------------------------------
// CSV / EXCEL UPLOAD
// ------------------------------
if(isset($_POST['upload_file']) && isset($_FILES['teacher_file'])) {
    $fileName = $_FILES['teacher_file']['tmp_name'];

    // Only accept CSV files
    if($_FILES['teacher_file']['type'] === 'text/csv' || strpos($_FILES['teacher_file']['name'], '.csv') !== false) {
        $file = fopen($fileName, "r");
        fgetcsv($file); // Skip header row

        while(($row = fgetcsv($file)) !== false) {
            $full_name = $row[0];
            $dob = $row[1];
            $email = $row[2];
            $phone = $row[3];

            // Check if teacher exists
            $check = mysqli_query($conn, "SELECT * FROM teachers WHERE email='$email'");
            if(mysqli_num_rows($check) > 0){
                // Exists → update
                mysqli_query($conn, "UPDATE teachers 
                                     SET full_name='$full_name', dob='$dob', phone_number='$phone'
                                     WHERE email='$email'");

                // Update login credentials
                $default_password = password_hash(str_replace('-', '', $dob), PASSWORD_DEFAULT);
                mysqli_query($conn, "UPDATE users 
                                     SET password='$default_password'
                                     WHERE username='$email' AND role='teacher'");
            } else {
                // Does not exist → insert new
                mysqli_query($conn, "INSERT INTO teachers (full_name, dob, email, phone_number) 
                                     VALUES ('$full_name','$dob','$email','$phone')");

                // Auto-create login credentials
                $default_password = password_hash(str_replace('-', '', $dob), PASSWORD_DEFAULT);
                mysqli_query($conn, "INSERT INTO users (username, password, role, status)
                                     VALUES ('$email', '$default_password', 'teacher', 'active')");
            }
        }

        fclose($file);

        // Redirect after upload
        header('Location: manage_teachers.php');
        exit();
    } else {
        header("Location: add_teacher.php?error=invalidfile");
        exit();
    }
}
?>

?>
