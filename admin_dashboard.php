<?php
session_start();

// Checking if admin is logged in 
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Include database connection
include 'database/database.php';

// Fetch counts
$student_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM students"))['total'];
$teacher_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM teachers"))['total'];
$notice_count  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM notices"))['total'];




include 'header.php';
?>  
   <div class="admin-dashboard-container">

   <?php include 'admin_sidebar.php'; ?>

    <main>
        <h1 class = "admintitle">Admin Dashboard</h1>

        <div class="totalstats">
            <div class="stats" onclick ="location.href='manage_students.php'">
                <h2>Total Students</h2>
                <p><?php echo $student_count; ?></p>
            </div>
            <div class="stats" onclick ="location.href='manage_teachers.php'">
                <h2>Total Teachers</h2>
                <p><?php echo $teacher_count; ?></p>
            </div>
            <div class="stats" onclick ="location.href='manage_notices.php'">
                <h2>Total Notices</h2>
                <p><?php echo $notice_count; ?></p>
            </div>

        </div>
        
        
    </main>
    </div>
<?php
include 'footer.php';
?>