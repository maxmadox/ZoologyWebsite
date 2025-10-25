<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include 'header.php';

$type = $_GET['type'] ?? '';
if(!in_array($type, ['bsc','msc'])){
    echo "<p style='color:red; text-align:center; padding:20px;'>Invalid course type.</p>";
    include 'footer.php';
    exit();
}

$title = $type==='bsc' ? 'Add B.Sc Course' : 'Add M.Sc Course';
?>

<main class="add-course-view">
    <?php include 'admin_sidebar.php'; ?>
    <div class="add-course-content">
        <h2 class="add-course-title"><?php echo $title; ?></h2>
        <div class="add-course-card">
            <form method="POST" action="add_course_process.php?type=<?php echo $type; ?>">
                <label for="class">Class</label>
                <input id="class" name="class" type="text" required placeholder="e.g. B.Sc 1st Year">

                <label for="papers">Paper Titles</label>
                <textarea id="papers" name="papers"  required placeholder="Enter papers"></textarea>

                <button type="submit" class="btn-update">Add Course</button>
            </form>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>
