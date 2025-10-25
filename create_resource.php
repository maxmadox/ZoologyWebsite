<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    header('Location: login.php');
    exit();
}

include 'database/database.php';
include 'header.php';
?>

<main class="create-resource-view">
    <?php include 'teacher_sidebar.php'; ?>

    <div class="create-resource-content">
        <div class="add-student-header">
            <h1 class="create-resource-title">Add New Resource</h1>
        </div>

        <form action="add_resource_process.php" method="post" enctype="multipart/form-data" class="manual-form">
            <label>Resource Title:</label>
            <input type="text" name="title" required>

            <label>Select Type:</label>
            <select name="type" id="resourceType" required onchange="toggleResourceInput()">
                <option value="">--Select Type--</option>
                <option value="file">File</option>
                <option value="link">Link</option>
            </select>

            <div id="fileInput" style="display:none;">
                <label>Upload File (PDF/JPG/PNG):</label>
                <input type="file" name="file" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.ppt,.pptx">

            </div>

            <div id="linkInput" style="display:none;">
                <label>Paste Link:</label>
                <input type="url" name="link" placeholder="https://example.com">
            </div>

            <input type="submit" name="add_resource" value="Add Resource">
        </form>
    </div>
</main>

<?php include 'footer.php'; ?>

<script>
function toggleResourceInput() {
    const type = document.getElementById('resourceType').value;
    document.getElementById('fileInput').style.display = (type === 'file') ? 'block' : 'none';
    document.getElementById('linkInput').style.display = (type === 'link') ? 'block' : 'none';
}
</script>
