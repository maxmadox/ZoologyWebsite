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
    $date_joined = $_POST['date_joined'];

  
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

   
    $update_sql = "UPDATE teachers 
                   SET full_name='$full_name', dob='$dob', email='$email', phone_number='$phone', 
                       qualification='$qualification', date_joined='$date_joined'";
    if($image_path) $update_sql .= ", image_path='$image_path'";
    $update_sql .= " WHERE user_id=$id";
    mysqli_query($conn, $update_sql);

   
    $default_password = password_hash(str_replace('-', '', $dob), PASSWORD_DEFAULT);
    mysqli_query($conn, "UPDATE users 
                         SET password='$default_password'
                         WHERE username='$email' AND role='teacher'");

    header('Location: manage_teachers.php');
    exit();
}
?>
