<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include 'database/database.php';
include 'header.php';


$bscMarks = $conn->query("SELECT marks_info FROM internal_marks WHERE course_type='bsc'")->fetch_assoc()['marks_info'] ?? '';
$mscMarks = $conn->query("SELECT marks_info FROM internal_marks WHERE course_type='msc'")->fetch_assoc()['marks_info'] ?? '';
?>

<main class="edit-marks-view">
    <?php include 'admin_sidebar.php'; ?>

    <div class="edit-marks-content">
        <h2 class="edit-marks-title">Edit Internal Marks</h2>
        <div class="edit-marks-card">
            <form method="POST" action="edit_internal_marks_process.php">
                <label for="bsc_marks">B.Sc Internal Marks</label>
                <textarea id="bsc_marks" name="bsc_marks" ><?php echo htmlspecialchars($bscMarks); ?></textarea>

                <label for="msc_marks">M.Sc Internal Marks</label>
                <textarea id="msc_marks" name="msc_marks" ><?php echo htmlspecialchars($mscMarks); ?></textarea>

                <button type="submit" class="btn-update">Save</button>
            </form>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>
