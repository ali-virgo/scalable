<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #f6d365, #fda085);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .signup-container {
            background: white;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 320px;
            text-align: center;
        }

        .signup-container h2 {
            margin-bottom: 25px;
            color: #333;
        }

        .signup-container input[type="text"],
        .signup-container input[type="email"],
        .signup-container input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            outline: none;
        }

        .signup-container button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 8px;
            width: 100%;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }

        .signup-container button:hover {
            background-color: #218838;
        }

        .message {
            margin-top: 15px;
            color: green;
        }

        .error {
            margin-top: 15px;
            color: red;
        }

        .login-link {
            display: block;
            margin-top: 15px;
            text-decoration: none;
            color: #007BFF;
            font-size: 14px;
        }

        .login-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="signup-container">
    <h2>Sign Up</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit" name="signup">Sign Up</button>
    </form>

    <?php
    if (isset($_POST['signup'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Check if email already exists
        $check = $conn->query("SELECT * FROM users WHERE email = '$email'");
        if ($check->num_rows > 0) {
            echo "<div class='error'>Email already registered!</div>";
        } else {
            $conn->query("INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')");
            echo "<div class='message'>User registered successfully!</div>";
        }
    }
    ?>

    <a href="login.php" class="login-link">Already have an account? Log in here.</a>
</div>
</body>
</html>
