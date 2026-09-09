<?php
include 'side.php';  

$search = "";
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
}


$search_safe = $conn->real_escape_string($search);


$sql = "SELECT * FROM orders";
if ($search !== "") {
    $sql .= " WHERE 
        Product LIKE '%$search_safe%' OR 
        RefNo LIKE '%$search_safe%' OR 
        status LIKE '%$search_safe%' OR 
        Email LIKE '%$search_safe%' OR 
        FullName LIKE '%$search_safe%' OR 
        Price LIKE '%$search_safe%'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Order Management - GENTWO</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
}

.main {
    padding: 20px;
    padding-left: 260px;
}


.status {
    font-size: 12px;
    padding: 4px 10px;
    border-radius: 10px;
    color: #333;
}
.status.Reserved { background: #c2f0ff; color: #006699; }
.status.Cancelled { background: #ffd4e3; color: #a10033; }
.status.Pending { background: #fff3cd; color: #856404; }

.dropdown-item{
    color: green;
}
</style>
</head>
<body>

<div class="main">
    <h2>Order Management</h2>
    <p style="color:gray;">You can manage the orders of the customers.</p>

    <div class="d-flex justify-content-start mb-3">
        <form method="GET" class="d-flex gap-2">
            <input type="text" name="search" class="form-control" placeholder="Search Product" value="<?= htmlspecialchars($search) ?>">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>

    <table class="table table-striped table-bordered">
        <thead class="table-light">
            <tr>
                <th>Item</th>
                <th>Ref No.</th>
                <th>Status</th>
                <th>Email</th>
                <th>Customer Name</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($order = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($order['Product']) ?></td>
                        <td><?= htmlspecialchars($order['RefNo']) ?></td>
                        <td>
                            <span class="status <?= htmlspecialchars($order['status']) ?>">
                                <?= htmlspecialchars($order['status']) ?>
                            </span>
                        </td>
                        <td><?= htmlspecialchars($order['Email']) ?></td>
                        <td><?= htmlspecialchars($order['FullName']) ?></td>
                        <td>PHP <?= number_format($order['Price'], 2) ?></td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    Actions
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="status.php?id=<?= $order['id'] ?>&status=Reserved">Reserve</a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="status.php?id=<?= $order['id'] ?>&status=Cancelled" onclick="return confirm('Are you sure you want to cancel this order?')">Cancel</a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="deleteitem.php?id=<?= $order['id'] ?>" onclick="return confirm('Are you sure you want to remove this order permanently?')">Remove</a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="7" class="text-center text-muted">No orders found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
