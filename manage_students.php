<?php
session_start();

// Check if admin
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include 'database/database.php';
include 'header.php';

// --- Sorting & filtering ---
$sort_by = isset($_GET['sort']) ? $_GET['sort'] : 'user_id';
$order = isset($_GET['order']) ? $_GET['order'] : 'ASC';

// Only allow valid columns to prevent SQL injection
$valid_columns = ['user_id', 'full_name', 'semester'];
if(!in_array($sort_by, $valid_columns)) {
    $sort_by = 'user_id';
}
$order = strtoupper($order) === 'DESC' ? 'DESC' : 'ASC';

// Filters
$filter_semester = isset($_GET['filter_semester']) ? $_GET['filter_semester'] : '';
$filter_course = isset($_GET['filter_course']) ? $_GET['filter_course'] : '';
$filter_year = isset($_GET['filter_year']) ? $_GET['filter_year'] : '';

// Pagination
$limit = 10;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

// Build WHERE clause for filters
$where = [];
if($filter_semester) $where[] = "semester='$filter_semester'";
if($filter_course) $where[] = "course='$filter_course'";
if($filter_year) $where[] = "year='$filter_year'";

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
if($search) {
    $where[] = "(full_name LIKE '%$search%' OR roll_number LIKE '%$search%')";
}

$where_sql = $where ? "WHERE " . implode(" AND ", $where) : "";

// Total rows for pagination
$total_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM students $where_sql");
$total_row = mysqli_fetch_assoc($total_result);
$total_pages = ceil($total_row['total'] / $limit);

// Fetch students
$query = "SELECT * FROM students $where_sql ORDER BY $sort_by $order LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);

// Arrow icons
$arrow_up = "&#9650;";
$arrow_down = "&#9660;";
?>

<main class="admin-dashboard-container">
    <?php include 'admin_sidebar.php'; ?>

    <div class="admin-content">
        <div class="title-row">
            <h1 class="admintitle">Manage Students</h1>

            <form method="GET" class="filters-form">

                <!-- Delete All Button -->
                <a href="delete_all.php?filter_semester=<?php echo $filter_semester ?>&filter_course=<?php echo $filter_course ?>&filter_year=<?php echo $filter_year ?>&search=<?php echo urlencode($search); ?>" class="delete">Delete All</a>

                <select name="filter_semester" class="filter-select">
                    <option value="">All Semesters</option>
                    <?php for($i=1;$i<=6;$i++): ?>
                        <option value="<?php echo $i ?>" <?php if($filter_semester==$i) echo "selected"; ?>>Semester <?php echo $i ?></option>
                    <?php endfor; ?>
                </select>

                <select name="filter_course" class="filter-select">
                    <option value="">All Courses</option>
                    <option value="Zoology" <?php if($filter_course=='Zoology') echo "selected"; ?>>Zoology</option>
                    <option value="Botany" <?php if($filter_course=='Botany') echo "selected"; ?>>Botany</option>
                    <option value="Biochemistry" <?php if($filter_course=='Biochemistry') echo "selected"; ?>>Biochemistry</option>
                </select>

                <input type="text" name="search" placeholder="Search by Name or Roll" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" class="filter-input">

                <input type="text" name="filter_year" placeholder="Year" value="<?php echo htmlspecialchars($filter_year); ?>" class="filter-input">

                <input type="submit" value="Filter" class="filter-submit">
            </form>

            <a href="add_student.php" class="add-button">Add New Student</a>
        </div>

        <!-- Student Table -->
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
                        'roll_number'=>'Roll Number',
                        'email'=>'Email',
                        'phone_number'=>'Phone'
                    ];
                    foreach($columns as $col=>$label):
                        $new_order = ($sort_by==$col && $order=='ASC') ? 'DESC' : 'ASC';
                        $arrow = '';
                        if($sort_by==$col) $arrow = $order=='ASC' ? $arrow_up : $arrow_down;
                        echo "<th><a href='?sort=$col&order=$new_order&filter_semester=$filter_semester&filter_course=$filter_course&filter_year=$filter_year' class='sort-link'>$label $arrow</a></th>";
                    endforeach;
                    ?>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['user_id']; ?></td>
                    <td><?php echo $row['full_name']; ?></td>
                    <td><?php echo $row['course']; ?></td>
                    <td><?php echo $row['semester']; ?></td>
                    <td><?php echo $row['year']; ?></td>
                    <td><?php echo $row['roll_number']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['phone_number']; ?></td>
                    <td>
                        <a href="edit_student.php?id=<?php echo $row['user_id']; ?>" class="edit">Edit</a>
                        <a href="delete_student.php?id=<?php echo $row['user_id']; ?>" class="delete">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination">
            <?php if($page>1): ?>
                <a href="?page=<?php echo $page-1 ?>&sort=<?php echo $sort_by ?>&order=<?php echo $order ?>&filter_semester=<?php echo $filter_semester ?>&filter_course=<?php echo $filter_course ?>&filter_year=<?php echo $filter_year ?>" class="page-link">Prev</a>
            <?php endif; ?>

            <?php for($p=1;$p<=$total_pages;$p++): ?>
                <a href="?page=<?php echo $p ?>&sort=<?php echo $sort_by ?>&order=<?php echo $order ?>&filter_semester=<?php echo $filter_semester ?>&filter_course=<?php echo $filter_course ?>&filter_year=<?php echo $filter_year ?>" class="page-link <?php if($page==$p) echo 'active'; ?>"><?php echo $p ?></a>
            <?php endfor; ?>

            <?php if($page<$total_pages): ?>
                <a href="?page=<?php echo $page+1 ?>&sort=<?php echo $sort_by ?>&order=<?php echo $order ?>&filter_semester=<?php echo $filter_semester ?>&filter_course=<?php echo $filter_course ?>&filter_year=<?php echo $filter_year ?>" class="page-link">Next</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <p>Are you sure you want to delete this student?</p>
            <div class="modal-buttons">
                <button id="confirmDelete">Yes, Delete</button>
                <button id="cancelDelete">Cancel</button>
            </div>
        </div>
    </div>
</main>

<script>
let studentIdToDelete = null;
let deleteAllUrl = null;

const modal = document.getElementById('deleteModal');
const confirmBtn = document.getElementById('confirmDelete');
const cancelBtn = document.getElementById('cancelDelete');

// Single delete
document.querySelectorAll('a.delete').forEach(link => {
    link.addEventListener('click', function(e) {
        if(this.classList.contains('delete-all')) return; // skip Delete All link
        e.preventDefault();
        studentIdToDelete = this.getAttribute('href');
        modal.querySelector('p').textContent = 'Are you sure you want to delete this student?';
        modal.style.display = 'flex';
    });
});

// Delete All
const deleteAllBtn = document.querySelector('a.delete-all');
if(deleteAllBtn){
    deleteAllBtn.addEventListener('click', function(e) {
        e.preventDefault();
        deleteAllUrl = this.getAttribute('href');
        modal.querySelector('p').textContent = 'Are you sure you want to delete all students in this filter?';
        modal.style.display = 'flex';
    });
}

// Confirm button
confirmBtn.addEventListener('click', function() {
    if(studentIdToDelete) {
        window.location.href = studentIdToDelete;
    } else if(deleteAllUrl) {
        window.location.href = deleteAllUrl;
    }
});

// Cancel button
cancelBtn.addEventListener('click', function() {
    modal.style.display = 'none';
    studentIdToDelete = null;
    deleteAllUrl = null;
});

// Close modal on outside click
window.addEventListener('click', function(e) {
    if(e.target == modal){
        modal.style.display = 'none';
        studentIdToDelete = null;
        deleteAllUrl = null;
    }
});
</script>

<?php include 'footer.php'; ?>
