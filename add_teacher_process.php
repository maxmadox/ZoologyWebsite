<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include 'database/database.php';


function getNextTeacherId($conn) {
    $result = mysqli_query($conn, "SELECT MAX(user_id) AS max_id FROM teachers");
    $row = mysqli_fetch_assoc($result);
    $next_id = $row['max_id'] ?? 1; 
    if($next_id < 1) $next_id = 1;
    $next_id++;
    if($next_id > 100){
        die("Error: Teacher IDs exhausted (max 2–100 allowed).");
    }
    return $next_id;
}


if(isset($_POST['add_teacher'])) {
    $full_name = $_POST['full_name'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $phone = $_POST['phone_number'];

    
    $qualification = '';
    if(isset($_POST['qualification']) && is_array($_POST['qualification'])){
        $quals = $_POST['qualification'];
        if(in_array('Other', $quals) && !empty($_POST['other_qualification'])){
            $quals = array_map(function($q){
                return $q === 'Other' ? $_POST['other_qualification'] : $q;
            }, $quals);
        } else {
            $quals = array_filter($quals, fn($q)=>$q!=='Other');
        }
        $qualification = implode(', ', $quals);
    }

    $date_joined = $_POST['date_joined'];

    
    $image_path = NULL;
    if(isset($_FILES['teacher_image']) && $_FILES['teacher_image']['error'] == 0){
        $upload_dir = 'uploads/teachers/';
        if(!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        $ext = pathinfo($_FILES['teacher_image']['name'], PATHINFO_EXTENSION);
        $image_name = uniqid('teacher_').'.'.$ext;
        $target = $upload_dir.$image_name;
        if(move_uploaded_file($_FILES['teacher_image']['tmp_name'], $target)){
            $image_path = $target;
        }
    }

    
    $check = mysqli_query($conn, "SELECT * FROM teachers WHERE email='$email'");
    if(mysqli_num_rows($check) > 0){
       
        $update_sql = "UPDATE teachers 
                       SET full_name='$full_name', dob='$dob', phone_number='$phone', 
                           qualification='$qualification', date_joined='$date_joined'";
        if($image_path) $update_sql .= ", teacher_image='$image_path'";
        $update_sql .= " WHERE email='$email'";
        mysqli_query($conn, $update_sql);

        $default_password = password_hash(str_replace('-', '', $dob), PASSWORD_DEFAULT);
        mysqli_query($conn, "UPDATE users 
                             SET password='$default_password'
                             WHERE username='$email' AND role='teacher'");
    } else {
        
        $teacher_id = getNextTeacherId($conn);
        $cols = "user_id, full_name, dob, email, phone_number, qualification, date_joined";
        $vals = "$teacher_id, '$full_name', '$dob', '$email', '$phone', '$qualification', '$date_joined'";
        if($image_path){
            $cols .= ", teacher_image";
            $vals .= ", '$image_path'";
        }
        mysqli_query($conn, "INSERT INTO teachers ($cols) VALUES ($vals)");

        $default_password = password_hash(str_replace('-', '', $dob), PASSWORD_DEFAULT);
        mysqli_query($conn, "INSERT INTO users (id, username, password, role, status) 
                             VALUES ($teacher_id, '$email', '$default_password', 'teacher', 'active')");
    }

    header('Location: manage_teachers.php');
    exit();
}


if(isset($_POST['upload_file']) && isset($_FILES['teacher_file'])) {
    $fileName = $_FILES['teacher_file']['tmp_name'];

    if($_FILES['teacher_file']['type'] === 'text/csv' || strpos($_FILES['teacher_file']['name'], '.csv') !== false) {
        $file = fopen($fileName, "r");
        fgetcsv($file); 

        while(($row = fgetcsv($file)) !== false) {
            $full_name = $row[0];
            $dob = $row[1];
            $email = $row[2];
            $phone = $row[3];

            
            $quals = explode(',', $row[4] ?? '');
            $quals = array_map('trim', $quals);
            $qualification = implode(', ', array_filter($quals));

            $date_joined = $row[5] ?? NULL;
            $image_path = $row[6] ?? NULL; 

            $check = mysqli_query($conn, "SELECT * FROM teachers WHERE email='$email'");
            if(mysqli_num_rows($check) > 0){
               
                $update_sql = "UPDATE teachers 
                               SET full_name='$full_name', dob='$dob', phone_number='$phone', 
                                   qualification='$qualification', date_joined='$date_joined'";
                if($image_path) $update_sql .= ", teacher_image='$image_path'";
                $update_sql .= " WHERE email='$email'";
                mysqli_query($conn, $update_sql);

                $default_password = password_hash(str_replace('-', '', $dob), PASSWORD_DEFAULT);
                mysqli_query($conn, "UPDATE users 
                                     SET password='$default_password'
                                     WHERE username='$email' AND role='teacher'");
            } else {
                
                $teacher_id = getNextTeacherId($conn);
                $cols = "user_id, full_name, dob, email, phone_number, qualification, date_joined";
                $vals = "$teacher_id, '$full_name', '$dob', '$email', '$phone', '$qualification', '$date_joined'";
                if($image_path){
                    $cols .= ", teacher_image";
                    $vals .= ", '$image_path'";
                }
                mysqli_query($conn, "INSERT INTO teachers ($cols) VALUES ($vals)");

                $default_password = password_hash(str_replace('-', '', $dob), PASSWORD_DEFAULT);
                mysqli_query($conn, "INSERT INTO users (id, username, password, role, status)
                                     VALUES ($teacher_id, '$email', '$default_password', 'teacher', 'active')");
            }
        }

        fclose($file);
        header('Location: manage_teachers.php');
        exit();
    } else {
        header("Location: add_teacher.php?error=invalidfile");
        exit();
    }
}
?>
