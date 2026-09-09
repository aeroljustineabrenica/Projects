<?php
session_start();
include 'nav.php';

// Check login
if (!isset($_SESSION['username'])) {
    echo "<script>
            alert('You need to log in first to make a reservation.');
            window.location.href = 'login.php';
          </script>";
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("DB Connection Failed: ".$conn->connect_error);

// Handle reservation POST
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

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cart | GenTwo</title>
<style>
body { font-family: "Inter", sans-serif; background: #f8f9fa; }
.container { max-width: 800px; margin-top: 80px; }
h2 { color: #0e0047; }
.btn-gold { background-color: #d4af37; color: #fff; border: none; }
.btn-gold:hover { background-color: #c29a2b; }
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
      <input type="text" id="reserveName" class="form-control" placeholder="Full Name" required>
    </div>
    <div class="mb-3">
      <input type="tel" id="reservePhone" class="form-control" placeholder="Phone Number" required>
    </div>
    <div class="mb-3">
      <input type="email" id="reserveEmail" class="form-control" placeholder="Email" required>
    </div>
    <button type="button" class="btn btn-gold w-100 mb-2" id="reserveCart">Reserve</button>
    <button type="button" class="btn btn-outline-primary w-100" id="viewReserved">View My Reserved Items</button>
  </form>
</div>

<!-- Reservation Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center">
      <div class="modal-header border-0 justify-content-center">
        <img src="g.png" width="80" alt="Logo">
      </div>
      <div class="modal-body">
        <h5 class="mb-3">Reservation Successful</h5>
        Thank you for reserving! Check your email for details.
      </div>
      <div class="modal-footer border-0 justify-content-center">
        <button type="button" class="btn btn-gold" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Reserved Items Modal -->
<div class="modal fade" id="reservedModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">My Reserved Items</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <ul id="reservedList" class="list-group"></ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-gold w-100" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    let cart = JSON.parse(localStorage.getItem('cart') || '[]');
    const username = '<?php echo $_SESSION["username"]; ?>'; // logged-in user
    let reservedItems = JSON.parse(localStorage.getItem('reserved_' + username) || '[]');

    const cartItemsList = document.getElementById('cartItems');
    const cartTotal = document.getElementById('cartTotal');
    const reserveName = document.getElementById('reserveName');
    const reservePhone = document.getElementById('reservePhone');
    const reserveEmail = document.getElementById('reserveEmail');

    function renderCart() {
        cartItemsList.innerHTML = '';
        let total = 0;

        if (cart.length === 0) {
            cartItemsList.innerHTML = '<li class="list-group-item text-center">Your cart is empty.</li>';
        } else {
            cart.forEach((item, i) => {
                const li = document.createElement('li');
                li.className = 'list-group-item d-flex justify-content-between align-items-center';
                li.innerHTML = `
                    <div>
                        <input type="checkbox" class="check-item" data-index="${i}" ${item.checked ? 'checked' : ''}>
                        <strong>${item.name}</strong><br>
                        Ref: <em>${item.ref}</em><br>
                        ₱${parseFloat(item.price).toLocaleString()}
                    </div>
                    <button class="btn btn-sm btn-outline-danger remove-item" data-index="${i}">Remove</button>
                `;
                cartItemsList.appendChild(li);
                total += parseFloat(item.price);
            });

            document.querySelectorAll('.remove-item').forEach(btn => {
                btn.addEventListener('click', e => {
                    const idx = e.target.dataset.index;
                    cart.splice(idx,1);
                    localStorage.setItem('cart', JSON.stringify(cart));
                    renderCart();
                });
            });

            document.querySelectorAll('.check-item').forEach(checkbox => {
                checkbox.addEventListener('change', e => {
                    const idx = e.target.dataset.index;
                    cart[idx].checked = e.target.checked;
                    localStorage.setItem('cart', JSON.stringify(cart));
                });
            });
        }

        cartTotal.textContent = total.toLocaleString();
    }

    renderCart();

    document.getElementById('reserveCart').addEventListener('click', () => {
        const name = reserveName.value.trim();
        const phone = reservePhone.value.trim();
        const email = reserveEmail.value.trim();

        if (!name || !phone || !email || cart.length === 0) {
            alert("Please fill all fields and have at least 1 item in the cart.");
            return;
        }

        const selectedItems = cart.filter(item => item.checked);
        if (selectedItems.length === 0) {
            alert("Please select at least 1 item to reserve.");
            return;
        }

        fetch('reserve.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ name, phone, email, cart: selectedItems })
        })
        .then(res => res.json())
        .then(data => {
            if (data.reservation_id) {
                reservedItems = reservedItems.concat(selectedItems);
                localStorage.setItem('reserved_' + username, JSON.stringify(reservedItems));

                cart = cart.filter(item => !item.checked);
                localStorage.setItem('cart', JSON.stringify(cart));
                renderCart();

                reserveName.value = '';
                reservePhone.value = '';
                reserveEmail.value = '';

                new bootstrap.Modal(document.getElementById('successModal')).show();
            } else if (data.error) {
                alert(data.error);
            }
        });
    });

    document.getElementById('viewReserved').addEventListener('click', () => {
        reservedItems = JSON.parse(localStorage.getItem('reserved_' + username) || '[]');
        const reservedList = document.getElementById('reservedList');
        reservedList.innerHTML = '';

        if (reservedItems.length === 0) {
            const li = document.createElement('li');
            li.className = 'list-group-item text-center';
            li.textContent = 'No items reserved yet.';
            reservedList.appendChild(li);
        } else {
            reservedItems.forEach(item => {
                const li = document.createElement('li');
                li.className = 'list-group-item';
                li.textContent = `${item.name} (Ref: ${item.ref}) - ₱${parseFloat(item.price).toLocaleString()}`;
                reservedList.appendChild(li);
            });
        }

        new bootstrap.Modal(document.getElementById('reservedModal')).show();
    });
});
</script>
</body>
</html>