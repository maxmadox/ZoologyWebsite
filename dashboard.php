<?php
session_start();

//checking login

if(!isset($_SESSION['admin'])){
    header('location: login.php');
    exit();
}
include 'header.php';

?>

<main>
    <h1>Admin Dashboard</h1>

</main>

<?php include 'footer.php'; ?>