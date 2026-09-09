<?php
session_start();

$host = "localhost";        // DB host
$dbname = "user_db";        // DB name
$dbuser = "root";           // DB username
$dbpass = "";               // DB password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['adminname'] ?? '';
    $password = $_POST['adminpassword'] ?? '';

    // Prepare SQL query to fetch admin
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE adminname = :adminname LIMIT 1");
    $stmt->execute(['adminname' => $username]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    
    if ($admin && $password === $admin['adminpassword']) {
        $_SESSION['adminname'] = $admin['adminname'];
        $_SESSION['role'] = 'admin'; //admin
        header("Location: admindashboard.php");
        exit;
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    .login-button {
        background-color: gold;
        color: #000;
        font-weight: bold;
        transition: background-color 0.3s, color 0.3s;
    }
    .login-button:hover {
        background-color: #e6c200;
        color: #fff;
    }
    .logo {
        display: block;
        margin: 0 auto 20px;
        width: 100px; 
        height: auto;
    }
</style>
</head>
<body class="bg-light">
<div class="container d-flex justify-content-center align-items-center" style="height:100vh;">
    <div class="card p-4 shadow" style="width:350px;">
        
        <img src="g.png" alt="Logo" class="logo">

        <h3 class="text-center mb-3">Admin Login</h3>
        <?php if($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <input type="text" name="adminname" class="form-control" placeholder="Admin" required>
            </div>
            <div class="mb-3">
                <input type="password" name="adminpassword" class="form-control" placeholder="Password" required>
            </div>
            <button class="btn login-button w-100" type="submit">Login</button>
        </form>
    </div>
</div>
</body>
</html>