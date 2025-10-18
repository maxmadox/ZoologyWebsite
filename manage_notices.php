<?php
session_start();
include 'database/database.php';
include 'header.php';

// Check if admin
$is_admin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

// Sorting
$sort_by = isset($_GET['sort']) ? $_GET['sort'] : 'date';
$order = isset($_GET['order']) ? $_GET['order'] : 'DESC';
$valid_columns = ['date', 'title'];
if (!in_array($sort_by, $valid_columns)) $sort_by = 'date';
$order = strtoupper($order) === 'ASC' ? 'ASC' : 'DESC';

// Pagination
$limit = 10;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

// Total rows
$total_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM notices");
$total_row = mysqli_fetch_assoc($total_result);
$total_pages = ceil($total_row['total'] / $limit);

// Fetch notices
$query = "SELECT * FROM notices ORDER BY $sort_by $order LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);

$arrow_up = "&#9650;";
$arrow_down = "&#9660;";
?>

<main class="admin-dashboard-container">
    <?php if($is_admin) include 'admin_sidebar.php'; ?>

    <div class="<?php echo $is_admin ? 'admin-content' : 'public-content'; ?>">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h1 class="admintitle">Manage Notices</h1>
            <?php if($is_admin): ?>
                <a href="create_notice.php" class="add-button">Create Notice</a>
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
                            <a href="<?php echo $row['file_path']; ?>" target="_blank" class="edit">View</a>
                            <?php if($is_admin): ?>
                                <a href="delete_notice.php?id=<?php echo $row['id']; ?>" class="delete">Delete</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Pagination -->
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

<?php include 'footer.php'; ?>
