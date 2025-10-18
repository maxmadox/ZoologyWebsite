<?php
session_start();

// Check if user is logged in and role is set
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Include database connection
include 'database/database.php';

// Initialize status variable for modal
$status = '';

// Handle password update if form submitted
if(isset($_POST['update_password'])){
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    $user_type = $_SESSION['role']; // 'admin'
    $user_id = $_SESSION['user_id'] ?? null; // not needed for admin

    if($new_password !== $confirm_password){
        $status = 'mismatch';
    } else {
        // Fetch current password
        if($user_type === 'admin'){
            $stmt = $conn->prepare("SELECT password FROM users WHERE role='admin' LIMIT 1");
        } else {
            $stmt = $conn->prepare("SELECT password FROM users WHERE id=? AND role=?");
            $stmt->bind_param("is", $user_id, $user_type);
        }

        $stmt->execute();
        $stmt->bind_result($db_password);
        $stmt->fetch();
        $stmt->close();

        // Verify current password
        if(!password_verify($current_password, $db_password)){
            $status = 'wrong';
        } else {
            $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);

            if($user_type === 'admin'){
                $stmt = $conn->prepare("UPDATE users SET password=? WHERE role='admin' LIMIT 1");
                $stmt->bind_param("s", $new_password_hashed);
            } else {
                $stmt = $conn->prepare("UPDATE users SET password=? WHERE id=? AND role=?");
                $stmt->bind_param("sis", $new_password_hashed, $user_id, $user_type);
            }

            $status = $stmt->execute() ? 'success' : 'error';
            $stmt->close();
        }
    }
    $conn->close();
}

include 'header.php';
?>

<main class ="admin-dashboard-container">
    <?php include 'admin_sidebar.php'; ?>

    <div class="dashboard-settings">
        <h2 class="admintitle">Settings</h2>

        <div class="setting-card">
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

    <!-- Modal Popup -->
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
