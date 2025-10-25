<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role']!=='admin'){
    header('Location: login.php');
    exit();
}

include 'database/database.php';

$type = $_GET['type'] ?? '';
$id = intval($_GET['id'] ?? 0);

if(!in_array($type,['bsc','msc']) || !$id){
    die("Invalid request");
}

$table = $type==='bsc' ? 'bsc_courses' : 'msc_courses';
$class = $_POST['class'] ?? '';
$papers = $_POST['papers'] ?? '';

if(empty($class) || empty($papers)){
    die("All fields are required.");
}

$stmt = $conn->prepare("UPDATE $table SET class=?, papers=? WHERE id=?");
$stmt->bind_param("ssi", $class, $papers, $id);
$stmt->execute();
$stmt->close();

header("Location: manage_courses.php");
exit();
