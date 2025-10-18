<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include 'database/database.php';
include 'header.php';
?>  

<main class="admin-dashboard-container">
    <?php include 'admin_sidebar.php'; ?>

    <?php if(isset($_GET['error'])): ?>
        <?php if($_GET['error'] == 'duplicate'): ?>
            <div class="popup" style="display:flex;">
                <div class="popup-content">
                    <p>Student with this Roll Number already exists!</p>
                    <button onclick="document.querySelector('.popup').style.display='none'">OK</button>
                </div>
            </div>
        <?php elseif($_GET['error'] == 'invalidfile'): ?>
            <div class="popup" style="display:flex;">
                <div class="popup-content">
                    <p>Invalid file type! Only CSV is allowed.</p>
                    <button onclick="document.querySelector('.popup').style.display='none'">OK</button>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="admin-content">
        <!-- Header: Title + Excel Upload -->
        <div class="add-student-header">
            <h1 class="admintitle">Add New Student</h1>

            <!-- Upload Form -->
            <form action="add_student_process.php" method="post" enctype="multipart/form-data">
                <label class="upload-excel-btn">
                    <img src="content/excel.png" alt="Excel" class="excelicon">
                    Excel/CSV
                    <input type="file" name="student_file" accept=".csv" onchange="this.form.submit()">
                </label>
                <input type="hidden" name="upload_file" value="1">
            </form>
        </div>

        <!-- Manual form -->
        <form action="add_student_process.php" method="post" class="manual-form">
            <label>Full Name:</label>
            <input type="text" name="full_name" required>

            <label for="course">Course:</label>
            <select name="course" id="course" required>
                <option value="">Select Course</option>
                <option value="Zoology">Zoology</option>
                <option value="Botany">Botany</option>
                <option value="Biochemistry">Biochemistry</option>
            </select>

            <label for="semester">Semester:</label>
            <select name="semester" id="semester" required>
                <option value="">Select Semester</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
            </select>

            <label for="dob">DOB:</label>
            <input type="date" name="dob" required>

            <label>Year:</label>
            <input type="text" name="year">

            <label>Roll Number:</label>
            <input type="text" name="roll_number">

            <label>Email:</label>
            <input type="email" name="email">

            <label>Phone:</label>
            <input type="text" name="phone_number">

            <input type="submit" name="add_student" value="Add Student">
        </form>
    </div>
</main>

<?php include 'footer.php'; ?>
