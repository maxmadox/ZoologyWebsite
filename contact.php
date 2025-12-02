<?php
include 'database/database.php';
include 'header.php';

$result = mysqli_query($conn, "SELECT * FROM contact_info LIMIT 1");
$contact = mysqli_fetch_assoc($result);
?>

<main style="background-color: #023031;">
    <section class="contact-view">
        <div class="contact-wrapper">
            <div class="contact-text">
                <h1>Contact Us</h1>
                <p>
                    For any queries. <br>
                    You can reach out to the Head of Department. <br><br>

                    Email: <?php echo $contact['email']; ?> <br>
                    Phone: <?php echo $contact['phone']; ?> <br><br>

                    You can also visit the department office <br> during working hours for assistance.
                </p>
            </div>

            <div class="contact-image">
                <img src="content/gecko.jpg" alt="gecko">
            </div>
        </div>
    </section>
</main>

<?php include 'footerdisplay.php'; ?>
