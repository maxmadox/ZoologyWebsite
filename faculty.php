<?php 
session_start();
include 'database/database.php';
include 'header.php';


$result = mysqli_query($conn, "SELECT * FROM teachers ORDER BY full_name ASC");
?>

<main class="faculty-container">
    <h1 class="faculty-title">Faculty</h1>

    <div class="faculty-list">
        <?php
        $i = 0; 
        while($teacher = mysqli_fetch_assoc($result)):
            $quals = explode(', ', $teacher['qualification'] ?? '');
            $quals_display = implode(', ', $quals);
            $experience = date('Y') - date('Y', strtotime($teacher['date_joined']));
        ?>
        <div class="faculty-item <?php echo $i % 2 == 0 ? 'image-left' : 'image-right'; ?>">
            <div class="faculty-image">
                <?php if(!empty($teacher['image_path'])): ?>
                    <img src="<?php echo $teacher['image_path']; ?>" alt="<?php echo $teacher['full_name']; ?>">
                <?php else: ?>
                    <img src="content/default.png" alt="Default Image">
                <?php endif; ?>
            </div>
            <div class="faculty-info">
                <h2><?php echo $teacher['full_name']; ?></h2>
                <p class="qualification"><?php echo $quals_display; ?></p>
                <p class="inspiring">Inspiring students since<br><?php echo $experience; ?> years.</p>
            </div>
        </div>
        <?php $i++; endwhile; ?>
    </div>
</main>

<?php include 'footer.php'; ?>
