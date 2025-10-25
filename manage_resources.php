<?php
session_start();
include 'database/database.php';
include 'header.php';


$is_teacher = isset($_SESSION['role']) && $_SESSION['role'] === 'teacher';


$sort_by = isset($_GET['sort']) ? $_GET['sort'] : 'date';
$order = isset($_GET['order']) ? $_GET['order'] : 'DESC';
$valid_columns = ['date', 'title'];
if (!in_array($sort_by, $valid_columns)) $sort_by = 'date';
$order = strtoupper($order) === 'ASC' ? 'ASC' : 'DESC';


$limit = 10;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;


$total_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM resources");
$total_row = mysqli_fetch_assoc($total_result);
$total_pages = ceil($total_row['total'] / $limit);


$query = "SELECT * FROM resources ORDER BY $sort_by $order LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);

$arrow_up = "&#9650;";
$arrow_down = "&#9660;";
?>

<main class="manage-resource-view">
    <?php if($is_teacher) include 'teacher_sidebar.php'; ?>

    <div class="<?php echo $is_teacher ? 'manage-resource-content' : 'public-content'; ?>">
        <div class="manage-resource-row">
            <h1 class="manage-resource-title">Manage Resources</h1>
            <?php if($is_teacher): ?>
                <a href="create_resource.php" class="add-button">Add Resource</a>
            <?php endif; ?>
        </div>

        <table>
            <thead>
                <tr>
                    <th>
                        <a href="?sort=date&order=<?php echo $sort_by=='date' && $order=='ASC'?'DESC':'ASC'; ?>">
                            Date <?php if($sort_by=='date') echo $order=='ASC'?$arrow_up:$arrow_down; ?>
                        </a>
                    </th>
                    <th>
                        <a href="?sort=title&order=<?php echo $sort_by=='title' && $order=='ASC'?'DESC':'ASC'; ?>">
                            Title <?php if($sort_by=='title') echo $order=='ASC'?$arrow_up:$arrow_down; ?>
                        </a>
                    </th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td class="actions-cell">
                            <?php if($row['type'] == 'file'): ?>
                                <a href="<?php echo htmlspecialchars($row['file_path']); ?>" target="_blank" class="edit">View</a>
                            <?php else: ?>
                                <a href="<?php echo htmlspecialchars($row['link_url']); ?>" target="_blank" class="edit">Open Link</a>
                            <?php endif; ?>
                            <?php if($is_teacher): ?>
                                <a href="delete_resource.php?id=<?php echo $row['id']; ?>" class="delete">Delete</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        
        <div class="pagination">
            <?php if($page>1): ?>
                <a href="?page=<?php echo $page-1 ?>&sort=<?php echo $sort_by ?>&order=<?php echo $order ?>" class="page-link">Prev</a>
            <?php endif; ?>

            <?php for($p=1; $p<=$total_pages; $p++): ?>
                <a href="?page=<?php echo $p ?>&sort=<?php echo $sort_by ?>&order=<?php echo $order ?>" class="page-link <?php if($page==$p) echo 'active'; ?>"><?php echo $p ?></a>
            <?php endfor; ?>

            <?php if($page<$total_pages): ?>
                <a href="?page=<?php echo $page+1 ?>&sort=<?php echo $sort_by ?>&order=<?php echo $order ?>" class="page-link">Next</a>
            <?php endif; ?>
        </div>
    </div>
</main>


<div id="deleteModal" class="modal">
    <div class="modal-content">
        <p>Are you sure you want to delete this resource?</p>
        <div class="modal-buttons">
            <button id="confirmDelete">Yes, Delete</button>
            <button id="cancelDelete">Cancel</button>
        </div>
    </div>
</div>

<script>
let deleteUrl = null;
const modal = document.getElementById('deleteModal');


document.querySelectorAll('a.delete').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        deleteUrl = this.href;
        modal.style.display = 'flex';
    });
});


document.getElementById('confirmDelete').addEventListener('click', function() {
    if(deleteUrl) window.location.href = deleteUrl;
});


document.getElementById('cancelDelete').addEventListener('click', function() {
    modal.style.display = 'none';
    deleteUrl = null;
});


window.addEventListener('click', function(e) {
    if(e.target === modal){
        modal.style.display = 'none';
        deleteUrl = null;
    }
});
</script>

<?php include 'footer.php'; ?>

