<?php
session_start();
include 'nav.php'; // Your existing nav with logo and user session check
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cart | GenTwo Timepieces</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { font-family: "Inter", sans-serif; background: #f8f9fa; }
    .container { max-width: 800px; margin-top: 80px; }
    h2 { color: #0e0047; }
    .btn-gold { background-color: #d4af37; color: #fff; border: none; }
    .btn-gold:hover { background-color: #c29a2b; }
    .card { margin-bottom: 20px; }
    .card-title { font-weight: 600; }
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

<div class="container">
  <h2 class="mb-4 text-center">Your Cart</h2>

  <ul id="cartItems" class="list-group mb-3"></ul>
  <p class="fw-bold fs-5">Total: ₱<span id="cartTotal">0</span></p>

  <hr>
  <h5 class="mb-3">Reservation Details</h5>
  <form id="reserveForm">
    <div class="mb-3">
      <label for="reserveName" class="form-label">Full Name</label>
      <input type="text" id="reserveName" class="form-control" placeholder="Enter your name" required>
    </div>
    <div class="mb-3">
      <label for="reservePhone" class="form-label">Phone Number</label>
      <input type="tel" id="reservePhone" class="form-control" placeholder="Enter your phone" required>
    </div>
    <div class="mb-3">
      <label for="reserveEmail" class="form-label">Email Address</label>
      <input type="email" id="reserveEmail" class="form-control" placeholder="Enter your email" required>
    </div>
    <button type="button" class="btn btn-gold w-100" id="reserveCart">Reserve</button>
  </form>
</div>

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

<script>
  let cart = JSON.parse(localStorage.getItem('cart') || '[]');
  const cartItemsList = document.getElementById('cartItems');
  const cartTotal = document.getElementById('cartTotal');

  function updateCartDisplay() {
    cartItemsList.innerHTML = '';
    let total = 0;

    if(cart.length === 0) {
      cartItemsList.innerHTML = '<li class="list-group-item text-center">Your cart is empty.</li>';
    }

    cart.forEach((item, index) => {
      const li = document.createElement('li');
      li.className = 'list-group-item d-flex justify-content-between align-items-center';
      li.innerHTML = `
        <span>${item.name} - ₱${item.price.toLocaleString()}</span>
        <button class="btn btn-sm btn-outline-danger remove-item" data-index="${index}">Remove</button>
      `;
      cartItemsList.appendChild(li);
      total += item.price;
    });

    cartTotal.textContent = total.toLocaleString();

    const removeButtons = document.querySelectorAll('.remove-item');
    removeButtons.forEach(btn => {
      btn.addEventListener('click', e => {
        const index = e.target.dataset.index;
        cart.splice(index, 1);
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartDisplay();
      });
    });
  }

  updateCartDisplay();

  document.getElementById('reserveCart').addEventListener('click', () => {
    if(cart.length === 0) {
      alert("Your cart is empty. Add items before reserving.");
      return;
    }

    const name = document.getElementById('reserveName').value.trim();
    const phone = document.getElementById('reservePhone').value.trim();
    const email = document.getElementById('reserveEmail').value.trim();

    if(!name || !phone || !email){
      alert("Please fill in all reservation details.");
      return;
    }

    let message = `✅ Reservation Confirmed!\n\nName: ${name}\nPhone: ${phone}\nEmail: ${email}\n\nItems Reserved:\n`;

    cart.forEach(item => {
      message += `• ${item.name} - ₱${item.price.toLocaleString()}\n`;
    });

    alert(message);

    cart = [];
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartDisplay();
    document.getElementById('reserveForm').reset();
  });
</script>

</body>
</html>