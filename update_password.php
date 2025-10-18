<?php
session_start();
include 'database/database.php'; // Your database connection file

// Determine user type and id from session
if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'){
    $user_type = 'admin';
    $user_id = null; // Not needed for admin since only one exists
} elseif(isset($_SESSION['role']) && $_SESSION['role'] === 'teacher'){
    $user_type = 'teacher';
    if(!isset($_SESSION['user_id'])){
        echo "<script>alert('You must be logged in'); window.location='login.php';</script>";
        exit;
    }
    $user_id = $_SESSION['user_id'];
} elseif(isset($_SESSION['role']) && $_SESSION['role'] === 'student'){
    $user_type = 'student';
    if(!isset($_SESSION['user_id'])){
        echo "<script>alert('You must be logged in'); window.location='login.php';</script>";
        exit;
    }
    $user_id = $_SESSION['user_id'];
} else {
    echo "<script>alert('You must be logged in'); window.location='login.php';</script>";
    exit;
}

if(isset($_POST['update_password'])){
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if($new_password !== $confirm_password){
        echo "<script>alert('New passwords do not match'); window.history.back();</script>";
        exit;
    }

    // Fetch current password
    if($user_type === 'admin'){
        $stmt = $conn->prepare("SELECT password FROM users WHERE role = 'admin' LIMIT 1");
    } else {
        $stmt = $conn->prepare("SELECT password FROM users WHERE id = ? AND role = ?");
        $stmt->bind_param("is", $user_id, $user_type);
    }

    $stmt->execute();
    $stmt->bind_result($db_password);
    $stmt->fetch();
    $stmt->close();

    // Verify current password
    if(!password_verify($current_password, $db_password)){
        echo "<script>alert('Current password is incorrect'); window.history.back();</script>";
        exit;
    }

    // Hash new password
    $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);

    // Update password in database
    if($user_type === 'admin'){
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE role = 'admin' LIMIT 1");
        $stmt->bind_param("s", $new_password_hashed);
    } else {
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ? AND role = ?");
        $stmt->bind_param("sis", $new_password_hashed, $user_id, $user_type);
    }

    if($stmt->execute()){
    $status = 'success';
    } else {
        $status = 'error';
    }
      

    $stmt->close();
    $conn->close();

}
?>
    
    
    
    <main> 
            <?php if(isset($status)): ?>
            <div id="passwordModal" class="modal">
                <div class="modal-content">
                    <?php if($status == 'success'): ?>
                        <p>Password updated successfully!</p>
                    <?php else: ?>
                        <p>Error updating password. Please try again.</p>
                    <?php endif; ?>
                    <div class="modal-buttons">
                        <a href="settings.php"><button>OK</button></a>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </main>


