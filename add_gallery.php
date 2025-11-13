<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include 'database/database.php';
include 'header.php';
?>

<main class="create-gallery-view">
    <?php include 'admin_sidebar.php'; ?>

    <div class="create-gallery-content">
        <div class="add-gallery-header">
            <h1 class="create-gallery-title">Add New Image</h1>
        </div>

        <form action="add_gallery_process.php" method="post" enctype="multipart/form-data" class="manual-form">
            <label>Image Title:</label>
            <input type="text" name="title" required>

            <label>Upload Image (JPG/PNG):</label>
            <input type="file" name="image" accept=".jpg,.jpeg,.png" required>

            <input type="submit" name="add_image" value="Upload Image">
        </form>
    </div>
</main>

<?php include 'footer.php'; ?>
