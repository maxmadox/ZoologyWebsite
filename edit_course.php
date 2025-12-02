<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role']!=='admin'){
    header('Location: login.php');
    exit();
}

include 'database/database.php';
include 'header.php';

$type = $_GET['type'] ?? '';
$id = intval($_GET['id'] ?? 0);

if(!in_array($type,['bsc','msc']) || !$id){
    die("Invalid request");
}

$table = $type==='bsc' ? 'bsc_courses' : 'msc_courses';
$result = $conn->query("SELECT * FROM $table WHERE id=$id");
$course = $result->fetch_assoc();
if(!$course) die("Course not found");
?>

<main class="edit-course-view">
    <?php include 'admin_sidebar.php'; ?>
    <div class="edit-course-content">
        <h2 class="edit-course-title">Edit Course</h2>
        <div class="edit-course-card">
            <form method="POST" action="edit_courses_process.php?type=<?php echo $type; ?>&id=<?php echo $id; ?>">
                <label for="class">Class</label>
                <input id="class" name="class" type="text" required value="<?php echo htmlspecialchars($course['class']); ?>">

                <label for="papers">Paper Titles</label>
                <textarea id="papers" name="papers"  required><?php echo htmlspecialchars($course['papers']); ?></textarea>

                <button type="submit" class="btn-update">Save Changes</button>
            </form>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>
