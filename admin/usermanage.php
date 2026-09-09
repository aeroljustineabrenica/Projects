<?php 
include 'side.php'; 

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM userm WHERE id=?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    header("Location: usermanage.php");
    exit();
}

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$sql = "SELECT * FROM userm WHERE full_name LIKE ? OR email LIKE ? OR username LIKE ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$like = "%$search%";
$stmt->bind_param("sss", $like, $like, $like);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Management - GENTWO</title>
<link rel="stylesheet" href="usermanage.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<style>
body {margin:0;font-family:Arial,sans-serif;background:#f8f9fb;}
.main {padding:30px;max-width:1200px;margin:auto;}
.filters {margin-bottom:20px;}
.search-area {display:flex;gap:10px;align-items:center;}
.search-bar {display:flex;align-items:center;border:1px solid #ddd;border-radius:25px;background:#fff;padding:5px 15px;width:220px;}
.search-bar input {border:none;outline:none;flex:1;padding:5px;background:none;}
table {width:100%;border-collapse:collapse;border-radius:10px;overflow:hidden;background:#fff;}
th, td {text-align:center;padding:12px;}
th {background:#f5f7fa;color:#555;font-weight:600;}
tr:nth-child(even){background:#fafcff;}
.actions i {cursor:pointer;margin:0 5px;}
.actions .fa-trash {color:#dc3545;}
.all-users {margin-top:15px;font-size:14px;color:#2c2452;cursor:pointer;}
</style>
</head>
<body>

<div class="main">
    <h2>User Management</h2>
    <p style="color:gray;">Manage all users in one place.</p>

    <div class="filters">
        <form class="search-area" method="GET">
            <div class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" name="search" placeholder="Search" value="<?= htmlspecialchars($search) ?>">
            </div>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>Full Name</th>
                <th>Email</th>
                <th>Username</th>
                <th>Joined Date</th>
                <th>Last Active</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while($user = $result->fetch_assoc()): ?>
            <tr>
                <td><i class="fas fa-user-circle"></i> <?= htmlspecialchars($user['full_name']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td><?= date("F j, Y", strtotime($user['joined_date'])) ?></td>
                <td><?= htmlspecialchars($user['last_active']) ?></td>
                <td class="actions">
                    <a href="usermanage.php?delete=<?= $user['id'] ?>" onclick="return confirm('Are you sure you want to delete this user?')"><i class="fas fa-trash"></i></a>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="6">No users found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

    <div class="all-users" onclick="window.location.href='usermanage.php'">All users →</div>
</div>

</body>
</html>