<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include 'database/database.php';

$status = '';


$contact_result = mysqli_query($conn, "SELECT * FROM contact_info LIMIT 1");
$contact = mysqli_fetch_assoc($contact_result);


if(isset($_POST['update_contact'])){
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $stmt = $conn->prepare("UPDATE contact_info SET email=?, phone=? WHERE id=?");
    $stmt->bind_param("ssi", $email, $phone, $contact['id']);
    $status = $stmt->execute() ? 'success' : 'error';
    $stmt->close();

    
    $contact_result = mysqli_query($conn, "SELECT * FROM contact_info LIMIT 1");
    $contact = mysqli_fetch_assoc($contact_result);
}

include 'header.php';
?>

<main class="edit-contact-view">
    <?php include 'admin_sidebar.php'; ?>

    <div class="edit-contact-content">
        <h2 class="edit-contact-title">Edit Contact Info</h2>

        <div class="edit-contact-card">
            
            <form action="" method="post">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Enter Email" value="<?php echo htmlspecialchars($contact['email']); ?>" required>

                <label for="phone">Phone</label>
                <input type="text" name="phone" id="phone" placeholder="Enter Phone Number" value="<?php echo htmlspecialchars($contact['phone']); ?>" required>

                <button type="submit" name="update_contact" class="btn-update">Update Contact</button>
            </form>
        </div>
    </div>

    
    <?php if($status != ''): ?>
    <div id="contactModal" class="modal">
        <div class="modal-content">
            <?php
            switch($status){
                case 'success':
                    echo "<p>Contact information updated successfully!</p>";
                    break;
                case 'error':
                    echo "<p>Error updating contact information. Please try again.</p>";
                    break;
            }
            ?>
            <div class="modal-buttons">
                <a href="edit_contact.php"><button>OK</button></a>
            </div>
        </div>
    </div>
    <?php endif; ?>

</main>

<?php include 'footer.php'; ?>
