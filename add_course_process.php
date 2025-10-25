<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role']!=='admin'){
    header('Location: login.php');
    exit();
}

include 'database/database.php';

$type = $_GET['type'] ?? '';
if(!in_array($type, ['bsc','msc'])){
    die("Invalid course type.");
}

$table = $type==='bsc' ? 'bsc_courses' : 'msc_courses';

$class = $_POST['class'] ?? '';
$papers = $_POST['papers'] ?? '';

if(empty($class) || empty($papers)){
    die("All fields are required.");
}

$stmt = $conn->prepare("INSERT INTO $table (class, papers) VALUES (?, ?)");
$stmt->bind_param("ss", $class, $papers);
$stmt->execute();
$stmt->close();

header("Location: manage_courses.php");
exit();
