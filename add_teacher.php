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

    <div class="admin-content">
        <div class="add-student-header">
            <h1 class="admintitle">Add New Teacher</h1>

            <!-- Excel/CSV Upload button -->
            <form action="add_teacher_process.php" method="post" enctype="multipart/form-data" style="display:flex; align-items:center;">
                <label class="upload-excel-btn">
                    <img src="content/excel.png" alt="Excel" class="excelicon">
                    Excel/CSV
                    <input type="file" name="teacher_file" accept=".csv" onchange="this.form.submit()">
                </label>
                <input type="hidden" name="upload_file" value="1">
            </form>
        </div>

        <!-- Popup for duplicate or invalid file -->
        <?php if(isset($_GET['error'])): ?>
            <?php if($_GET['error'] == 'duplicate'): ?>
                <div class="popup" style="display:flex;">
                    <div class="popup-content">
                        <p>Teacher with this Email already exists!</p>
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

        <!-- Manual entry form -->
        <form action="add_teacher_process.php" method="post" class="manual-form">
            <label>Full Name:</label>
            <input type="text" name="full_name" required>

            <label>DOB:</label>
            <input type="date" name="dob" required>

            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Phone:</label>
            <input type="text" name="phone_number" required>

            <input type="submit" name="add_teacher" value="Add Teacher">
        </form>
    </div>
</main>

<?php include 'footer.php'; ?>
