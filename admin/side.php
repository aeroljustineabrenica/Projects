<?php
// side.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<nav class="vh-100 d-flex flex-column p-3 sidebar text-white position-fixed">
    <a class="d-flex align-items-center mb-4 logo-link" href="admindashboard.php">
        <img src="g.png" alt="GenTwo Logo" style="height:100px; width:100px; border-radius:6px;" class="me-2"><br>
        <span class="fw-bold">GenTwo Timepieces</span>
    </a>

    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a class="nav-link text-white" href="admindashboard.php">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>
        <li>
            <a class="nav-link text-white" href="ordermanage.php">
                <i class="bi bi-bag-check me-2"></i> Order Management
            </a>
        </li>
        <li>
            <a class="nav-link text-white" href="productmanage.php">
                <i class="bi bi-box-seam me-2"></i> Product Management
            </a>
        </li>
        <li>
            <a class="nav-link text-white" href="sales.php">
                <i class="bi bi-graph-up me-2"></i> Sales Management
            </a>
        </li>
        <li>
            <a class="nav-link text-white" href="usermanage.php">
                <i class="bi bi-people me-2"></i> User Management
            </a>
        </li>
    </ul>

    <hr class="text-white">

    <ul class="nav nav-pills flex-column mt-auto">
        <li>
            <a class="nav-link text-white" href="adminacc.php">
                <i class="bi bi-person-circle me-2"></i> Admin
            </a>
        </li>
        <li>
            <a class="nav-link text-white" href="adminlogout.php">
                <i class="bi bi-box-arrow-right me-2"></i> Log Out
            </a>
        </li>
    </ul>
</nav>

<style>
.sidebar {
    width: 250px;
    background-color: #001f3f;
    height: 100vh;
}
.logo-link { 
    text-decoration: none; 
}
.logo-link:hover { 
    opacity: 0.9; 
}
.nav-link { 
    color: rgba(255, 255, 255, 0.9); 
    font-weight: 500; 
    border-radius: 5px; 
}
.nav-link:hover { 
    background-color: rgba(255, 255, 255, 0.2); 
    color: #fff; 
}
.nav-pills .nav-link.active { 
    background-color: rgba(255,255,255,0.3); 
    color: #fff; 
}
hr.text-white {
    border-top: 1px solid rgba(255, 255, 255, 0.2);
    margin: 1rem 0;
}
</style>