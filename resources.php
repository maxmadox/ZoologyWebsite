<?php
include 'database/database.php';
include 'header.php';


$result = mysqli_query($conn, "SELECT * FROM resources ORDER BY date DESC");
?>

<main class="resource-page-view">
    <div class="resource-table-content">
        <h1 class="resource-title">Resources</h1>

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
                            <?php if($row['type'] == 'file'): ?>
                                <a href="<?php echo htmlspecialchars($row['file_path']); ?>" target="_blank" class="edit">View</a>
                            <?php else: ?>
                                <a href="<?php echo htmlspecialchars($row['link_url']); ?>" target="_blank" class="edit">Open Link</a>
                            <?php endif; ?>
                             <?php if($row['type'] == 'file'): ?>
                                <a href="<?php echo htmlspecialchars($row['file_path']); ?>" download class="edit">Download</a>
                            <?php else: ?>
                                
                            <?php endif; ?>
                        </td>
                        
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</main>

<?php include 'footerdisplay.php'; ?>
