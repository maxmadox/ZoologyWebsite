<?php

include 'database/database.php';
session_start();



?>

<head>
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

    

</main>

</body>

<?php
    if(isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Fetch user from database
        $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Password is correct, set session
                $_SESSION['admin'] = $user['username'];
                header('Location: dashboard.php');
                exit();
            } else {
                echo "<p style='color:red;'>Invalid password.</p>";
            }
        } else {
            echo "<p style='color:red;'>No user found with that username.</p>";
        }

        $stmt->close();
    }

