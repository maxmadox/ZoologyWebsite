<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include 'database/database.php';
include 'header.php';
?>  

<main class="add-teacher-view">
    <?php include 'admin_sidebar.php'; ?>

    <div class="add-teacher-content">
        <div class="add-teacher-row">
            <h1 class="add-teacher-title">Add New Teacher</h1>

           
            <form action="add_teacher_process.php" method="post" enctype="multipart/form-data" class="excel-upload-form">
                <label class="upload-excel-btn">
                    <img src="content/excel.png" alt="Excel" class="excelicon">
                    Excel/CSV
                    <input type="file" name="teacher_file" accept=".csv" onchange="this.form.submit()">
                </label>
                <input type="hidden" name="upload_file" value="1">
            </form>
        </div>

       
        <?php if(isset($_GET['error'])): ?>
            <?php if($_GET['error'] == 'duplicate'): ?>
                <div class="popup">
                    <div class="popup-content">
                        <p>Teacher with this Email already exists!</p>
                        <button onclick="document.querySelector('.popup').style.display='none'">OK</button>
                    </div>
                </div>
            <?php elseif($_GET['error'] == 'invalidfile'): ?>
                <div class="popup">
                    <div class="popup-content">
                        <p>Invalid file type! Only CSV is allowed.</p>
                        <button onclick="document.querySelector('.popup').style.display='none'">OK</button>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>

       
        <form action="add_teacher_process.php" method="post" class="manual-form" enctype="multipart/form-data">
            <label>Full Name:</label>
            <input type="text" name="full_name" required>

            <label>DOB:</label>
            <input type="date" name="dob" required>

            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Phone:</label>
            <input type="text" name="phone_number" required>

            
            <label>Qualification:</label>
            <div class="qualification-options">
                <label class="qualification-label"><input type="checkbox" name="qualification[]" value="B.Sc"> B.Sc</label>
                <label class="qualification-label"><input type="checkbox" name="qualification[]" value="M.Sc"> M.Sc</label>
                <label class="qualification-label"><input type="checkbox" name="qualification[]" value="Ph.D"> Ph.D</label>

                
                <label class="qualification-label">
                    <input type="checkbox" id="otherCheck" name="qualification[]" value="Other"> Other
                </label>
                <input type="text" id="otherInput" name="other_qualification" placeholder="Specify other qualification" class="other-input">
            </div>

            <label>Date Joined:</label>
            <input type="date" name="date_joined" required>

            <label>Profile Image:</label>
            <input type="file" name="teacher_image" accept="image/*">

            <input type="submit" name="add_teacher" value="Add Teacher">
        </form>

        <script>
            
            const otherCheck = document.getElementById('otherCheck');
            const otherInput = document.getElementById('otherInput');
            otherInput.style.display = 'none'; 

            otherCheck.addEventListener('change', function() {
                otherInput.style.display = this.checked ? 'block' : 'none';
            });
        </script>

    </div>
</main>

<?php include 'footer.php'; ?>
