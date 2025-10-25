<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include 'database/database.php';

$type = $_POST['type'] ?? '';
if(!in_array($type, ['bsc','msc'])){
    die("Invalid course type.");
}

if(isset($_FILES['course_csv']) && $_FILES['course_csv']['error'] === 0){
    $file = $_FILES['course_csv']['tmp_name'];
    $handle = fopen($file, 'r');
    if($handle !== false){
        $table = $type === 'bsc' ? 'bsc_courses' : 'msc_courses';
        
        
        
        while(($data = fgetcsv($handle, 1000, ",")) !== false){
            
            $class = $conn->real_escape_string($data[0]);
            $papers = $conn->real_escape_string($data[1]);
            $conn->query("INSERT INTO $table (class, papers) VALUES ('$class', '$papers')");
        }
        fclose($handle);
        header("Location: manage_courses.php");
        exit();
    }
}else{
    echo "Error uploading file.";
}
?>
