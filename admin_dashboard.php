<?php
session_start();


if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}


include 'database/database.php';


$student_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM students"))['total'];
$teacher_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM teachers"))['total'];
$notice_count  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM notices"))['total'];


$semesters_result = mysqli_query($conn, "SELECT DISTINCT semester FROM students ORDER BY semester ASC");
$all_semesters = [];
while($s = mysqli_fetch_assoc($semesters_result)) {
    $all_semesters[] = $s['semester'];
}

$courses_result = mysqli_query($conn, "SELECT DISTINCT course FROM students ORDER BY course ASC");
$all_courses = [];
while($c = mysqli_fetch_assoc($courses_result)){
    $all_courses[] = $c['course'];
}

$chart_datasets = [];


$green_shades = [
    'rgba(2,48,49,0.8)',   
    'rgba(0,168,107,0.8)'  
];

$green_border_shades = [
    'rgba(2,48,49,1)',
    'rgba(0,168,107,1)'
];

$course_index = 0;

foreach($all_courses as $course) {
    $data = [];
    foreach($all_semesters as $sem) {
        $row = mysqli_fetch_assoc(mysqli_query($conn, "
            SELECT COUNT(*) AS student_count
            FROM students
            WHERE course='$course' AND semester='$sem'
        "));
        $data[] = $row['student_count'] ?? 0;
    }

    $chart_datasets[] = [
        'label' => $course,
        'data' => $data,
        'backgroundColor' => $green_shades[$course_index % 2],
        'borderColor' => $green_border_shades[$course_index % 2],
        'borderWidth' => 1
    ];
    $course_index++;
}

include 'header.php';
?>

<main class="admin-dashboard-view">
    <?php include 'admin_sidebar.php'; ?>
    <div class="admin-contents">
        
        <h1 class="admin-title">Admin Dashboard</h1>

        <div class="admin-dashboard-stats">
            <div class="admin-stats" onclick="location.href='manage_students.php'">
                <h2>Total Students</h2>
                <p><?php echo $student_count; ?></p>
            </div>
            <div class="admin-stats" onclick="location.href='manage_teachers.php'">
                <h2>Total Teachers</h2>
                <p><?php echo $teacher_count; ?></p>
            </div>
            <div class="admin-stats" onclick="location.href='manage_notices.php'">
                <h2>Total Notices</h2>
                <p><?php echo $notice_count; ?></p>
            </div>
        </div>

        
        <div class="admin-chart-container">
            <h3>Students Per Semester</h3>
            <canvas id="dynamicChart"></canvas>
        </div>

    </div>
</main>

<?php include 'footer.php'; ?>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('dynamicChart').getContext('2d');

const labels = <?php echo json_encode(array_map(fn($s) => 'Sem '.$s, $all_semesters)); ?>;
const datasets = <?php echo json_encode($chart_datasets); ?>;

new Chart(ctx, {
    type: 'bar',
    data: { labels: labels, datasets: datasets },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: { 
            x: { stacked: false }, 
            y: { beginAtZero: true, stepSize: 1 } 
        }
    }
});
</script>
