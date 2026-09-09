<?php
session_start();
include 'nav.php'; // Include navbar from nav.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Available Watches | GenTwo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { font-family: "Inter", sans-serif; background: #f8f9fa; }

    .bg-gold{background-color:#d4af37;} 
    .text-gold{color:#d4af37;}
    
    .btn-gold{
      background-color:#d4af37;
      color:#fff;
      border:none;
      transition: background 0.3s, transform 0.3s;
    }
    .btn-gold:hover{
      background:#b9962f;
      transform: translateY(-2px);
    }

    /* Card style like homepage */
    .card{
      border-radius: 12px;
      overflow: hidden;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      cursor: pointer;
    }
    .card:hover{
      transform: translateY(-8px);
      box-shadow: 0 12px 25px rgba(0,0,0,0.15);
    }

    .card-img-top{
      object-fit: cover;
      height: 250px;
    }

    .card-body h5{
      font-weight: 700;
    }

    .card-body p{
      margin-bottom: 10px;
    }
footer{background:#0e0047ff; color:#aaa;} footer a{color:#aaa; transition:color .3s;} footer a:hover, footer .bi:hover{color:#d4af37;}
    /* Note: You may need to adjust font-family, sizes, and colors 
   to match your overall website styles. */

.footer {
    background-color: #1a232f; /* Dark background color */
    color: #ffffff; /* White text color */
    padding: 60px 0 20px; /* Padding for the top/bottom */
    font-family: Arial, sans-serif; /* Example font */
}

.footer-container {
    max-width: 1200px; /* Max width to match the content area */
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    padding: 0 20px 40px; /* Padding inside the main footer area */
    flex-wrap: wrap; /* Allows wrapping on smaller screens */
    gap: 30px; /* Space between columns */
}

.footer-brand,
.footer-links,
.footer-contact {
    flex-basis: 22%; /* Adjust column width */
    min-width: 180px; /* Minimum width for smaller screens */
}

/* --- Brand Section --- */
.footer-logo {
    /* Assuming the logo is mostly text/light in color on a dark background */
    max-width: 150px;
    height: auto;
    margin-bottom: 15px;
}

.footer-brand p {
    font-size: 14px;
    line-height: 1.6;
    margin-bottom: 20px;
    opacity: 0.7;
}

.social-links a {
    color: #ffffff;
    font-size: 18px;
    margin-right: 15px;
    transition: color 0.3s;
}

.social-links a:hover {
    color: #a0a0a0; /* Subtle hover effect */
}


/* --- Links and Contact Sections --- */
.footer-links h3,
.footer-contact h3 {
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 20px;
    text-transform: uppercase;
}

.footer-links ul,
.footer-contact ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links li,
.footer-contact li {
    margin-bottom: 10px;
}

.footer-links a,
.footer-contact li {
    color: #ffffff;
    text-decoration: none;
    font-size: 14px;
    opacity: 0.7;
    transition: opacity 0.3s;
    display: block; /* Makes the entire area clickable for links */
}

.footer-links a:hover {
    opacity: 1;
}

.footer-contact li i {
    margin-right: 8px;
    width: 15px; /* Aligns the icons */
    text-align: center;
}

/* --- Bottom Bar --- */
.footer-bottom {
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px 20px 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 12px;
}

.footer-bottom p {
    margin: 0;
    opacity: 0.5;
}

.footer-legal a {
    color: #ffffff;
    text-decoration: none;
    margin-left: 15px;
    opacity: 0.5;
    transition: opacity 0.3s;
}

.footer-legal a:hover {
    opacity: 1;
}

/* --- Responsive Adjustments --- */
@media (max-width: 768px) {
    .footer-container {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .footer-brand,
    .footer-links,
    .footer-contact {
        flex-basis: 100%;
        min-width: unset;
        margin-bottom: 20px;
    }

    .footer-bottom {
        flex-direction: column;
    }

    .footer-bottom p {
        margin-bottom: 10px;
    }

    .footer-legal a {
        margin: 0 8px;
    }
}
  </style>
</head>
<body>

<section class="py-5 bg-light mt-5">
  <div class="container">
    <h2 class="fw-bold text-center mb-4">Available Offers</h2>
    <div class="row g-4">

      <!-- Rolex -->
      <div class="col-md-4">
        <div class="card h-100">
          <img src="w1.webp" class="card-img-top" alt="Rolex">
          <div class="card-body text-center">
            <h5 class="card-title">Rolex Oyster Perpetual</h5>
            <p class="text-secondary small">Classic design with unmatched precision.</p>
            <p class="fw-semibold text-gold fs-5">₱450,000</p>
            <a href="#" class="btn btn-gold w-100 add-to-cart">Add to Cart</a>
          </div>
        </div>
      </div>

      <!-- Omega -->
      <div class="col-md-4">
        <div class="card h-100">
          <img src="w2.jfif" class="card-img-top" alt="Omega Seamaster">
          <div class="card-body text-center">
            <h5 class="card-title">Omega Seamaster</h5>
            <p class="text-secondary small">Adventure-ready luxury built for performance.</p>
            <p class="fw-semibold text-gold fs-5">₱380,000</p>
            <a href="#" class="btn btn-gold w-100 add-to-cart">Add to Cart</a>
          </div>
        </div>
      </div>

      <!-- Cartier -->
      <div class="col-md-4">
        <div class="card h-100">
          <img src="w3.jpg" class="card-img-top" alt="Cartier Tank">
          <div class="card-body text-center">
            <h5 class="card-title">Cartier Tank</h5>
            <p class="text-secondary small">Precision engineering meets timeless luxury.</p>
            <p class="fw-semibold text-gold fs-5">₱290,000</p>
            <a href="#" class="btn btn-gold w-100 add-to-cart">Add to Cart</a>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- Footer -->
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
<script>
  
  let cart = JSON.parse(localStorage.getItem('cart') || '[]');

  const addToCartButtons = document.querySelectorAll('.add-to-cart');

  addToCartButtons.forEach(button => {
      button.addEventListener('click', (e) => {
          e.preventDefault();
          const card = e.target.closest('.card');
          const name = card.querySelector('.card-title').textContent.trim();
          const priceText = card.querySelector('.fw-semibold').textContent.replace(/[₱,]/g,'').trim();
          const price = parseFloat(priceText);

          
          cart.push({ name, price });

          
          localStorage.setItem('cart', JSON.stringify(cart));

          alert(`${name} added to cart!`);
      });
  });
</script>

</body>
</html>