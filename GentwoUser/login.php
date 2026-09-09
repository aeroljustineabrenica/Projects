<?php
session_start();
$conn = new mysqli("localhost", "root", "", "interprog");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && $password === $user['password']) {
        $_SESSION['username'] = $user['username'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #4132a1ff 0%, #000000ff 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 40px 30px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            width: 400px;
            text-align: center;
            color: #fff;
        }

        .container img {
            height: 60px;
            margin-bottom: 20px;
        }

        h2 {
            margin-bottom: 25px;
            color: #fff;
        }

        input {
            width: 50%;
            border-radius: 10px;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            font-size: 14px;
            background-color: rgba(255, 255, 255, 0.8);
        }

        button {
            border-radius: 10px;
            padding: 12px;
            width: 20%;
            background-color: #d4af37;
            color: white;
            border: none;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #c29a2b;
        }

        .error {
            color: #ff4d4d;
            margin-top: 10px;
            font-size: 14px;
        }

        .create-account {
            margin-top: 15px;
            display: block;
            color: #fff;
            text-decoration: underline;
            transition: color 0.3s ease;
        }

        .create-account:hover {
            color: #d4af37;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="g.png" alt="GenTwo Logo">
        <h2>Login</h2>
        <form method="post">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit">Login</button>
        </form>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <a href="register.php" class="create-account">Create Account</a>
    </div>
</body>
</html>