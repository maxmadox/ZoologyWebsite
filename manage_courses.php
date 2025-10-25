<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include 'database/database.php';
include 'header.php';
?>  

<main class="manage-course-view">
    <?php include 'admin_sidebar.php'; ?>

    <div class="manage-course-content">
        <div class="manage-course-row">
            <h1 class="manage-course-title">Manage Courses</h1>
                <a href="edit_internal_marks.php" class="add-button">Edit Marks</a>
        </div>

        <?php
        $bscCourses = $conn->query("SELECT * FROM bsc_courses ORDER BY id ASC")->fetch_all(MYSQLI_ASSOC);
        $mscCourses = $conn->query("SELECT * FROM msc_courses ORDER BY id ASC")->fetch_all(MYSQLI_ASSOC);

        $bscMarks = $conn->query("SELECT marks_info FROM internal_marks WHERE course_type='bsc'")->fetch_assoc()['marks_info'] ?? '';
        $mscMarks = $conn->query("SELECT marks_info FROM internal_marks WHERE course_type='msc'")->fetch_assoc()['marks_info'] ?? '';
        ?>

        
        <div class="manage-course-table">
            <div class="manage-course-header">
                <div class="course-title">
                    <h2>B.Sc Courses</h2>
                </div>
                <div class="course-actions">
                    <span class="internal-marks">Internal Marks: <?php echo htmlspecialchars($bscMarks); ?></span>

                    <form action="upload_courses.php" method="POST" enctype="multipart/form-data" class="csv-form">
                        <input type="hidden" name="type" value="bsc">
                        <label class="course-upload-excel-btn">
                            <img src="content/excel.png" alt="Excel" class="excelicon">
                            CSV
                            <input type="file" name="course_csv" accept=".csv" onchange="this.form.submit()">
                        </label>
                    </form>

                    <a href="add_course.php?type=bsc" class="course-edit">Add Course</a>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>CLASS</th>
                        <th>PAPER TITLE</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bscCourses as $course): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($course['class']); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($course['papers'])); ?></td>
                            <td class="actions-cell">
                                <a href="edit_course.php?type=bsc&id=<?php echo $course['id']; ?>" class="edit">Edit</a>
                                <a href="delete_course.php?type=bsc&id=<?php echo $course['id']; ?>" class="delete">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        
        <div class="manage-course-table">
            <div class="manage-course-header">
                <div class="course-title">
                    <h2>M.Sc Courses</h2>
                </div>
                <div class="course-actions">
                    <span class="internal-marks">Internal Marks: <?php echo htmlspecialchars($mscMarks); ?></span>

                    <form action="upload_courses.php" method="POST" enctype="multipart/form-data" class="csv-form">
                        <input type="hidden" name="type" value="msc">
                        <label class="course-upload-excel-btn">
                            <img src="content/excel.png" alt="Excel" class="excelicon">
                            CSV
                            <input type="file" name="course_csv" accept=".csv" onchange="this.form.submit()">
                        </label>
                    </form>

                    <a href="add_course.php?type=msc" class="course-edit">Add Course</a>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>CLASS</th>
                        <th>PAPER TITLE</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($mscCourses as $course): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($course['class']); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($course['papers'])); ?></td>
                            <td class="actions-cell">
                                <a href="edit_course.php?type=msc&id=<?php echo $course['id']; ?>" class="edit">Edit</a>
                                <a href="delete_course.php?type=msc&id=<?php echo $course['id']; ?>" class="delete">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <p>Are you sure you want to delete this course?</p>
        <div class="modal-buttons">
            <button id="confirmDelete">Yes, Delete</button>
            <button id="cancelDelete">Cancel</button>
        </div>
    </div>
</div>

<script>
let deleteUrl = null;
const modal = document.getElementById('deleteModal');

// Attach to all delete buttons
document.querySelectorAll('a.delete').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        deleteUrl = this.href;
        modal.style.display = 'flex';
    });
});

// Confirm deletion
document.getElementById('confirmDelete').addEventListener('click', function() {
    if(deleteUrl) window.location.href = deleteUrl;
});

// Cancel deletion
document.getElementById('cancelDelete').addEventListener('click', function() {
    modal.style.display = 'none';
    deleteUrl = null;
});

// Close modal on outside click
window.addEventListener('click', function(e) {
    if(e.target === modal){
        modal.style.display = 'none';
        deleteUrl = null;
    }
});
</script>

<?php include 'footer.php'; ?>
