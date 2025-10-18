<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include 'database/database.php';
include 'header.php';

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM teachers WHERE user_id = $id");
$teacher = mysqli_fetch_assoc($result);
?>

<main class="admin-dashboard-container">
    <?php include 'admin_sidebar.php'; ?>

    <div class="admin-content">
        <h1 class="admintitle">Edit Teacher</h1>

        <form action="update_teacher.php" method="post" class="manual-form">
            <input type="hidden" name="user_id" value="<?php echo $teacher['user_id']; ?>">

            <label>Full Name:</label>
            <input type="text" name="full_name" value="<?php echo $teacher['full_name']; ?>" required>

            <label>DOB:</label>
            <input type="date" name="dob" value="<?php echo $teacher['dob']; ?>" required>

            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $teacher['email']; ?>" required>

            <label>Phone:</label>
            <input type="text" name="phone_number" value="<?php echo $teacher['phone_number']; ?>" required>

            <input type="submit" name="update_teacher" value="Update Teacher">
        </form>
    </div>
</main>

<?php include 'footer.php'; ?>
