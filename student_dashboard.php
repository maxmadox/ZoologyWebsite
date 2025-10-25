<?php
session_start();


if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header('Location: login.php');
    exit();
}

include 'database/database.php';
include 'header.php';


$current_user_id = $_SESSION['user_id'];


$user_query = mysqli_query($conn, "SELECT username FROM users WHERE id = $current_user_id");
$user = mysqli_fetch_assoc($user_query);
$username = $user['username'];


$student_query = mysqli_query($conn, "SELECT user_id FROM students WHERE snp_id = '$username'");
$student = mysqli_fetch_assoc($student_query);
$student_id = $student['user_id']; 


$month = isset($_GET['month']) ? $_GET['month'] : date('Y-m'); 
$start_date = $month . '-01';
$end_date = date("Y-m-t", strtotime($start_date));

$attendance_result = mysqli_query($conn, "
    SELECT date, status 
    FROM attendance 
    WHERE student_id = $student_id
      AND date BETWEEN '$start_date' AND '$end_date'
");


$attendance_data = [];
while($row = mysqli_fetch_assoc($attendance_result)) {
    $attendance_data[$row['date']] = $row['status'];
}


$total_present = 0;
$total_absent = 0;
foreach($attendance_data as $status){
    if($status === 'Present') $total_present++;
    if($status === 'Absent') $total_absent++;
}
$total_days = $total_present + $total_absent;
$attendance_percentage = $total_days ? round(($total_present / $total_days) * 100, 2) : 0;


$first_day_of_month = date('N', strtotime($start_date)); 
$days_in_month = date('t', strtotime($start_date));
?>

<main class="student-dashboard-view">
    <div class="student-contents">
        <div class="student-row">
            <h1 class="student-title">My Attendance</h1>
            

            
            <form method="GET" class="student-filter-form">
                
                <label for="month"></label>
                <a href="logout.php" class="delete">Logout</a>
                <input type="month" name="month" value="<?php echo $month; ?>" class="student-filter-input-date">
                <input type="submit" value="View" class="student-filter-submit">
            </form>
        </div>

        
        <div class="student-dashboard-stats">
            <div class="student-stats"><h2>Total Present</h2><p><?php echo $total_present; ?></p></div>
            <div class="student-stats"><h2>Total Absent</h2><p><?php echo $total_absent; ?></p></div>
            <div class="student-stats"><h2>Attendance</h2><p><?php echo $attendance_percentage; ?>%</p></div>
        </div>

       
         
        <div class="attendance-calendar">
            <table>
                        <thead>
                            <tr>
                                <th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th>
                                <th>Fri</th><th>Sat</th><th>Sun</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $day = 1;
                            $current_week_day = 1;

                            echo "<tr>";
                            
                            for($i=1; $i<$first_day_of_month; $i++){
                                echo "<td></td>";
                                $current_week_day++;
                            }

                            while($day <= $days_in_month){
                                $date_str = date('Y-m-d', strtotime($start_date . ' +'.($day-1).' days'));
                                $status = $attendance_data[$date_str] ?? '';

                                $cell_class = '';
                                $display = '';
                                if($status === 'Present'){
                                    $cell_class = 'present';
                                    $display = 'P';
                                } elseif($status === 'Absent'){
                                    $cell_class = 'absent';
                                    $display = 'A';
                                }

                                echo "<td class='$cell_class' data-day='$day'>$display</td>";

                                if($current_week_day == 7){
                                    echo "</tr><tr>";
                                    $current_week_day = 0;
                                }

                                $day++;
                                $current_week_day++;
                            }

                            
                            while($current_week_day <= 7 && $current_week_day != 1){
                                echo "<td></td>";
                                $current_week_day++;
                            }

                            echo "</tr>";
                            ?>
                        </tbody>
                    </table>
                </div> 
            </div>            
    </div>
</main>

<?php include 'footer.php'; ?>
