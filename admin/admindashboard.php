<?php
include 'side.php';


ini_set('display_errors', 1);
error_reporting(E_ALL);


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { 
    die("Connection failed: " . $conn->connect_error); 
}


$revenue = 0;
$result = $conn->query("SELECT SUM(Price) as totalRevenue FROM orders");
if ($result && $row = $result->fetch_assoc()) { 
    $revenue = $row['totalRevenue'] ?? 0; 
}


$totalCustomers = 0;
$result = $conn->query("SELECT COUNT(*) as total FROM userm");
if ($result && $row = $result->fetch_assoc()) { 
    $totalCustomers = $row['total'] ?? 0; 
}


$users = [];
$result = $conn->query("SELECT DISTINCT FullName FROM orders WHERE status='Pending'");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) { $users[] = $row; }
}


$reservedCustomersCount = count($users);


$days = [];
$orderData = [];
for ($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $days[] = date('D', strtotime($date));

    $res = $conn->query("SELECT COUNT(*) as total FROM orders WHERE DATE(date) = '$date'");
    $count = 0;
    if ($res && $row = $res->fetch_assoc()) { $count = (int)$row['total']; }
    $orderData[] = $count;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>GENTWO Dashboard</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
body { margin:0; font-family: Arial,sans-serif; background:#f0f2f5; display:flex; flex-direction:column; min-height:100vh; }
.main { margin-left:250px; padding:20px; flex:1; }
h2 { color:#333; }


.card-container { 
    display: flex; 
    flex-wrap: nowrap;  
    gap: 20px; 
    margin-bottom: 20px; 
}


.card { 
    flex: 1;  
    min-width: 200px;
    background:#fff; 
    padding:20px; 
    border-radius:12px; 
    box-shadow:0 4px 12px rgba(0,0,0,0.1); 
}
.card h3 { margin-top:0; font-size:18px; color:#555; }
.card p { font-size:24px; font-weight:bold; color:#111; margin:10px 0 0; }


.chart-row { 
    display: flex; 
    gap: 20px; 
    margin-bottom: 40px;
}


.chart-container { 
    flex: 1; 
    height: 300px;
    background:#fff; 
    padding:20px; 
    border-radius:12px; 
    box-shadow:0 4px 12px rgba(0,0,0,0.1); 
}


.customer-chart-container {
    flex: 1; 
    height: 300px; 
    background:#fff; 
    padding:20px; 
    border-radius:12px; 
    box-shadow:0 4px 12px rgba(0,0,0,0.1); 
}


.customers-container { 
    background:#fff; 
    padding:20px; 
    border-radius:12px; 
    box-shadow:0 4px 12px rgba(0,0,0,0.1); 
    max-width:400px; 
    margin-top:20px;
}
.customer { 
    background:#f5f5f5; 
    padding:10px 15px; 
    border-radius:8px; 
    margin-bottom:10px; 
    transition: transform 0.2s, box-shadow 0.2s; 
}
.customer:hover { transform: translateY(-2px); box-shadow:0 4px 8px rgba(0,0,0,0.1); }
.customer a { color:#000; text-decoration:none; font-weight:500; display:block; }
.customer a:hover { color:#6366f1; text-decoration:underline; }


footer { 
    text-align:center; 
    padding:15px 10px; 
    background-color: #001f3f;
    height: 40px; 
    color:#fff; 
    font-size:14px; 
}


@media(max-width:1024px){ 
    .chart-row { flex-direction: column; }
    .chart-container, .customer-chart-container { height: 250px; }
}
@media(max-width:768px){ 
    .card-container{flex-direction:column;} 
}
</style>
</head>
<body>

<div class="main">
    <h2>Dashboard</h2>

    
    <div class="card-container">
        <div class="card">
            <h3>Orders Revenue</h3>
            <p>PHP <?= number_format($revenue, 2) ?></p>
        </div>

        <div class="card">
            <h3>Total Customers</h3>
            <p><?= $totalCustomers ?></p>
        </div>
    </div>

    
    <div class="chart-row">
        
        <div class="chart-container">
            <canvas id="lineChart"></canvas>
        </div>

        
        <div class="customer-chart-container">
            <canvas id="customerChart"></canvas>
        </div>
    </div>

   
    <div class="customers-container">
        <h3>Customers (Reserved Items)</h3>
        <?php if(count($users) > 0): ?>
            <?php foreach($users as $order): ?>
                <div class="customer">
                    <a href="ordermanage.php?customer=<?= urlencode($order['FullName']) ?>">
                        <?= htmlspecialchars($order['FullName']) ?>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No customers have reserved items yet.</p>
        <?php endif; ?>
    </div>
</div>


<footer>
    Philippians 4:13 - "I can do all things through him who gives me strength."
</footer>

<script>

const ctx = document.getElementById('lineChart');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode($days) ?>,
        datasets: [{
            label: 'Orders',
            data: <?= json_encode($orderData) ?>,
            borderColor: '#6366f1',
            backgroundColor: 'rgba(99,102,241,0.2)',
            tension: 0.4,
            fill: true,
            pointRadius: 4
        }]
    },
    options: {
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, precision:0 } }
    }
});


const ctx2 = document.getElementById('customerChart');
new Chart(ctx2, {
    type: 'bar',
    data: {
        labels: ['Total Customers', 'Reserved Customers'],
        datasets: [{
            label: 'Users',
            data: [<?= $totalCustomers ?>, <?= $reservedCustomersCount ?>],
            backgroundColor: ['#6366f1', '#f59e0b']
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            title: { display: true, text: 'Customer Overview' }
        },
        scales: { y: { beginAtZero: true, precision: 0 } }
    }
});
</script>

</body>
</html>