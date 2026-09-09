<?php
session_start();
$conn = new mysqli("localhost", "root", "", "user_db");

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm = trim($_POST['confirm']);

    if (empty($full_name) || empty($email) || empty($username) || empty($password) || empty($confirm)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif ($password !== $confirm) {
        $error = "Passwords do not match.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM userm WHERE username=? OR email=?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Username or Email already exists.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $conn->prepare("INSERT INTO userm (full_name, email, username, password, status) VALUES (?, ?, ?, ?, 'Pending')");
            $stmt->bind_param("ssss", $full_name, $email, $username, $password);

            if ($stmt->execute()) {
                $success = "Account created successfully! You can now <a href='login.php'>login</a>.";
            } else {
                $error = "Error creating account. Please try again.";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Account | GenTwo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        h2 { margin-bottom: 25px; color: #fff; }
        input {
            width: 80%;
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
            width: 50%;
            background-color: #d4af37;
            color: white;
            border: none;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
            transition: background 0.3s ease;
        }
        button:hover { background-color: #c29a2b; }
        .error { color: #ff4d4d; margin-top: 10px; font-size: 14px; }
        .success { color: #00ff99; margin-top: 10px; font-size: 14px; }
        .create-account { margin-top: 15px; display: block; color: #fff; text-decoration: underline; transition: color 0.3s ease; }
        .create-account:hover { color: #d4af37; }
    </style>
</head>
<body>
<div class="container">
    <h2>Create Account</h2>

    <?php if ($error): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="success"><?= $success ?></div>
    <?php endif; ?>

    <form method="post">
        <input type="text" name="full_name" placeholder="Full Name" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="password" name="confirm" placeholder="Confirm Password" required><br>
        <button type="submit">Create</button>
    </form>

    <a href="login.php" class="create-account">Already have an account? Login here</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
