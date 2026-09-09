<?php
session_start();
include 'nav.php';
$loggedIn = isset($_SESSION['username']); 

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


$categoryFilter = isset($_GET['category']) ? $_GET['category'] : '';
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';

$sql = "SELECT * FROM watches WHERE 1=1"; 
$params = [];

if ($categoryFilter && $categoryFilter != 'All') {
    $sql .= " AND category = ?";
    $params[] = $categoryFilter;
}

if ($searchQuery) {
    $sql .= " AND (name LIKE ? OR ref LIKE ? OR description LIKE ?)"; 
    $searchTerm = "%" . $searchQuery . "%";
    $params[] = $searchTerm;
    $params[] = $searchTerm;
    $params[] = $searchTerm;
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
<title>Available Watches | GenTwo</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
body { font-family: "Inter", sans-serif; background: #f8f9fa; }
.btn-gold{ background-color:#d4af37; color:#fff; border:none; }
.btn-gold:hover{ background:#c29a2b; color: #fff; }
.card{ border-radius:12px; transition: transform 0.2s, box-shadow 0.2s; }
.card:hover{ transform: translateY(-5px); box-shadow:0 10px 20px rgba(0,0,0,0.15); }
.card-img-top{ object-fit:cover; height:250px; }
.card-body h5{ font-weight:700; }
.watch-ref { font-size: 0.9rem; color: #6c757d; }

.search-container { max-width: 600px; margin: 0 auto 30px auto; }
.form-control:focus { border-color: #d4af37; box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25); }

.img-container { position: relative; overflow: hidden; }
.hover-description {
    position: absolute; top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(0,0,0,0.75); color: #fff; padding: 20px;
    opacity: 0; visibility: hidden; transition: opacity 0.25s ease-in-out;
    display: flex; justify-content: center; align-items: center;
    text-align: center; font-size: 0.9rem; line-height: 1.3rem;
}
.watch-card:hover .hover-description { opacity: 1; visibility: visible; }

.categories { display:flex; flex-wrap:wrap; justify-content:center; gap:10px; margin-bottom:30px; }
.category-card { position:relative; width:120px; height:70px; border-radius:10px; overflow:hidden; cursor:pointer; transition: transform 0.2s; }
.category-card img { width:100%; height:100%; object-fit:cover; transition: filter 0.3s; }
.category-card:hover img { filter:brightness(0.5); }
.category-card a { position:absolute; width:100%; height:100%; top:0; left:0; }

footer{background:#1a232f; color:#aaa;} 
footer a{color:#aaa; transition:color .3s;} 
footer a:hover{color:#d4af37;}
.footer { background-color: #1a232f; color: #ffffff; padding: 60px 0 20px; font-family: Arial, sans-serif; }
.footer-container { max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; padding: 0 20px 40px; flex-wrap: wrap; gap: 30px; }
.footer-brand, .footer-links, .footer-contact { flex-basis: 22%; min-width: 180px; }
.footer-logo { max-width: 150px; height: auto; margin-bottom: 15px; }
.footer-brand p { font-size: 14px; line-height: 1.6; margin-bottom: 20px; opacity: 0.7; }
.social-links a { color: #ffffff; font-size: 18px; margin-right: 15px; transition: color 0.3s; }
.social-links a:hover { color: #a0a0a0; }
.footer-links h3, .footer-contact h3 { font-size: 16px; font-weight: bold; margin-bottom: 20px; text-transform: uppercase; }
.footer-links ul, .footer-contact ul { list-style: none; padding: 0; margin: 0; }
.footer-links li, .footer-contact li { margin-bottom: 10px; }
.footer-links a, .footer-contact li { color: #ffffff; text-decoration: none; font-size: 14px; opacity: 0.7; transition: opacity 0.3s; display: block; }
.footer-links a:hover { opacity: 1; }
.footer-contact li i { margin-right: 8px; width: 15px; text-align: center; }
.footer-bottom { border-top: 1px solid rgba(255, 255, 255, 0.1); max-width: 1200px; margin: 0 auto; padding: 20px 20px 0; display: flex; justify-content: space-between; align-items: center; font-size: 12px; }
.footer-bottom p { margin: 0; opacity: 0.5; }
.footer-legal a { color: #ffffff; text-decoration: none; margin-left: 15px; opacity: 0.5; transition: opacity 0.3s; }
.footer-legal a:hover { opacity: 1; }

@media (max-width: 768px) {
    .footer-container { flex-direction: column; align-items: center; text-align: center; }
    .footer-brand, .footer-links, .footer-contact { flex-basis: 100%; min-width: unset; margin-bottom: 20px; }
    .footer-bottom { flex-direction: column; }
}
</style>

</head>
<body>

<div class="container py-5">
  <h2 class="text-center mb-4">Collections</h2>

  <div class="search-container">
    <form action="" method="GET" class="d-flex">
        <?php if($categoryFilter): ?>
            <input type="hidden" name="category" value="<?= htmlspecialchars($categoryFilter) ?>">
        <?php endif; ?>
        
        <input class="form-control me-2" type="search" name="search" 
               placeholder="Search watches (e.g. Daytona, Ref 1234)..." 
               value="<?= htmlspecialchars($searchQuery) ?>" aria-label="Search">
        <button class="btn btn-gold" type="submit">Search</button>
        
        <?php if($searchQuery): ?>
            <a href="?<?= $categoryFilter ? 'category='.$categoryFilter : '' ?>" class="btn btn-outline-secondary ms-2">Clear</a>
        <?php endif; ?>
    </form>
  </div>

  <div class="categories">
      <div class="category-card">
          <img src="rolex.png" alt="Rolex">
          <a href="?category=Rolex"></a>
      </div>
      <div class="category-card">
          <img src="cartier.png" alt="Cartier">
          <a href="?category=Cartier"></a>
      </div>
      <div class="category-card">
          <img src="patek.webp" alt="Patek Philippe">
          <a href="?category=Patek Philippe"></a>
      </div>
      <div class="category-card">
          <img src="omega.webp" alt="Omega">
          <a href="?category=Omega"></a>
      </div>
  </div>

  <?php if($searchQuery): ?>
      <p class="text-center text-muted">
          Showing results for "<strong><?= htmlspecialchars($searchQuery) ?></strong>" 
          <?php if($categoryFilter): ?> in <?= htmlspecialchars($categoryFilter) ?> <?php endif; ?>
      </p>
  <?php endif; ?>

  <div class="row g-4">
    <?php if(!empty($products)): ?>
        <?php foreach($products as $watch): ?>
            <div class="col-md-4">
                <div class="card h-100 watch-card">

                    <div class="img-container">
                        <img src="admin/uploads/<?= basename($watch['img']) ?>" 
                             class="card-img-top" 
                             alt="<?= htmlspecialchars($watch['name']) ?>"
                             onerror="this.src='https://via.placeholder.com/250x250?text=No+Image'">

                        <div class="hover-description">
                            <p><?= nl2br(htmlspecialchars($watch['description'])) ?></p>
                        </div>
                    </div>

                    <div class="card-body text-center">
                        <h5 class="card-title"><?= htmlspecialchars($watch['name']) ?></h5>
                        <p class="watch-ref"><?= htmlspecialchars($watch['ref']) ?> | <?= htmlspecialchars($watch['category']) ?></p>
                        <p class="fw-semibold fs-5">₱<?= number_format($watch['price'], 2) ?></p>

                        <button class="btn btn-gold w-100 add-to-cart"
                            data-name="<?= htmlspecialchars($watch['name']) ?>"
                            data-ref="<?= htmlspecialchars($watch['ref']) ?>"
                            data-price="<?= htmlspecialchars($watch['price']) ?>">
                            Add to Cart
                        </button>
                    </div>

                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12 text-center py-5">
            <h4>No watches found.</h4>
            <p class="text-muted">Try adjusting your search terms or category filter.</p>
            <a href="watches.php" class="btn btn-gold mt-2">View All Watches</a>
        </div>
    <?php endif; ?>
  </div>
</div>

<footer class="footer">
    <div class="footer-container">
        <div class="footer-brand">
            <img src="g.png" alt="GenTwo Timepieces Logo" class="footer-logo">
            <p>Distributors of original luxury watches.<br>Each timepiece represents our commitment to<br>heritage, precision, and perfection.</p>
            <div class="social-links">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
            </div>
        </div>

        <div class="footer-links">
            <h3>Collections</h3>
            <ul>
                <li><a href="?category=Rolex">Rolex</a></li>
                <li><a href="?category=Cartier">Cartier</a></li>
                <li><a href="?category=Patek Philippe">Patek Philippe</a></li>
                <li><a href="?category=Omega">Omega</a></li>
            </ul>
        </div>

        <div class="footer-contact">
            <h3>Contact</h3>
            <ul>
                <li><a href="about.php">Lipa City Colleges, Lipa City, Batangas</a></li>
                <li><i class="fas fa-phone"></i> 09919678834</li>
                <li><i class="fas fa-envelope"></i> timepieces@gmail.com</li>
            </ul>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; 2025 GenTwo Timepieces. All rights reserved.</p>
    </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', () => {
    let cart = JSON.parse(localStorage.getItem('cart') || '[]');
    const loggedIn = <?= $loggedIn ? 'true' : 'false'; ?>;

    document.querySelectorAll('.add-to-cart').forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();

            if (!loggedIn) {
                alert('You must log in first to add items to the cart.');
                window.location.href = 'login.php';
                return;
            }

            const name = btn.dataset.name;
            const ref = btn.dataset.ref;
            const price = parseFloat(btn.dataset.price);

            cart.push({ name, ref, price });
            localStorage.setItem('cart', JSON.stringify(cart));

            alert(`${name} (Ref: ${ref}) added to cart!`);
        });
    });
});
</script>

</body>
</html>