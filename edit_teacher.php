<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include 'database/database.php';
include 'header.php';

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM teachers WHERE user_id = $id");
$teacher = mysqli_fetch_assoc($result);


$teacher_quals = explode(', ', $teacher['qualification'] ?? '');
$options = ['B.Sc', 'M.Sc', 'Ph.D'];


$other_quals = array_diff($teacher_quals, $options);
$other_checked = count($other_quals) > 0 && trim(implode('', $other_quals)) !== '' ? 'checked' : '';
$other_value = implode(', ', $other_quals);
?>

<main class="edit-teacher-view">
    <?php include 'admin_sidebar.php'; ?>

    <div class="edit-teacher-content">
        <h1 class="edit-teacher-title">Edit Teacher</h1>

        <form action="update_teacher.php" method="post" class="manual-form" enctype="multipart/form-data">
            <input type="hidden" name="user_id" value="<?php echo $teacher['user_id']; ?>">

            <label>Full Name:</label>
            <input type="text" name="full_name" value="<?php echo $teacher['full_name']; ?>" required>

            <label>DOB:</label>
            <input type="date" name="dob" value="<?php echo $teacher['dob']; ?>" required>

            <label>Date Joined:</label>
            <input type="date" name="date_joined" value="<?php echo $teacher['date_joined']; ?>" required>

            <label>Qualification:</label>
            <div class="qualification-options">
                <?php 
                foreach($options as $opt):
                    $checked = in_array($opt, $teacher_quals) ? 'checked' : '';
                ?>
                    <label><input type="checkbox" name="qualification[]" value="<?php echo $opt; ?>" <?php echo $checked; ?>> <?php echo $opt; ?></label>
                <?php endforeach; ?>

                <label>
                    <input type="checkbox" id="otherCheck" name="qualification[]" value="Other" <?php echo $other_checked; ?>>
                    Other
                </label>
                <input type="text" id="otherInput" name="other_qualification" placeholder="Specify other qualification"
                value="<?php echo $other_value; ?>"
                style="display:<?php echo $other_checked ? 'block' : 'none'; ?>;">

            </div>

            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $teacher['email']; ?>" required>

            <label>Phone:</label>
            <input type="text" name="phone_number" value="<?php echo $teacher['phone_number']; ?>" required>

            <label>Profile Image:</label>
            <?php if(!empty($teacher['image_path'])): ?>
                <div>
                    <img src="<?php echo $teacher['image_path']; ?>" alt="Profile" style="width:100px; height:auto; margin-bottom:5px;">
                </div>
            <?php endif; ?>
            <input type="file" name="image_path" accept="image/*">

            <input type="submit" name="update_teacher" value="Update Teacher">
        </form>

        <script>
        document.getElementById('otherCheck').addEventListener('change', function() {
            const input = document.getElementById('otherInput');
            input.style.display = this.checked ? 'inline-block' : 'none';
        });
        </script>

    </div>
</main>

<?php include 'footer.php'; ?>
