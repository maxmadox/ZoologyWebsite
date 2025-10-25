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
$conn->query("DELETE FROM $table WHERE id=$id");

header("Location: manage_courses.php");
exit();
