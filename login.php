<?php
include 'database/database.php';
session_start();
?>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
</head>

<body>
    <main class="loginview">
        <h2>Login</h2>
        <form action="login.php" method="post">
            <label for="username"></label>
            <input type="text" id="username" name="username" placeholder="username" required><br><br>

            <label for="password"></label>
            <input type="password" id="password" name="password" placeholder="password" required><br><br>

            <input type="submit" name="login" value="Sign In">
        </form>
    </main>
</body>

<?php
if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if(password_verify($password, $user['password'])) {
            
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['username'] = $user['username'];

            
            if($user['role'] === 'admin') {
                header("Location: admin_dashboard.php");
            } elseif($user['role'] === 'teacher') {
                header("Location: teacher_dashboard.php");
            } else {
                header("Location: student_dashboard.php");
            }
            exit();
        } else {
            echo "<p style='color:red;'>Invalid password.</p>";
        }
    } else {
        echo "<p style='color:red;'>No user found with that username.</p>";
    }
    $stmt->close();
}
?>
