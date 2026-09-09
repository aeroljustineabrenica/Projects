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

    .hero-section {
      position: relative;
      min-height: 90vh;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      color: #fff;
      overflow: hidden;
    }
    .hero-section::before {
      content: "";
      position: absolute;
      inset: 0;
      background: rgba(0,0,0,0.35);
      z-index: 1;
    }
    .hero-video {
      position: absolute;
      top: 50%;
      left: 50%;
      width: 100%;
      height: 100%;
      object-fit: cover;
      transform: translate(-50%, -50%);
      z-index: 0;
    }
    .hero-content{
      position: relative;
      z-index: 2;
    }

    @media(max-width:768px){ 
      .hero-section{min-height:70vh;} 
      .hero-section h1{font-size:2rem;} 
    }

    .bg-gold{background-color:#d4af37;} 
    .text-gold{color:#d4af37;}
    .btn-gold{background:#d4af37; color:#fff; border:none; font-weight:600; transition:background .3s,transform .3s;}
    .btn-gold:hover{background:#c29a2b; transform:translateY(-2px);}

    footer{background:#0e0047ff; color:#aaa;} 
    footer a{color:#aaa; transition:color .3s;} 
    footer a:hover, footer .bi:hover{color:#d4af37;}

    
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
  </style>
</head>
<body>

  <div id="searchBar" class="bg-light py-3 shadow-sm" style="display:none;">
    <div class="container d-flex justify-content-center">
      <input type="text" class="form-control w-50" placeholder="Search watches...">
    </div>
  </div>

  <section class="hero-section" id="hero-section">
    <video autoplay muted loop playsinline class="hero-video">
      <source src="vbg.mp4" type="video/mp4">
    </video>
    <div class="container hero-content">
      <h1 class="fw-bold mb-3">Timeless <span class="text-gold">Luxury</span><br>Crafted to Perfection</h1>
      <p class="mb-2">Located at <span class="text-gold fw-bold">Lipa City Colleges, Lipa City</span></p>
      <p>Discover our exclusive collection of luxury timepieces. Each watch tells a story of heritage, precision, and uncompromising quality.</p>
      <a href="watches.php" class="btn btn-gold mt-3">Explore Now</a>
    </div>
  </section>

  <section class="py-5 text-center" id="collections-section">
    <div class="container">
      <h2 class="fw-bold mb-4">Our Collections</h2>
      <p class="text-secondary mb-5">Explore our curated collections, each telling a unique story of precision and timeless design.</p>

      <div class="card border-0 shadow-lg overflow-hidden">
        <div class="row g-0 align-items-center">

          <div class="col-md-6">
            <img src="social.jpeg" class="img-fluid w-100" style="height: 450px; object-fit: cover;">
          </div>

          <div class="col-md-6 p-5 text-start">
            <h3 class="fw-bold mb-3">Our Signature Series</h3>
            <p class="text-secondary">
              Discover timeless elegance, handcrafted precision, and modern durability.  
              Explore the complete range of our watch collections:
            </p>

            <ul class="text-secondary mb-4">
              <li>Modern Classic – Timeless elegance meets tradition</li>
              <li>Prestige Series – Exceptional luxury for collectors</li>
              <li>Active Series – Performance-driven for modern lifestyles</li>
            </ul>

            <a href="watches.php" class="btn btn-gold btn-lg">Explore All Collections</a>
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
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
            </div>
        </div>

        <div class="footer-links">
            <h3>Collections</h3>
            <ul>
                <li><a href="watches.php?category=Rolex">Rolex</a></li>
                <li><a href="watches.php?category=Cartier">Cartier</a></li>
                <li><a href="watches.php?category=Patek Philippe">Patek Philippe</a></li>
                <li><a href="watches.php?category=Omega">Omega</a></li>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
