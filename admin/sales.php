<?php
include 'side.php'; 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$search = $_GET['search'] ?? '';
$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';

$query = "SELECT * FROM orders WHERE 
    Product LIKE ? 
    OR RefNo LIKE ? 
    OR FullName LIKE ? 
    OR Email LIKE ? 
    OR PhoneNo LIKE ? 
    OR Price LIKE ? 
    OR status LIKE ?";

$params = ["%$search%", "%$search%", "%$search%", "%$search%", "%$search%", "%$search%", "%$search%"];
$types = str_repeat("s", count($params));

if (!empty($start_date) && !empty($end_date)) {
    $query .= " AND (date BETWEEN ? AND ?)";
    $params[] = $start_date . " 00:00:00";
    $params[] = $end_date . " 23:59:59";
    $types .= "ss";
}

$query .= " ORDER BY date DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

$total_orders = 0;
$total_reserved = 0;
$total_pending = 0;
$total_cancelled = 0;
$total_revenue = 0;
$orders = [];

while ($order = $result->fetch_assoc()) {
    $orders[] = $order;
    $total_orders++;

    if ($order['status'] == "Reserved") {
        $total_reserved++;
        $total_revenue += $order['Price'];
    } elseif ($order['status'] == "Pending") {
        $total_pending++;
    } elseif ($order['status'] == "Cancelled") {
        $total_cancelled++;
    }
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Orders Report - GENTWO</title>

<script src="https://kit.fontawesome.com/a81368914c.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="sales.css">

<style>
body {
    margin: 0;
    font-family: 'Inter', sans-serif;
    background-color: #f3f4f7;
    color: #333;
}
.main {
    padding: 30px;
    max-width: 1300px;
    margin: auto;
}
h2 {
    font-size: 30px;
    font-weight: 700;
    margin-bottom: 5px;
}
p {
    color: #666;
    margin-bottom: 25px;
}

.summary-boxes {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
    margin-bottom: 25px;
}
.summary-box {
    background: #ffffff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    transition: 0.2s;
}
.summary-box:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 16px rgba(0,0,0,0.10);
}
.summary-box h3 {
    margin: 0;
    color: #555;
    font-size: 16px;
    font-weight: 600;
}
.summary-box p {
    margin: 8px 0 0;
    font-size: 26px;
    font-weight: 700;
    color: #1e88e5;
}

.top-controls {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    flex-wrap: wrap;
    gap: 10px;
}

.search-area {
    display: flex;
    gap: 10px;
}
.search-bar {
    background: #fff;
    padding: 10px 16px;
    border-radius: 30px;
    display: flex;
    align-items: center;
    gap: 10px;
    border: 1px solid #dcdcdc;
    width: 260px;
}
.search-bar input {
    border: none;
    outline: none;
    width: 100%;
    background: none;
    font-size: 14px;
}

.date-select {
    background: #fff;
    padding: 10px 16px;
    border-radius: 30px;
    border: 1px solid #dcdcdc;
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
}

.export-btn {
    padding: 10px 28px;
    background: #4CAF50;
    color: white;
    border: none;
    border-radius: 30px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.2s;
}
.export-btn:hover {
    background: #43a047;
}

table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.06);
}
th {
    background: #eef1f6;
    padding: 14px;
    text-align: center;
    font-size: 14px;
    font-weight: 700;
    color: #444;
}
td {
    padding: 14px;
    text-align: center;
    font-size: 14px;
    border-bottom: 1px solid #f1f1f1;
}
tr:hover {
    background: #f9fbff;
}

.status-reserved { color: #4CAF50; font-weight: bold; }
.status-pending { color: #FFA500; font-weight: bold; }
.status-cancelled { color: #FF5252; font-weight: bold; }

.all-orders {
    margin-top: 18px;
    color: #1e135b;
    font-size: 14px;
    cursor: pointer;
    text-decoration: underline;
}

/* ✅ PRINT FIX (REPORT STYLE, NOT RECEIPT) */
@media print {
    @page {
        size: A4;
        margin: 15mm;
    }

    body {
        background: #fff;
        color: #000;
        font-size: 12px;
    }

    .sidebar,
    .search-area,
    .export-btn,
    .all-orders {
        display: none !important;
    }

    .main {
        max-width: 100% !important;
        padding: 0 !important;
        margin: 0 auto !important;
    }

    h2 {
        font-size: 22px;
        text-align: center;
    }

    p {
        text-align: center;
        margin-bottom: 15px;
    }

    .summary-boxes {
        grid-template-columns: repeat(5, 1fr);
        gap: 10px;
        margin-bottom: 15px;
    }

    .summary-box {
        box-shadow: none !important;
        border: 1px solid #ccc;
        padding: 10px;
    }

    table {
        width: 100%;
        box-shadow: none !important;
        border: 1px solid #000;
    }

    th, td {
        border: 1px solid #000;
        padding: 8px;
        font-size: 11px;
    }

    tr {
        page-break-inside: avoid;
    }
}
</style>
</head>

<body>
<div class="main">
    <h2>Orders Report</h2>
    <p>You can see the company orders report</p>

    <div class="summary-boxes">
        <div class="summary-box"><h3>Total Orders</h3><p><?= $total_orders ?></p></div>
        <div class="summary-box"><h3>Total Reserved</h3><p><?= $total_reserved ?></p></div>
        <div class="summary-box"><h3>Total Pending</h3><p><?= $total_pending ?></p></div>
        <div class="summary-box"><h3>Total Cancelled</h3><p><?= $total_cancelled ?></p></div>
        <div class="summary-box"><h3>Total Revenue</h3><p>PHP <?= number_format($total_revenue, 2) ?></p></div>
    </div>

    <div class="top-controls">
        <form method="GET" class="search-area">
            <div class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" name="search" placeholder="Search orders" value="<?= htmlspecialchars($search) ?>">
            </div>

            <div class="date-select" onclick="document.getElementById('start_date').showPicker();">
                <i class="fas fa-calendar"></i>
                <span><?= $start_date && $end_date ? "$start_date → $end_date" : 'Date' ?></span>
                <input type="date" id="start_date" name="start_date" value="<?= $start_date ?>" style="display:none;"
                    onchange="document.getElementById('end_date').showPicker();">
                <input type="date" id="end_date" name="end_date" value="<?= $end_date ?>" style="display:none;"
                    onchange="this.form.submit();">
            </div>
        </form>

        <button class="export-btn" onclick="window.print()">
            <i class="fas fa-print"></i> Print Orders
        </button>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Product</th>
                <th>Ref No</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone No</th>
                <th>Price</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($orders)): foreach ($orders as $order): ?>
            <tr>
                <td><?= htmlspecialchars($order['id']) ?></td>
                <td><?= htmlspecialchars($order['Product']) ?></td>
                <td><?= htmlspecialchars($order['RefNo']) ?></td>
                <td><?= htmlspecialchars($order['FullName']) ?></td>
                <td><?= htmlspecialchars($order['Email']) ?></td>
                <td><?= htmlspecialchars($order['PhoneNo']) ?></td>
                <td>PHP <?= number_format($order['Price'], 2) ?></td>
                <td class="status-<?= strtolower($order['status']) ?>"><?= htmlspecialchars($order['status']) ?></td>
                <td><?= htmlspecialchars($order['date']) ?></td>
            </tr>
        <?php endforeach; else: ?>
            <tr><td colspan="9">No order data found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

    <div class="all-orders" onclick="window.location.href='ordermanage.php'">All orders →</div>
</div>
</body>
</html>
