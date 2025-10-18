<?php
include 'database/database.php';
include 'header.php';

// Fetch notices
$result = mysqli_query($conn, "SELECT * FROM notices ORDER BY date DESC");
?>

<main class="admin-dashboard-container">
    <div class="admin-content">
        <h1 class="admintitle" style="text-align:center;">Notices</h1>

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
                            <a href="uploads/<?php echo $row['file_path']; ?>" target="_blank" class="edit">View</a>
                            <a href="uploads/<?php echo $row['file_path']; ?>" download class="edit">Download</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</main>

<?php include 'footer.php'; ?>
