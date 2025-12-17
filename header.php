<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'database/database.php';


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


<script>
document.addEventListener('DOMContentLoaded', () => {
    const slides = document.querySelectorAll('.index-gallery-slide');
    if (!slides.length) return;

    let currentIndex = 0;
    slides[currentIndex].classList.add('active');

    let slideInterval = setInterval(nextSlide, 2000);

    function nextSlide() {
        slides[currentIndex].classList.remove('active');
        currentIndex = (currentIndex + 1) % slides.length;
        slides[currentIndex].classList.add('active');
    }

    function prevSlide() {
        slides[currentIndex].classList.remove('active');
        currentIndex = (currentIndex - 1 + slides.length) % slides.length;
        slides[currentIndex].classList.add('active');
    }

    function resetInterval() {
        clearInterval(slideInterval);
        slideInterval = setInterval(nextSlide, 2000);
    }

    const slider = document.querySelector('.index-gallery-slider');

   
    let startX = 0;
    slider.addEventListener('touchstart', (e) => {
        startX = e.touches[0].clientX;
    });
    slider.addEventListener('touchend', (e) => {
        const endX = e.changedTouches[0].clientX;
        handleSwipe(startX, endX);
    });

   
    let isDragging = false;
    let mouseStartX = 0;

    slider.addEventListener('mousedown', (e) => {
        isDragging = true;
        mouseStartX = e.clientX;
    });

    slider.addEventListener('mouseup', (e) => {
        if (!isDragging) return;
        isDragging = false;
        const mouseEndX = e.clientX;
        handleSwipe(mouseStartX, mouseEndX);
    });

    slider.addEventListener('mouseleave', () => {
        isDragging = false;
    });


    function handleSwipe(start, end) {
        if (start - end > 50) { 
            nextSlide();
            resetInterval();
        } else if (end - start > 50) { 
            prevSlide();
            resetInterval();
        }
    }
});
</script>



<script>
document.addEventListener('DOMContentLoaded', () => {
    const snake = document.getElementById('snake-container');
    const sound = new Audio('content/snake.wav');
    sound.volume = 1.0;

    if (window.innerWidth <= 768) {
    snake.style.display = 'none';
    return;
}


    let paused = false;
    let animationTimeouts = []; 

    function clearAnimationTimeouts() {
        animationTimeouts.forEach(t => clearTimeout(t));
        animationTimeouts = [];
    }

    function animateSnake() {
        if (paused) return;

        snake.style.bottom = '-300px'; 

        animationTimeouts.push(setTimeout(() => {
            sound.currentTime = 0;
            sound.play().catch(() => {});
        }, 250));

        animationTimeouts.push(setTimeout(() => {
            snake.style.bottom = '-100px'; 
        }, 500));

        animationTimeouts.push(setTimeout(() => {
            snake.classList.add('shake'); 
        }, 800));

        animationTimeouts.push(setTimeout(() => {
            snake.classList.remove('shake'); 
        }, 1800));

        animationTimeouts.push(setTimeout(() => {
            snake.style.bottom = '-400px'; 
            animationTimeouts.push(setTimeout(animateSnake, 1000)); 
        }, 2000));
    }


    animationTimeouts.push(setTimeout(animateSnake, 500));


    window.addEventListener('scroll', () => {
        if (window.scrollY > 5) { 
            paused = true;
            clearAnimationTimeouts();
            snake.style.bottom = '-400px';
            snake.classList.remove('shake');
        } else {
       
            if (paused) {
                paused = false;
                animationTimeouts.push(setTimeout(animateSnake, 500));
            }
        }
    });

  
    snake.addEventListener('click', () => {
        paused = true;
        clearAnimationTimeouts();
        snake.style.bottom = '-400px';
        snake.classList.remove('shake');

        const intro = document.querySelector('.home-intro');
        if (intro && intro.nextElementSibling) {
            window.scrollTo({
                top: intro.nextElementSibling.offsetTop - 70,
                behavior: 'smooth'
            });
        }
    });
});
</script>







<body>

<header>
    <h1 class="header-heading">Zoology Department</h1>

    
    <div class="pc-nav-container">
        <nav class="pc-nav">
            <a href="index.php">Home</a>
            <a href="resources.php">Resources</a>
            <a href="courses.php">Courses</a>
            <a href="faculty.php">Faculty</a>
            <a href="notice.php">Notice</a>
            <a href="gallery.php">Gallery</a>
            <a href="about.php">About</a>
            <a href="contact.php">Contact</a>
        </nav>

        
        <?php if(!$isLoggedIn): ?>
            <a href="login.php" class="login-button">Login</a>
        <?php else: ?>
            <?php
                $dashboardLink = 'student_dashboard.php';
                if($role === 'admin') $dashboardLink = 'admin_dashboard.php';
                elseif($role === 'teacher') $dashboardLink = 'teacher_dashboard.php';
            ?>
            <a href="<?php echo $dashboardLink; ?>" class="login-button admin-username">
                <?php echo htmlspecialchars($username); ?>
                <img src="content/usericon.svg" alt="user" class="usericon">
            </a>
        <?php endif; ?>
    </div>

    
    <div class="mobile-nav-container">
        <button class="hamburger">&#9776;</button>
        <div class="mobile-nav">
            <?php if(!$isLoggedIn): ?>
                <a href="index.php">Home</a>
                <a href="resources.php">Resources</a>
                <a href="courses.php">Courses</a>
                <a href="faculty.php">Faculty</a>
                <a href="notice.php">Notice</a>
                <a href="gallery.php">Gallery</a>
                <a href="about.php">About</a>
                <a href="contact.php">Contact</a>
                <a href="login.php">Login</a>
            <?php elseif($role === 'admin'): ?>   
                            <a href="admin_dashboard.php">Dashboard</a>
                            <a href="manage_students.php">Manage Students</a>
                            <a href="manage_teachers.php">Manage Teachers</a>
                            <a href="manage_notices.php">Manage Notices</a>
                            <a href="manage_courses.php">Manage Courses</a>
                            <a href="manage_gallery.php">Manage Gallery</a>
                            <a href="manage_contact.php">Manage Contact</a>
                            <a href="admin_settings.php">Settings</a>
                            <a href="logout.php">Logout</a>
            <?php elseif($role === 'teacher'): ?>
                            <li><a href="teacher_dashboard.php">Dashboard</a>
                            <li><a href="manage_attendance.php">Manage Attendance</a>
                            <li><a href="manage_resources.php">Manage Resources</a>
                            <li><a href="teacher_settings.php">Settings</a>
                            <li><a href="logout.php">Logout</a>
            <?php elseif($role === 'student'): ?>
                            
            <?php endif; ?>
        </div>
    </div>

</header>






