<?php
session_start();


if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    header('Location: login.php');
    exit();
}


include 'database/database.php';


$status = '';


if(isset($_POST['update_password'])){
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    $user_type = 'teacher';
    $user_id = $_SESSION['user_id'];

    if($new_password !== $confirm_password){
        $status = 'mismatch';
    } else {
        
        $stmt = $conn->prepare("SELECT password FROM users WHERE id=? AND role=?");
        $stmt->bind_param("is", $user_id, $user_type);
        $stmt->execute();
        $stmt->bind_result($db_password);
        $stmt->fetch();
        $stmt->close();

        
        if(!password_verify($current_password, $db_password)){
            $status = 'wrong';
        } else {
            $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("UPDATE users SET password=? WHERE id=? AND role=?");
            $stmt->bind_param("sis", $new_password_hashed, $user_id, $user_type);

            $status = $stmt->execute() ? 'success' : 'error';
            $stmt->close();
        }
    }
    $conn->close();
}

include 'header.php';
?>

<main class ="teacher-setting-view">
    <?php include 'teacher_sidebar.php'; ?>

    <div class="teacher-setting-content">
        <h2 class="teacher-setting-title">Settings</h2>

        <div class="teacher-setting-card">
            <h3>Update Password</h3>
            <form action="" method="post">
                <label for="current-password">Current Password</label>
                <input type="password" name="current_password" id="current-password" placeholder="Enter current password" required>
                
                <label for="new-password">New Password</label>
                <input type="password" name="new_password" id="new-password" placeholder="Enter new password" required>
                
                <label for="confirm-password">Confirm New Password</label>
                <input type="password" name="confirm_password" id="confirm-password" placeholder="Confirm new password" required>
                
                <button type="submit" name="update_password" class="btn-update">Update Password</button>
            </form>
        </div>
    </div>

    
    <?php if($status != ''): ?>
    <div id="passwordModal" class="modal">
        <div class="modal-content">
            <?php
            switch($status){
                case 'success':
                    echo "<p>Password updated successfully!</p>";
                    break;
                case 'error':
                    echo "<p>Error updating password. Please try again.</p>";
                    break;
                case 'wrong':
                    echo "<p>Current password is incorrect!</p>";
                    break;
                case 'mismatch':
                    echo "<p>New passwords do not match!</p>";
                    break;
            }
            ?>
            <div class="modal-buttons">
                <?php if($status == 'success'): ?>
                    <a href="logout.php"><button>OK (Logout)</button></a>
                <?php else: ?>
                    <a href="settings.php"><button>OK</button></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

</main>

<?php include 'footer.php'; ?>
