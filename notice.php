<?php
include 'database/database.php';
include 'header.php';


$result = mysqli_query($conn, "SELECT * FROM notices ORDER BY date DESC");
?>

<main class="notice-page-view">
    <div class="notice-table-content">
        <h1 class="notice-title">Notices</h1>

        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Title</th>
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
                            <a href="<?php echo $row['file_path']; ?>" download class="edit">Download</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</main>

<?php include 'footerdisplay.php'; ?>
