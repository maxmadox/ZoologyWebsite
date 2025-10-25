<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include 'database/database.php';


if(!isset($_GET['id'])) {
    header('Location: manage_students.php');
    exit();
}

$student_id = $_GET['id'];


$result = mysqli_query($conn, "SELECT * FROM students WHERE user_id='$student_id'");
$student = mysqli_fetch_assoc($result);

include 'header.php';
?>

<main class="edit-student-view">
    <?php include 'admin_sidebar.php'; ?>

    <div class="edit-student-content">
        <h1 class="edit-student-title">Edit Student</h1>

        <form action="edit_student_process.php" method="post" class="manual-form">
            <input type="hidden" name="user_id" value="<?php echo $student['user_id']; ?>">

            <label>Full Name:</label>
            <input type="text" name="full_name" value="<?php echo $student['full_name']; ?>" required>

            <label for="course">Course:</label>
            <select name="course" required>
                <option value="B.sc" <?php if($student['course']=='B.sc') echo 'selected'; ?>>B.sc</option>
                <option value="M.sc" <?php if($student['course']=='M.sc') echo 'selected'; ?>>M.sc</option>
                
            </select>

            <label for="semester">Semester:</label>
            <select name="semester" required>
                <?php for($i=1;$i<=6;$i++): ?>
                    <option value="<?php echo $i; ?>" <?php if($student['semester']==$i) echo 'selected'; ?>><?php echo $i; ?></option>
                <?php endfor; ?>
            </select>

            <label for="dob">DOB:</label>
            <input type="date" name="dob" value="<?php echo $student['dob']; ?>" required>

            <label>Year:</label>
            <input type="text" name="year" value="<?php echo $student['year']; ?>">

            <label>SNP ID:</label>
            <input type="text" name="snp_id" value="<?php echo $student['snp_id']; ?>">

            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $student['email']; ?>">

            <label>Phone:</label>
            <input type="text" name="phone_number" value="<?php echo $student['phone_number']; ?>">

            <input type="submit" name="update_student" value="Update Student">
        </form>
    </div>
</main>

<?php include 'footer.php'; ?>
