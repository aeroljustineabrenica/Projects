<?php
include 'side.php';

session_start();

if (!isset($_SESSION['adminname']) || $_SESSION['role'] !== 'admin') {
    header("Location: adminlogin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GENTWO Dashboard</title>
    <link rel="stylesheet" href="adminacc.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            background: #ffffff;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            color: #0A1A3C;
        }

        .main {
            margin-left: 250px;
            padding: 20px;
        }

        
        .top-banner {
            background: #0A1A3C;
            padding: 25px;
            border-radius: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 0 10px rgba(0,0,0,0.15);
            color: white;
        }

        .left-banner {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .banner-logo {
            height: 80px;
            border-radius: 10px;
            border: 2px solid #D4AF37; /* gold border */
        }

        .left-banner h1 {
            font-size: 30px;
            margin: 0;
            font-weight: bold;
            letter-spacing: 2px;
            color: #D4AF37; /* gold */
        }

        .left-banner p {
            margin: 5px 0 0 0;
            color: #cfd7e1;
            font-size: 14px;
        }

        .role-badge {
            margin-top: 10px;
            background: #00ff0dff;
            color: black;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 13px;
            display: inline-block;
        }

     
        .logout-button {
            background: #D4AF37;
            color: black;
            border: none;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .logout-button:hover {
            background: #b9972f;
        }

        
        .cards {
            margin-top: 25px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .card {
            background-color: #001f3f;
            padding: 20px;
            border-radius: 12px;
            border: 1px solid rgba(36, 18, 91, 1);
            transition: 0.3s;
            color: white;
        }

        .card:hover {
            transform: translateY(-5px);
            border-color: #D4AF37;
            box-shadow: 0 0 12px rgba(212, 175, 55, 0.4);
        }

        .card h3 {
            margin: 0 0 10px;
            color: #D4AF37;
        }

        .card p {
            color: #dfe6f0;
        }
        .card-link {
    text-decoration: none;
    color: inherit;
}

    .owner-img {
      width: 140px;
      height: 140px;
      object-fit: cover;
      border: 4px solid #d4af37;
      padding: 3px;
    }
    .owner-card { transition: transform .3s, box-shadow .3s; }
    .owner-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    }
    </style>
</head>

<body>
    <div class="main">

       
        <div class="top-banner">
            <div class="left-banner">
                <img src="g.png" alt="Logo" class="banner-logo">
                <div>
                    <h1>GENTWO TIME PIECES</h1>
                    <p>Precision. Elegance. Craftsmanship.</p>
                    <span class="role-badge">ADMIN</span>
                </div>
            </div>
        </div>

        
        <div class="cards">

    <a href="usermanage.php" class="card-link">
        <div class="card">
            <h3>Total Users</h3>
            <p>Manage all customer accounts and registrations.</p>
        </div>
    </a>

    <a href="ordermanage.php" class="card-link">
        <div class="card">
            <h3>Orders</h3>
            <p>View, update, and track customer orders.</p>
        </div>
    </a>

    <a href="productmanage.php" class="card-link">
        <div class="card">
            <h3>Product Management</h3>
            <p>Manage watch stock, categories, and pricing.</p>
        </div>
    </a>

    <a href="sales.php" class="card-link">
        <div class="card">
            <h3>Sales Report</h3>
            <p>Analyze monthly and yearly performance.</p>
        </div>
    </a>
</div>

<section class="owners-section py-5 bg-light">
  <div class="container text-center">
    <h2 class="fw-bold mb-4">Owners</h2>
    <p class="text-secondary mb-5">The visionaries behind GenTwo Timepieces.</p>

    <div class="row g-4 justify-content-center">

      <div class="col-md-4">
        <a href="https://www.facebook.com/just.abrenica" target="_blank" style="text-decoration:none; color:inherit;">
          <div class="card border-0 shadow-sm p-4 owner-card h-100">
            <img src="owner1.jpg" alt="Owner 1" class="rounded-circle mb-3 owner-img">
            <h5 class="fw-bold">Aerol Justine Abrenica</h5>
            <p class="text-gold fw-semibold">Co-Founder & Creative Director</p>
            <p class="text-secondary">
              Passionate about craftsmanship and timeless design, Justine leads the creative vision of GenTwo Timepieces.
            </p>
          </div>
        </a>
      </div>

      <div class="col-md-4">
        <a href="https://www.facebook.com/jc.tapire71/" target="_blank" style="text-decoration:none; color:inherit;">
          <div class="card border-0 shadow-sm p-4 owner-card h-100">
            <img src="owner2.jpg" alt="Owner 2" class="rounded-circle mb-3 owner-img">
            <h5 class="fw-bold">Jonh Carlo Tapire</h5>
            <p class="text-gold fw-semibold">Co-Founder & Operations Lead</p>
            <p class="text-secondary">
              With a strong focus on quality and customer experience, JC ensures every timepiece meets the highest standards.
            </p>
          </div>
        </a>
      </div>

    </div>
  </div>
</section>
</body>
</html>