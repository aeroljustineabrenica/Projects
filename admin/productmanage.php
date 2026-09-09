<?php
session_start();
include 'side.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'localhost';
$db = 'user_db';
$user = 'root';
$pass = '';
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$uploadDir = 'uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'add_multiple') {
        $names = $_POST['name'];
        $refs = $_POST['ref'];
        $prices = $_POST['price'];
        $descriptions = $_POST['description'];
        $categories = $_POST['category'];
        $files = $_FILES['img'];

        for ($i = 0; $i < count($names); $i++) {
            if (!empty($names[$i]) && isset($files['error'][$i]) && $files['error'][$i] === UPLOAD_ERR_OK) {
                $filename = time() . '_' . preg_replace("/[^a-zA-Z0-9\._-]/", "", basename($files['name'][$i]));
                $targetFile = $uploadDir . $filename;

                if (move_uploaded_file($files['tmp_name'][$i], $targetFile)) {
                    $stmt = $pdo->prepare("INSERT INTO watches (name, ref, price, description, img, category) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->execute([$names[$i], $refs[$i], floatval($prices[$i]), $descriptions[$i], $targetFile, $categories[$i]]);
                }
            }
        }
        header("Location: productmanage.php");
        exit;

    } elseif ($action === 'edit' && isset($_POST['id'])) {
        $id = intval($_POST['id']);
        $imgPath = $_POST['old_img'];

        if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
            $filename = time() . '_' . preg_replace("/[^a-zA-Z0-9\._-]/", "", basename($_FILES['img']['name']));
            $targetFile = $uploadDir . $filename;
            if (move_uploaded_file($_FILES['img']['tmp_name'], $targetFile)) {
                if (file_exists($imgPath)) unlink($imgPath);
                $imgPath = $targetFile;
            }
        }

        $stmt = $pdo->prepare("UPDATE watches SET name=?, ref=?, price=?, description=?, img=?, category=? WHERE id=?");
        $stmt->execute([$_POST['name'], $_POST['ref'], floatval($_POST['price']), $_POST['description'], $imgPath, $_POST['category'], $id]);
        header("Location: productmanage.php");
        exit;

    } elseif ($action === 'delete' && isset($_POST['id'])) {
        $id = intval($_POST['id']);
        $stmt = $pdo->prepare("SELECT img FROM watches WHERE id=?");
        $stmt->execute([$id]);
        $imgToDelete = $stmt->fetchColumn();
        if ($imgToDelete && file_exists($imgToDelete)) unlink($imgToDelete); 

        $stmt = $pdo->prepare("DELETE FROM watches WHERE id=?");
        $stmt->execute([$id]);
        header("Location: productmanage.php");
        exit;
    }
}


$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$filterCat = isset($_GET['filter_category']) ? $_GET['filter_category'] : '';


$sql = "SELECT * FROM watches WHERE 1=1";
$params = [];

if ($search) {
    $sql .= " AND (name LIKE ? OR ref LIKE ? OR description LIKE ?)";
    $term = "%$search%";
    $params[] = $term;
    $params[] = $term;
    $params[] = $term;
}

if ($filterCat) {
    $sql .= " AND category = ?";
    $params[] = $filterCat;
}

$sql .= " ORDER BY id DESC";


$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Watches | GenTwo</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { font-family: "Inter", sans-serif; background: #f8f9fa; }
.card { border-radius:12px; }
.card-img-top { object-fit:cover; height:150px; }
textarea { resize: none; }
.search-box { background: #fff; padding: 15px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
</style>
</head>

<body>
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Manage Watches</h2>
    </div>

    
    <div class="search-box mb-4">
        <form method="GET" class="row g-2">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control" placeholder="Search name, ref, or description..." value="<?= htmlspecialchars($search) ?>">
            </div>
            <div class="col-md-3">
                <select name="filter_category" class="form-select">
                    <option value="">All Categories</option>
                    <option value="Rolex" <?= $filterCat === 'Rolex' ? 'selected' : '' ?>>Rolex</option>
                    <option value="Patek Philippe" <?= $filterCat === 'Patek Philippe' ? 'selected' : '' ?>>Patek Philippe</option>
                    <option value="Cartier" <?= $filterCat === 'Cartier' ? 'selected' : '' ?>>Cartier</option>
                    <option value="Omega" <?= $filterCat === 'Omega' ? 'selected' : '' ?>>Omega</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Search</button>
            </div>
            <?php if($search || $filterCat): ?>
            <div class="col-md-2">
                <a href="productmanage.php" class="btn btn-outline-secondary w-100">Clear</a>
            </div>
            <?php endif; ?>
        </form>
    </div>

    
    <div class="card mb-4 p-3 border-success border-2">
        <h5 class="mb-3 text-success">Add New Watch</h5>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="add_multiple">

            <div class="row g-3 mb-2 product-row">
                <div class="col-md-2">
                    <input type="text" class="form-control" name="name[]" placeholder="Name" required>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="ref[]" placeholder="Reference #" required>
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control" name="price[]" placeholder="Price" required>
                </div>
                <div class="col-md-2">
                    <textarea class="form-control" name="description[]" placeholder="Desc" rows="1" required></textarea>
                </div>
                <div class="col-md-2">
                    <select class="form-control" name="category[]" required>
                        <option value="">Category</option>
                        <option value="Rolex">Rolex</option>
                        <option value="Patek Philippe">Patek Philippe</option>
                        <option value="Cartier">Cartier</option>
                        <option value="Omega">Omega</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="file" class="form-control" name="img[]" accept="image/*" required>
                </div>
                <div class="col-md-12 mt-2">
                    <button class="btn btn-success w-100" type="submit">Add to collection</button>
                </div>
            </div>
        </form>
    </div>

    <hr class="my-4">

    
    <?php if($search || $filterCat): ?>
        <p class="text-muted">Found <?= count($products) ?> result(s).</p>
    <?php endif; ?>

    
    <div class="row g-4">
        <?php if(!empty($products)): ?>
            <?php foreach($products as $watch): ?>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <img src="<?= htmlspecialchars($watch['img']) ?>" class="card-img-top" alt="Watch Image">
                    
                    <div class="p-3">
                        
                        <h5 class="card-title"><?= htmlspecialchars($watch['name']) ?></h5>
                        <p class="text-muted small mb-1">Ref: <?= htmlspecialchars($watch['ref']) ?> | <?= htmlspecialchars($watch['category']) ?></p>
                        <p class="fw-bold text-success">₱<?= number_format($watch['price'], 2) ?></p>

                        
                        <button class="btn btn-sm btn-outline-primary w-100 mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#editForm<?= $watch['id'] ?>">
                            Edit Details
                        </button>

                        <div class="collapse" id="editForm<?= $watch['id'] ?>">
                            <div class="card card-body bg-light p-2 mb-2">
                               
                                <form method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="action" value="edit">
                                    <input type="hidden" name="id" value="<?= $watch['id'] ?>">
                                    <input type="hidden" name="old_img" value="<?= htmlspecialchars($watch['img']) ?>">

                                    <div class="mb-1"><label class="small">Name</label><input type="text" name="name" value="<?= htmlspecialchars($watch['name']) ?>" required class="form-control form-control-sm"></div>
                                    <div class="mb-1"><label class="small">Ref</label><input type="text" name="ref" value="<?= htmlspecialchars($watch['ref']) ?>" required class="form-control form-control-sm"></div>
                                    <div class="mb-1"><label class="small">Price</label><input type="number" name="price" value="<?= $watch['price'] ?>" required class="form-control form-control-sm"></div>
                                    
                                    <div class="mb-1"><label class="small">Desc</label><textarea name="description" class="form-control form-control-sm" required><?= htmlspecialchars($watch['description']) ?></textarea></div>

                                    <div class="mb-1">
                                        <label class="small">Category</label>
                                        <select name="category" class="form-control form-control-sm" required>
                                            <option value="Rolex" <?= $watch['category']=="Rolex"?"selected":"" ?>>Rolex</option>
                                            <option value="Patek Philippe" <?= $watch['category']=="Patek Philippe"?"selected":"" ?>>Patek Philippe</option>
                                            <option value="Cartier" <?= $watch['category']=="Cartier"?"selected":"" ?>>Cartier</option>
                                            <option value="Omega" <?= $watch['category']=="Omega"?"selected":"" ?>>Omega</option>
                                        </select>
                                    </div>

                                    <div class="mb-2"><label class="small">Image</label><input type="file" name="img" accept="image/*" class="form-control form-control-sm"></div>

                                    <button class="btn btn-primary btn-sm w-100">Save Changes</button>
                                </form>
                            </div>
                        </div>

                        
                        <form method="POST" onsubmit="return confirm('Are you sure you want to delete this watch?');">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= $watch['id'] ?>">
                            <button class="btn btn-danger btn-sm w-100">Delete</button>
                        </form>

                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <h4 class="text-muted">No watches found matching your search.</h4>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>