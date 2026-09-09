<?php
session_start();
include 'nav.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("DB Connection Failed: ".$conn->connect_error);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);
    $name = $conn->real_escape_string($input['name']);
    $phone = $conn->real_escape_string($input['phone']);
    $email = $conn->real_escape_string($input['email']);
    $cart = $input['cart'];

    $reserved_items = [];
    foreach($cart as $item) {
        $product = $conn->real_escape_string($item['name']);
        $ref = $conn->real_escape_string($item['ref']);
        $price = floatval($item['price']);
        $status = 'New';

        $sql = "
            INSERT INTO orders (item, order_id, status, quantity, customer, shipping, price)
            VALUES (
                '$product',
                '$ref',
                '$status',
                1,
                '$name',
                'Standard',
                $price
            )
        ";

        if($conn->query($sql)) {
            $reserved_items[] = [
                'id' => $conn->insert_id,
                'name' => $product,
                'ref' => $ref,
                'price' => $price,
                'status' => $status
            ];
        } else {
            echo json_encode(['error'=>$conn->error]);
            exit;
        }
    }

    echo json_encode(['reserved_items'=>$reserved_items]);
    exit;
}
?>

<!-- HERO -->
<section class="g2-hero position-relative">
  <img src="care.webp" class="img-fluid w-100 hero-img" alt="Gentry Care">
  <div class="hero-overlay d-flex flex-column justify-content-center align-items-center">
      <h1 class="text-white fw-bold animate fade-up">GenTwo Care</h1>
      <p class="text-white animate fade-up delay-1">The Art of Timeless Precision</p>
  </div>
</section>

<!-- CONTACT -->
<section class="py-5 bg-white text-center animate fade-up">
    <div class="container">
        <h2 class="fw-bold mb-3">Contact Us</h2>
        <p class="text-secondary fs-5">Mobile: <strong>+639519676034</strong></p>
        <p class="text-secondary fs-5">Email: <strong>Timepieces@gmail.com</strong></p>
    </div>
</section>

<!-- ABOUT -->
<section class="py-5">
  <div class="container">
      <div class="row align-items-center g-4">
          <div class="col-md-6">
              <img src="care2.webp" class="img-fluid rounded shadow animate fade-left" alt="Watch Care">
          </div>
          <div class="col-md-6">
              <div class="p-4 bg-light rounded shadow-sm animate fade-right">
                  <h3 class="fw-bold mb-3">GenTwo Care</h3>
                  <p class="text-secondary">
                      In the world of horology, every second is a testament to craftsmanship and heritage.
                      GenTwo Care stands as a sanctuary for the discerning watch collector.
                      With a philosophy rooted in mechanical excellence and aesthetic integrity,
                      GenTwo Care is more than servicing—it's the steward of your timepiece's legacy.
                  </p>
              </div>
          </div>
      </div>
  </div>
</section>

<!-- OWNERS -->
<section class="owners-section py-5 bg-light">
  <div class="container text-center">
    <h2 class="fw-bold mb-4 animate fade-up">Meet the Owners</h2>
    <div class="row g-4 justify-content-center">

      <!-- OWNER 1 -->
      <div class="col-md-4 animate fade-left">
        <a href="https://www.facebook.com/just.abrenica" target="_blank" class="owner-link">
          <div class="card border-0 shadow-sm p-4 owner-card h-100">
            <img src="owner1.jpg" class="rounded-circle mb-3 owner-img">
            <h5 class="fw-bold">Aerol Justine Abrenica</h5>
            <p class="text-secondary">Co-Founder & Creative Director</p>
          </div>
        </a>
      </div>

      <!-- OWNER 2 -->
      <div class="col-md-4 animate fade-right">
        <a href="https://www.facebook.com/jc.tapire71" target="_blank" class="owner-link">
          <div class="card border-0 shadow-sm p-4 owner-card h-100">
            <img src="owner2.jpg" class="rounded-circle mb-3 owner-img">
            <h5 class="fw-bold">Jonh Carlo Tapire</h5>
            <p class="text-secondary">Co-Founder & Operations Lead</p>
          </div>
        </a>
      </div>

    </div>
  </div>
</section>

<!-- FOOTER -->
<footer class="footer">
    <div class="footer-container">
        <div class="footer-brand">
            <img src="g.png" alt="GenTwo Timepieces Logo" class="footer-logo">
            <p>Distributors of original luxury watches.<br>Each timepiece represents our commitment to<br>heritage, precision, and perfection.</p>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2025 GenTwo Timepieces. All rights reserved.</p>
    </div>
</footer>

<!-- STYLES -->
<style>
.owner-link {
  text-decoration: none;
  color: inherit;
}
.owner-card {
  transition: transform .3s, box-shadow .3s;
  cursor: pointer;
}
.owner-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}
.owner-img {
  width: 140px;
  height: 140px;
  object-fit: cover;
  border: 4px solid #d4af37;
  padding: 3px;
}
.animate {
  opacity: 0;
  transform: translateY(30px);
  transition: all 0.8s ease-out;
}
.animate.show {
  opacity: 1;
  transform: translateY(0);
}
.fade-left { transform: translateX(-40px); }
.fade-right { transform: translateX(40px); }
</style>

<script>
const animatedElements = document.querySelectorAll('.animate');
const observer = new IntersectionObserver(entries => {
  entries.forEach(entry => {
    if (entry.isIntersecting) entry.target.classList.add('show');
  });
},{threshold:0.2});
animatedElements.forEach(el => observer.observe(el));
</script>