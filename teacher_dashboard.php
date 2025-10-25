<?php
session_start();


if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    header('Location: login.php');
    exit();
}

include 'database/database.php';
include 'header.php';

$teacher_id = $_SESSION['user_id'];


$attendance_date = isset($_GET['attendance_date']) ? $_GET['attendance_date'] : date('Y-m-d');
$course_filter = isset($_GET['course']) ? $_GET['course'] : '';
$semester_filter = isset($_GET['semester']) ? $_GET['semester'] : '';


$total_students_query = "SELECT COUNT(*) AS total FROM students WHERE 1";
if($course_filter) $total_students_query .= " AND course='$course_filter'";
if($semester_filter) $total_students_query .= " AND semester='$semester_filter'";
$total_students_result = mysqli_query($conn, $total_students_query);
$total_students_row = mysqli_fetch_assoc($total_students_result);
$total_students = $total_students_row['total'];


$total_present_query = "SELECT COUNT(*) AS present_count 
                        FROM attendance a 
                        JOIN students s ON a.student_id = s.user_id 
                        WHERE a.teacher_id=$teacher_id AND a.date='$attendance_date' AND a.status='Present'";
if($course_filter) $total_present_query .= " AND s.course='$course_filter'";
if($semester_filter) $total_present_query .= " AND s.semester='$semester_filter'";
$total_present_result = mysqli_query($conn, $total_present_query);
$total_present_row = mysqli_fetch_assoc($total_present_result);
$total_present = $total_present_row['present_count'];


$total_absent_query = "SELECT COUNT(*) AS absent_count 
                       FROM attendance a 
                       JOIN students s ON a.student_id = s.user_id 
                       WHERE a.teacher_id=$teacher_id AND a.date='$attendance_date' AND a.status='Absent'";
if($course_filter) $total_absent_query .= " AND s.course='$course_filter'";
if($semester_filter) $total_absent_query .= " AND s.semester='$semester_filter'";
$total_absent_result = mysqli_query($conn, $total_absent_query);
$total_absent_row = mysqli_fetch_assoc($total_absent_result);
$total_absent = $total_absent_row['absent_count'];


$attendance_percentage = $total_students ? round(($total_present/$total_students)*100,2) : 0;


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
            SELECT COUNT(a.id) AS present_count
            FROM attendance a
            JOIN students s ON a.student_id = s.user_id
            WHERE a.teacher_id=$teacher_id AND a.status='Present' AND s.course='$course' AND s.semester='$sem'
        "));
        $data[] = $row['present_count'] ?? 0;
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
?>

<main class="teacher-dashboard-view">
    <?php include 'teacher_sidebar.php'; ?>
    <div class="teacher-contents">
        <div class="teacher-row">
            <h1 class="teacher-title">Dashboard</h1>

            
            <form method="GET" class="teacher-filter-form-desktop">
                <label for="attendance_date">Date:</label>
                <input type="date" name="attendance_date" value="<?php echo $attendance_date; ?>" class="teacher-filter-input-date">

                <label for="course">Course:</label>
                <select name="course" class="teacher-filter-select custom-arrow">
                    <option value="">All</option>
                    <?php foreach($all_courses as $c): ?>
                        <option value="<?php echo $c; ?>" <?php if($course_filter==$c) echo 'selected'; ?>>
                            <?php echo $c; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="semester">Semester:</label>
                <select name="semester" class="teacher-filter-select custom-arrow">
                    <option value="">All</option>
                    <?php foreach($all_semesters as $s): ?>
                        <option value="<?php echo $s; ?>" <?php if($semester_filter==$s) echo 'selected'; ?>>
                            <?php echo $s; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <input type="submit" value="View" class="teacher-filter-submit">
            </form>

            
            <form method="GET" class="teacher-filter-form-mobile">
                <div class="teacher-filter-labels">
                    <label>Date</label>
                    <label>Course</label>
                    <label>Semester</label>
                </div>
                <div class="teacher-filter-inputs">
                    <input type="date" name="attendance_date" value="<?php echo $attendance_date; ?>" class="teacher-filter-input-date">

                    <select name="course" class="teacher-filter-select custom-arrow">
                        <option value="">All</option>
                        <?php foreach($all_courses as $c): ?>
                            <option value="<?php echo $c; ?>" <?php if($course_filter==$c) echo 'selected'; ?>>
                                <?php echo $c; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <select name="semester" class="teacher-filter-select custom-arrow">
                        <option value="">All</option>
                        <?php foreach($all_semesters as $s): ?>
                            <option value="<?php echo $s; ?>" <?php if($semester_filter==$s) echo 'selected'; ?>>
                                <?php echo $s; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <input type="submit" value="View" class="teacher-filter-submit">
            </form>

        </div>

       
        <div class="teacher-dashboard-stats">
            <div class="teacher-stats">
                <h3>Total Students</h3>
                <p><?php echo $total_students; ?></p>
            </div>
            <div class="teacher-stats">
                <h3>Total Present</h3>
                <p><?php echo $total_present; ?></p>
            </div>
            <div class="teacher-stats">
                <h3>Total Absent</h3>
                <p><?php echo $total_absent; ?></p>
            </div>
            <div class="teacher-stats">
                <h3>Attendance %</h3>
                <p><?php echo $attendance_percentage; ?>%</p>
            </div>
        </div>

        
        <div class="teacher-chart-container">
            <h3>Attendance Per Semester</h3>
            <canvas id="attendanceChart" width="800" height="350"></canvas>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('attendanceChart').getContext('2d');

const labels = <?php echo json_encode(array_map(fn($s) => 'Sem ' . $s, $all_semesters)); ?>;
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
