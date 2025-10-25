<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include 'database/database.php';


$filter_semester = isset($_GET['filter_semester']) ? $_GET['filter_semester'] : '';
$filter_course = isset($_GET['filter_course']) ? $_GET['filter_course'] : '';
$filter_year = isset($_GET['filter_year']) ? $_GET['filter_year'] : '';
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';


$where = [];
if($filter_semester) $where[] = "semester='$filter_semester'";
if($filter_course) $where[] = "course='$filter_course'";
if($filter_year) $where[] = "year='$filter_year'";
if($search) $where[] = "(full_name LIKE '%$search%' OR snp_id LIKE '%$search%')";
$where_sql = $where ? "WHERE " . implode(" AND ", $where) : "";


$result = mysqli_query($conn, "SELECT snp_id FROM students $where_sql");
$snp_ids = [];
while($row = mysqli_fetch_assoc($result)) {
    $snp_ids[] = "'" . $row['snp_id'] . "'";
}


if(!empty($snp_ids)) {
    $roll_list = implode(',', $snp_ids);
    mysqli_query($conn, "DELETE FROM users WHERE username IN ($roll_list) AND role='student'");
}


mysqli_query($conn, "DELETE FROM students $where_sql");

header('Location: manage_students.php');
exit();
?>
