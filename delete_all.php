<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include 'database/database.php';

// Get filters
$filter_semester = isset($_GET['filter_semester']) ? $_GET['filter_semester'] : '';
$filter_course = isset($_GET['filter_course']) ? $_GET['filter_course'] : '';
$filter_year = isset($_GET['filter_year']) ? $_GET['filter_year'] : '';
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Build WHERE clause
$where = [];
if($filter_semester) $where[] = "semester='$filter_semester'";
if($filter_course) $where[] = "course='$filter_course'";
if($filter_year) $where[] = "year='$filter_year'";
if($search) $where[] = "(full_name LIKE '%$search%' OR roll_number LIKE '%$search%')";
$where_sql = $where ? "WHERE " . implode(" AND ", $where) : "";

// Get all roll_numbers of filtered students
$result = mysqli_query($conn, "SELECT roll_number FROM students $where_sql");
$roll_numbers = [];
while($row = mysqli_fetch_assoc($result)) {
    $roll_numbers[] = "'" . $row['roll_number'] . "'";
}

// Delete corresponding logins in users table
if(!empty($roll_numbers)) {
    $roll_list = implode(',', $roll_numbers);
    mysqli_query($conn, "DELETE FROM users WHERE username IN ($roll_list) AND role='student'");
}

// Delete students from students table
mysqli_query($conn, "DELETE FROM students $where_sql");

header('Location: manage_students.php');
exit();
?>
