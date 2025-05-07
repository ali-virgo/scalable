<?php include 'config.php'; session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #c3ec52, #0ba29d);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background: white;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 300px;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 25px;
            color: #333;
        }

        .login-container input[type="email"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            outline: none;
        }

        .login-container button {
            background-color: #0ba29d;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 8px;
            width: 100%;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }

        .login-container button:hover {
            background-color: #08857f;
        }

        .signup-btn {
            background-color: #ffc107;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 8px;
            width: 100%;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }

        .signup-btn:hover {
            background-color: #e0a800;
        }

        .error {
            color: red;
            margin-top: 15px;
        }
    </style>
</head>
<body>
<div class="login-container">
    <h2>Log In</h2>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit" name="login">Log In</button>
    </form>
    
    <!-- Sign Up Button -->
    <form action="signup.php" method="get">
        <button type="submit" class="signup-btn">Sign Up</button>
    </form>

    <?php
    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $result = $conn->query("SELECT * FROM users WHERE email = '$email'");
        $user = $result->fetch_assoc();
        if ($user && password_verify($_POST['password'], $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: dashboard.php");
        } else {
            echo "<div class='error'>Invalid credentials!</div>";
        }
    }
    ?>
</div>
</body>
</html>
