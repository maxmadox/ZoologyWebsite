<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$isAdmin = isset($_SESSION['admin']);
$adminUsername = $isAdmin ? $_SESSION['admin'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoology</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Red+Hat+Mono:ital,wght@0,300..700;1,300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href = "style.css">
</head>
<body>

    <header>
        <h1>Zoology Department</h1>

        <nav>
            <a href = "index.php">Home</a>
            <a href = "courses.php">Courses</a>
            <a href = "faculty.php">Faculty</a>
            <a href = "notice.php">Notice</a>
            <a href = "about.php">About</a>
            <a href = "contact.php">Contact</a>
        </nav>

        <?php if(!$isAdmin): ?>
            <a href="login.php" class="login-button">Login</a>
        <?php else: ?>
            <div class="admin-dropdown">
                <a href="javascript:void(0);" class="admin-link">
                    <?php echo htmlspecialchars($adminUsername); ?> 
                    <img src="content/usericon.svg" alt="user" class="usericon">
                </a>
                <div class="dropdown-content">
                    <a href="dashboard.php">Dashboard</a>
                    <a href="logout.php">Logout</a>
                </div>
            </div>
        <?php endif; ?>
    </header>
