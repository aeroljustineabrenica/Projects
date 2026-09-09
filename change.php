<?php
session_start();
include 'nav.php';
$conn = new mysqli("localhost", "root", "", "user_db");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old = $_POST['old'];
    $new = $_POST['new'];
    $username = $_SESSION['username'];

    $stmt = $conn->prepare("SELECT password FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user && $old === $user['password']) {
        $update = $conn->prepare("UPDATE users SET password=? WHERE username=?");
        $update->bind_param("ss", $new, $username);
        $update->execute();
        $success = "Password changed successfully.";
    } else {
        $error = "Old password incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Change Password | GenTwo</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    font-family: "Inter", sans-serif;
    background: #f8f9fa;
    margin: 0;
    padding: 0;
}

.navbar {
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 1000;
}

.page-wrapper {
    padding-top: 100px; 
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: flex-start;
}

.password-container {
    background: rgba(255,255,255,0.95); 
    padding: 50px 40px;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    width: 100%;
    max-width: 450px;
    text-align: center;
    margin-bottom: 40px;
    position: relative;
}

.password-container img {
    height: 60px;
    margin-bottom: 20px;
}

.password-container h2 {
    font-weight: 700;
    color: #001f3f; 
    margin-bottom: 30px;
}

.password-container input {
    width: 100%;
    padding: 12px 15px;
    margin-bottom: 20px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 1rem;
    transition: border-color 0.3s;
}

.password-container input:focus {
    outline: none;
    border-color: #d4af37; 
}

.password-container button {
    width: 100%;
    padding: 12px;
    border-radius: 6px;
    border: none;
    background: #d4af37; 
    color: #fff;
    font-weight: 600;
    font-size: 1rem;
    transition: background 0.3s, transform 0.3s;
}

.password-container button:hover {
    background: #b9962f;
    transform: translateY(-2px);
}

.alert {
    margin-top: 15px;
    font-weight: 500;
    border-radius: 6px;
    padding: 10px;
}
</style>
</head>
<body>

<div class="page-wrapper">
    <div class="password-container">
        
        <img src="g.png" alt="GenTwo Logo">

        <h2>Change Password</h2>
        <form method="post">
            <input type="password" name="old" placeholder="Old Password" required>
            <input type="password" name="new" placeholder="New Password" required>
            <button type="submit">Change Password</button>
        </form>

        <?php
        if (isset($error)) echo "<div class='alert alert-danger'>$error</div>";
        if (isset($success)) echo "<div class='alert alert-success'>$success</div>";
        ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>