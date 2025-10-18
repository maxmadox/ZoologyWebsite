<?php
session_start();

// Checking if admin is logged in 
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Include database connection
include 'database/database.php';



include 'header.php';
?>  

<main class ="admin-dashboard-container">
    <?php include 'admin_sidebar.php'; ?>

</main>

<?php include 'footer.php'; ?>