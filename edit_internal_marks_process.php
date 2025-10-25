<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include 'database/database.php';

$bscMarks = $_POST['bsc_marks'] ?? '';
$mscMarks = $_POST['msc_marks'] ?? '';


$stmtBsc = $conn->prepare("UPDATE internal_marks SET marks_info=? WHERE course_type='bsc'");
$stmtBsc->bind_param("s", $bscMarks);
$stmtBsc->execute();
$stmtBsc->close();

$stmtMsc = $conn->prepare("UPDATE internal_marks SET marks_info=? WHERE course_type='msc'");
$stmtMsc->bind_param("s", $mscMarks);
$stmtMsc->execute();
$stmtMsc->close();

header('Location: manage_courses.php');
exit();
