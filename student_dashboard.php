<?php
session_start();

// Checking if student is logged in
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header('Location: login.php');
    exit();
}

// Include database connection
include 'database/database.php';

// Get student's user ID from session
$student_id = $_SESSION['user_id'];

// Fetch student info
$student = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM students WHERE user_id = $student_id"));

// Count notices for student
$notice_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM notices WHERE target_role IN ('student','all')"))['total'];

include 'header.php';
?>
<div>
    

    <main>
        <h1>Student Dashboard</h1>
        <a href="logout.php">Logout</a>
    </main>
</div>
<?php
include 'footer.php';
?>
