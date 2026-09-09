<?php
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="dashboard.php">
      <img src="g.png" alt="GenTwo Logo" style="height:40px; width:40px; border-radius:6px;" class="me-2">
      <span style="color: navy; font-weight: bold;">GenTwo Timepieces</span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav align-items-lg-center">

        <li class="nav-item">
          <a class="nav-link" href="dashboard.php">Home</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="watches.php">Catalog</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="cart.php">
            <i class="bi bi-cart-fill me-1"></i>Cart
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="about.php"></i>About</a>
        </li>

        <?php if(!isset($_SESSION['username'])): ?>
        <li class="nav-item">
          <a class="nav-link" href="login.php">Log in</a>
        </li>
        <?php endif; ?>

        <?php if(isset($_SESSION['username'])): ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            <i class="bi bi-person-circle me-1" style="font-size:1.2rem;"></i>
            <span><?php echo $_SESSION['username']; ?></span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown">
            <li><a class="dropdown-item" href="change.php">Change Password</a></li>
            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
          </ul>
        </li>
        <?php endif; ?>

      </ul>
    </div>
  </div>
</nav>

<style>
.nav-link {
    color: #001f3f;
    font-weight: 500;
    transition: color 0.3s ease;
}
.nav-link:hover {
    color: #d4af37;
}
.dropdown-item:hover {
    color: #d4af37;
    background-color: #f8f9fa;
}

.hero-section::before {
    z-index: 0;
    position: absolute;
}
</style>