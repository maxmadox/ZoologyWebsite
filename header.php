<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
$isLoggedIn = isset($_SESSION['role']);
$username = $isLoggedIn ? $_SESSION['username'] : '';
$role = $isLoggedIn ? $_SESSION['role'] : '';
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
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Zoology Department</h1>

    <nav>
        <a href="index.php">Home</a>
        <a href="courses.php">Courses</a>
        <a href="faculty.php">Faculty</a>
        <a href="notice.php">Notice</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact</a>
    </nav>

    <?php if(!$isLoggedIn): ?>
        <a href="login.php" class="login-button">Login</a>
    <?php else: ?>
        <?php
            // Determine dashboard link based on role
            $dashboardLink = 'student_dashboard.php'; // default
            if($role === 'admin') {
                $dashboardLink = 'admin_dashboard.php';
            } elseif($role === 'teacher') {
                $dashboardLink = 'teacher_dashboard.php';
            }
        ?>
        <a href="<?php echo $dashboardLink; ?>" class="login-button admin-username">
            <?php echo htmlspecialchars($username); ?>
            <img src="content/usericon.svg" alt="user" class="usericon">
        </a>
    <?php endif; ?>
</header>

