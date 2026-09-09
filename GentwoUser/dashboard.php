<?php
session_start();
include 'nav.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>GenTwo Timepieces</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    html { scroll-behavior: smooth; }
    body { font-family: "Inter", sans-serif; color: #1a1a1a; }
    .navbar { transition: background-color 0.4s ease, box-shadow 0.4s ease; }
    .navbar.scrolled { background-color: rgba(255,255,255,0.95); box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
    .logo-img { height: 40px; border-radius: 6px; }
    .nav-link { position: relative; color:#333!important; font-weight:500; letter-spacing:0.5px; transition:color 0.4s ease, transform 0.3s ease; padding-bottom:4px; }
    .nav-link::after { content:""; position:absolute; left:50%; bottom:0; width:0%; height:2px; background:#d4af37; transition:all 0.4s ease; transform:translateX(-50%); opacity:0; }
    .nav-link:hover::after, .nav-link.active::after { width:60%; opacity:1; }
    .nav-link:hover, .nav-link.active { color:#b9962f!important; transform:translateY(-2px); }
    .hero-section { position:relative; background:url('bghome.jpg') center/cover no-repeat; min-height:90vh; display:flex; align-items:center; justify-content:center; text-align:center; color:#fff; }
    .hero-section::before { content:""; position:absolute; inset:0; background:rgba(0,0,0,0.55); }
    .hero-section .container { position:relative; z-index:1; }
    .hero-section h1 { font-size:3rem; }
    .hero-section p { color:#e0e0e0; }
    @media(max-width:768px){ .hero-section{min-height:70vh;} .hero-section h1{font-size:2rem;} }
    .bg-gold{background-color:#d4af37;} .text-gold{color:#d4af37;}
    .btn-gold{background:#d4af37; color:#fff; border:none; font-weight:600; transition:background .3s,transform .3s;}
    .btn-gold:hover{background:#c29a2b; transform:translateY(-2px);}
    .card{transition:transform .3s,box-shadow .3s;} .card:hover{transform:translateY(-5px); box-shadow:0 8px 20px rgba(0,0,0,0.1);}
    footer{background:#0e0047ff; color:#aaa;} footer a{color:#aaa; transition:color .3s;} footer a:hover, footer .bi:hover{color:#d4af37;}
    #collections-section .card-img-top { height: 250px; object-fit: cover; }
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
        .footer-bottom p { margin-bottom: 10px; }
        .footer-legal a { margin: 0 8px; }
    }
  </style>
</head>
<body>

  <div id="searchBar" class="bg-light py-3 shadow-sm" style="display:none;">
    <div class="container d-flex justify-content-center">
      <input type="text" class="form-control w-50" placeholder="Search watches...">
    </div>
  </div>

  <section class="hero-section" id="hero-section">
    <div class="container">
      <h1 class="fw-bold mb-3">Timeless <span class="text-gold">Luxury</span><br>Crafted to Perfection</h1>
      <p>Discover our exclusive collection of luxury timepieces. Each watch tells a story of heritage, precision, and uncompromising quality.</p>
      <a href="watches.php" class="btn btn-gold mt-3">Explore Now</a>
    </div>
  </section>

  <section class="py-5 text-center" id="collections-section">
    <div class="container">
      <h2 class="fw-bold mb-4">Our Collections</h2>
      <p class="text-secondary mb-5">Explore our curated collections, each telling a unique story of precision and timeless design.</p>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="card border-0 shadow-sm h-100">
            <img src="social.jpeg" class="card-img-top" alt="Modern Classic">
            <div class="card-body">
              <h5 class="fw-bold">Modern Classic</h5>
              <p class="text-secondary">Timeless elegance meets traditional craftsmanship.</p>
              <a href="watches.php" class="btn btn-gold">Explore Collection</a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card border-0 shadow-sm h-100">
            <img src="roles.webp" class="card-img-top" alt="Prestige Series">
            <div class="card-body">
              <h5 class="fw-bold">Prestige Series</h5>
              <p class="text-secondary">Exceptional luxury timepieces for collectors.</p>
              <a href="watches.php" class="btn btn-gold">Explore Collection</a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card border-0 shadow-sm h-100">
            <img src="smart.webp" class="card-img-top" alt="Active Series">
            <div class="card-body">
              <h5 class="fw-bold">Active Series</h5>
              <p class="text-secondary">Performance-driven watches for modern lifestyles.</p>
              <a href="watches.php" class="btn btn-gold">Explore Collection</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer class="footer">
    <div class="footer-container">
        <div class="footer-brand">
            <img src="g.png" alt="GenTwo Timepieces Logo" class="footer-logo">
            <p>Distributors of original luxury watches.<br>Each timepiece represents our commitment to<br>heritage, precision, and perfection.</p>
            <div class="social-links">
                <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
            </div>
        </div>

        <div class="footer-links">
            <h3>Collections</h3>
            <ul>
                <li><a href="#">Heritage Classic</a></li>
                <li><a href="#">Prestige Series</a></li>
                <li><a href="#">Active Series</a></li>
                <li><a href="#">Limited Editions</a></li>
                <li><a href="#">Vintage Collection</a></li>
            </ul>
        </div>

        <div class="footer-links">
            <h3>Support</h3>
            <ul>
                <li><a href="#">Watch Care</a></li>
                <li><a href="#">Service Centers</a></li>
                <li><a href="#">Warranty</a></li>
                <li><a href="#">Size Guide</a></li>
                <li><a href="#">Contact Us</a></li>
            </ul>
        </div>

        <div class="footer-contact">
            <h3>Contact</h3>
            <ul>
                <li><i class="fas fa-map-marker-alt"></i> Use City Colleges</li>
                <li><i class="fas fa-phone"></i> 09919678834</li>
                <li><i class="fas fa-envelope"></i> timepieces@gmail.com</li>
            </ul>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; 2025 GenTwo Timepieces. All rights reserved.</p>
        <div class="footer-legal">
            <a href="#">Privacy Policy</a>
            <a href="#">Terms of Service</a>
            <a href="#">Cookies</a>
        </div>
    </div>
</footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>