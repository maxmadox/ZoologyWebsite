<?php
session_start();

// Check if teacher
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    header('Location: login.php');
    exit();
}

include 'database/database.php';
include 'header.php';

$teacher_id = $_SESSION['user_id'];

// --- Filters & Sorting ---
$sort_by = isset($_GET['sort']) ? $_GET['sort'] : 'user_id';
$order = isset($_GET['order']) ? $_GET['order'] : 'ASC';
$valid_columns = ['user_id','full_name','semester'];
if(!in_array($sort_by, $valid_columns)) $sort_by = 'user_id';
$order = strtoupper($order) === 'DESC' ? 'DESC' : 'ASC';

// Filters
$filter_semester = isset($_GET['filter_semester']) ? $_GET['filter_semester'] : '';
$filter_course = isset($_GET['filter_course']) ? $_GET['filter_course'] : '';
$filter_year = isset($_GET['filter_year']) ? $_GET['filter_year'] : '';
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$attendance_date = isset($_GET['attendance_date']) ? $_GET['attendance_date'] : date('Y-m-d'); // persistent date

// Pagination
$limit = 10;
$page = isset($_GET['page']) ? max(1,intval($_GET['page'])) : 1;
$offset = ($page-1)*$limit;

// Build WHERE clause
$where = [];
if($filter_semester) $where[] = "semester='$filter_semester'";
if($filter_course) $where[] = "course='$filter_course'";
if($filter_year) $where[] = "year='$filter_year'";
if($search) $where[] = "(full_name LIKE '%$search%' OR snp_id LIKE '%$search%')";
$where_sql = $where ? "WHERE ".implode(" AND ", $where) : "";

// Total rows
$total_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM students $where_sql");
$total_row = mysqli_fetch_assoc($total_result);
$total_pages = ceil($total_row['total']/$limit);

// Fetch students
$query = "SELECT * FROM students $where_sql ORDER BY $sort_by $order LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn,$query);

// Handle POST attendance submission
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['attendance'])) {
    $attendance_date_post = $_POST['attendance_date'];
    foreach($_POST['attendance'] as $student_id => $status){
        $student_id = intval($student_id);
        $status = ($status==='Present') ? 'Present' : 'Absent';
        $stmt = mysqli_prepare($conn, "INSERT INTO attendance (student_id, teacher_id, date, status) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE status=?");
        mysqli_stmt_bind_param($stmt, "iisss", $student_id, $teacher_id, $attendance_date_post, $status, $status);
        mysqli_stmt_execute($stmt);
    }
    
}

// Arrow icons
$arrow_up = "&#9650;";
$arrow_down = "&#9660;";
?>

<main class="manage-attendance">
    <?php include 'teacher_sidebar.php'; ?>
    <div class="manage-attendance-content">
        <div class="manage-attendance-row">
            
            <h1 class="manage-attendance-title">Manage Attendance</h1>

            
            <form method="GET" class="attendance-filter-form-desktop">
                <input type="date" name="attendance_date" value="<?php echo $attendance_date; ?>" required class="attendance-filter-input-date">

                <select name="filter_semester" class="attendance-filter-select custom-arrow">
                    <option value="">All Semesters</option>
                    <?php for($i=1;$i<=6;$i++): ?>
                        <option value="<?php echo $i ?>" <?php if($filter_semester==$i) echo "selected"; ?>>Semester <?php echo $i ?></option>
                    <?php endfor; ?>
                </select>

                <select name="filter_course" class="attendance-filter-select custom-arrow">
                    <option value="">All Courses</option>
                    <option value="B.Sc" <?php if($filter_course=='B.Sc') echo "selected"; ?>>B.Sc</option>
                    <option value="M.Sc" <?php if($filter_course=='M.Sc') echo "selected"; ?>>M.Sc</option>
                </select>

                <input type="text" name="filter_year" placeholder="Year" value="<?php echo htmlspecialchars($filter_year); ?>" class="filter-input">
                <input type="text" name="search" placeholder="Search by Name or Roll" value="<?php echo htmlspecialchars($search); ?>" class="filter-input">

                <input type="submit" value="Filter" class="attendance-filter-submit">
            </form>

            
            <form method="GET" class="attendance-filter-form-mobile">
                <div class="attendance-filter-selects">
                    <input type="date" name="attendance_date" value="<?php echo $attendance_date; ?>" required class="attendance-filter-input-date">
                    <select name="filter_semester" class="attendance-filter-select custom-arrow">
                        <option value="">All Semesters</option>
                        <?php for($i=1;$i<=6;$i++): ?>
                            <option value="<?php echo $i ?>" <?php if($filter_semester==$i) echo "selected"; ?>>Semester <?php echo $i ?></option>
                        <?php endfor; ?>
                    </select>
                    <select name="filter_course" class="attendance-filter-select custom-arrow">
                        <option value="">All Courses</option>
                        <option value="B.Sc" <?php if($filter_course=='B.Sc') echo "selected"; ?>>B.Sc</option>
                        <option value="M.Sc" <?php if($filter_course=='M.Sc') echo "selected"; ?>>M.Sc</option>
                    </select>
                </div>

                <div class="attendance-filter-input">
                    <input type="text" name="filter_year" placeholder="Year" value="<?php echo htmlspecialchars($filter_year); ?>" class="filter-input">
                    <input type="text" name="search" placeholder="Search by Name or Roll" value="<?php echo htmlspecialchars($search); ?>" class="filter-input">
                </div>

                <input type="submit" value="Filter" class="attendance-filter-submit">
            </form>


            
            <button type="submit" form="attendance-form" class="add-attendance" >Save Attendance</button>
        </div>

        
        <form method="POST" id="attendance-form">
            <input type="hidden" name="attendance_date" value="<?php echo $attendance_date; ?>">
            <table>
                <thead>
                    <tr>
                        <?php
                        $columns = [
                            'user_id'=>'ID',
                            'full_name'=>'Name',
                            'course'=>'Course',
                            'semester'=>'Semester',
                            'year'=>'Year',
                            'snp_id'=>'SNP ID',
                            'email'=>'Email',
                            'phone_number'=>'Phone'
                        ];
                        foreach($columns as $col=>$label):
                            $new_order = ($sort_by==$col && $order=='ASC') ? 'DESC' : 'ASC';
                            $arrow = '';
                            if($sort_by==$col) $arrow = $order=='ASC' ? $arrow_up : $arrow_down;
                            echo "<th><a href='?sort=$col&order=$new_order&filter_semester=$filter_semester&filter_course=$filter_course&filter_year=$filter_year&attendance_date=$attendance_date' class='sort-link'>$label $arrow</a></th>";
                        endforeach;
                        ?>
                        <th>Attendance</th>
                        <th>Mark Attendance</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row=mysqli_fetch_assoc($result)):
                        $att_res = mysqli_query($conn,"SELECT status FROM attendance WHERE student_id={$row['user_id']} AND teacher_id=$teacher_id AND date='$attendance_date'");
                        $att_row = mysqli_fetch_assoc($att_res);
                        $status = $att_row ? $att_row['status'] : 'Present';
                    ?>
                    <tr>
                        <td><?php echo $row['user_id']; ?></td>
                        <td><?php echo $row['full_name']; ?></td>
                        <td><?php echo $row['course']; ?></td>
                        <td><?php echo $row['semester']; ?></td>
                        <td><?php echo $row['year']; ?></td>
                        <td><?php echo $row['snp_id']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['phone_number']; ?></td>

                        <td><?php echo $att_row ? $att_row['status'] : '-'; ?></td>

                        <td>
                            <label><input type="radio" name="attendance[<?php echo $row['user_id']; ?>]" value="Present" <?php if($status=='Present') echo 'checked'; ?>> Present</label>
                            <label><input type="radio" name="attendance[<?php echo $row['user_id']; ?>]" value="Absent" <?php if($status=='Absent') echo 'checked'; ?>> Absent</label>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </form>

        
        <div class="pagination">
            <?php if($page>1): ?>
                <a href="?page=<?php echo $page-1 ?>&sort=<?php echo $sort_by ?>&order=<?php echo $order ?>&filter_semester=<?php echo $filter_semester ?>&filter_course=<?php echo $filter_course ?>&filter_year=<?php echo $filter_year ?>&attendance_date=<?php echo $attendance_date ?>" class="page-link">Prev</a>
            <?php endif; ?>
            <?php for($p=1;$p<=$total_pages;$p++): ?>
                <a href="?page=<?php echo $p ?>&sort=<?php echo $sort_by ?>&order=<?php echo $order ?>&filter_semester=<?php echo $filter_semester ?>&filter_course=<?php echo $filter_course ?>&filter_year=<?php echo $filter_year ?>&attendance_date=<?php echo $attendance_date ?>" class="page-link <?php if($page==$p) echo 'active'; ?>"><?php echo $p ?></a>
            <?php endfor; ?>
            <?php if($page<$total_pages): ?>
                <a href="?page=<?php echo $page+1 ?>&sort=<?php echo $sort_by ?>&order=<?php echo $order ?>&filter_semester=<?php echo $filter_semester ?>&filter_course=<?php echo $filter_course ?>&filter_year=<?php echo $filter_year ?>&attendance_date=<?php echo $attendance_date ?>" class="page-link">Next</a>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>
