<?php
session_start();

// Checking if teacher is logged in
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    header('Location: login.php');
    exit();
}

// Include database connection
include 'database/database.php';

// Get teacher's user ID from session
$teacher_id = $_SESSION['user_id'];

// Fetch teacher info
$teacher = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM teachers WHERE user_id = $teacher_id"));

// Count notices for teacher
$notice_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM notices WHERE target_role IN ('teacher','all')"))['total'];

include 'header.php';
?>
<div>
    

    <main>
        <h1>Teacher Dashboard</h1>
        <a href="logout.php">Logout</a>
    </main>
</div>
<?php
include 'footer.php';
?>
