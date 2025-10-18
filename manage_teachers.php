<?php
session_start();

if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include 'database/database.php';
include 'header.php';

// --- Sorting & search ---
$sort_by = isset($_GET['sort']) ? $_GET['sort'] : 'full_name';
$order = isset($_GET['order']) ? $_GET['order'] : 'ASC';

// Only allow valid columns
$valid_columns = ['user_id', 'full_name', 'dob', 'email', 'phone_number'];
if(!in_array($sort_by, $valid_columns)) $sort_by = 'full_name';
$order = strtoupper($order) === 'DESC' ? 'DESC' : 'ASC';

// Search
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Pagination
$limit = 10;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

// Build WHERE clause
$where = [];
if($search) {
    $where[] = "(full_name LIKE '%$search%' OR user_id LIKE '%$search%')";
}
$where_sql = $where ? "WHERE " . implode(" AND ", $where) : "";

// Total rows for pagination
$total_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM teachers $where_sql");
$total_row = mysqli_fetch_assoc($total_result);
$total_pages = ceil($total_row['total'] / $limit);

// Fetch teachers
$query = "SELECT * FROM teachers $where_sql ORDER BY $sort_by $order LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);

// Arrow icons
$arrow_up = "&#9650;";
$arrow_down = "&#9660;";
?>

<main class="admin-dashboard-container">
    <?php include 'admin_sidebar.php'; ?>

    <div class="admin-content">
        <div class="title-row">
            <h1 class="admintitle">Manage Teachers</h1>

            <!-- Search box -->
            <form method="GET" class="filters-form">
                <input type="text" name="search" placeholder="Search by Name or ID" value="<?php echo htmlspecialchars($search); ?>" class="filter-input">
                
                <input type="submit" value="Filter" class="filter-submit">
            </form>

            <a href="add_teacher.php" class="add-button">Add New Teacher</a>
        </div>

        <!-- Teacher Table -->
        <table>
            <thead>
                <tr>
                    <?php
                    $columns = [
                        'user_id'=>'ID',
                        'full_name'=>'Name',
                        'dob'=>'DOB',
                        'email'=>'Email',
                        'phone_number'=>'Phone'
                    ];
                    foreach($columns as $col=>$label):
                        $new_order = ($sort_by==$col && $order=='ASC') ? 'DESC' : 'ASC';
                        $arrow = '';
                        if($sort_by==$col) $arrow = $order=='ASC' ? $arrow_up : $arrow_down;
                        echo "<th><a href='?sort=$col&order=$new_order&search=".urlencode($search)."' class='sort-link'>$label $arrow</a></th>";
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
                    <td><?php echo $row['dob']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['phone_number']; ?></td>
                    <td>
                        <a href="edit_teacher.php?id=<?php echo $row['user_id']; ?>" class="edit">Edit</a>
                        <a href="delete_teacher.php?id=<?php echo $row['user_id']; ?>" class="delete">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination">
            <?php if($page>1): ?>
                <a href="?page=<?php echo $page-1 ?>&sort=<?php echo $sort_by ?>&order=<?php echo $order ?>&search=<?php echo urlencode($search); ?>" class="page-link">Prev</a>
            <?php endif; ?>

            <?php for($p=1;$p<=$total_pages;$p++): ?>
                <a href="?page=<?php echo $p ?>&sort=<?php echo $sort_by ?>&order=<?php echo $order ?>&search=<?php echo urlencode($search); ?>" class="page-link <?php if($page==$p) echo 'active'; ?>"><?php echo $p ?></a>
            <?php endfor; ?>

            <?php if($page<$total_pages): ?>
                <a href="?page=<?php echo $page+1 ?>&sort=<?php echo $sort_by ?>&order=<?php echo $order ?>&search=<?php echo urlencode($search); ?>" class="page-link">Next</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <p>Are you sure you want to delete this teacher?</p>
            <div class="modal-buttons">
                <button id="confirmDelete">Yes, Delete</button>
                <button id="cancelDelete">Cancel</button>
            </div>
        </div>
    </div>
</main>

<script>
let teacherIdToDelete = null;
const modal = document.getElementById('deleteModal');
const confirmBtn = document.getElementById('confirmDelete');
const cancelBtn = document.getElementById('cancelDelete');

document.querySelectorAll('a.delete').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        teacherIdToDelete = this.getAttribute('href');
        modal.style.display = 'flex';
    });
});

confirmBtn.addEventListener('click', function() {
    if(teacherIdToDelete) window.location.href = teacherIdToDelete;
});

cancelBtn.addEventListener('click', function() {
    modal.style.display = 'none';
    teacherIdToDelete = null;
});

window.addEventListener('click', function(e) {
    if(e.target == modal){
        modal.style.display = 'none';
        teacherIdToDelete = null;
    }
});
</script>

<?php include 'footer.php'; ?>
