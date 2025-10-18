<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include 'database/database.php';

// Get student ID from URL
if(!isset($_GET['id'])) {
    header('Location: manage_students.php');
    exit();
}

$student_id = $_GET['id'];

// Fetch existing student data
$result = mysqli_query($conn, "SELECT * FROM students WHERE user_id='$student_id'");
$student = mysqli_fetch_assoc($result);

include 'header.php';
?>

<main class="admin-dashboard-container">
    <?php include 'admin_sidebar.php'; ?>

    <div class="admin-content">
        <h1 class="admintitle">Edit Student</h1>

        <form action="edit_student_process.php" method="post" class="manual-form">
            <input type="hidden" name="user_id" value="<?php echo $student['user_id']; ?>">

            <label>Full Name:</label>
            <input type="text" name="full_name" value="<?php echo $student['full_name']; ?>" required>

            <label for="course">Course:</label>
            <select name="course" required>
                <option value="Zoology" <?php if($student['course']=='Zoology') echo 'selected'; ?>>Zoology</option>
                <option value="Botany" <?php if($student['course']=='Botany') echo 'selected'; ?>>Botany</option>
                <option value="Biochemistry" <?php if($student['course']=='Biochemistry') echo 'selected'; ?>>Biochemistry</option>
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

            <label>Roll Number:</label>
            <input type="text" name="roll_number" value="<?php echo $student['roll_number']; ?>">

            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $student['email']; ?>">

            <label>Phone:</label>
            <input type="text" name="phone_number" value="<?php echo $student['phone_number']; ?>">

            <input type="submit" name="update_student" value="Update Student">
        </form>
    </div>
</main>

<?php include 'footer.php'; ?>
