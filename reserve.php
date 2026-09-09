<?php
session_start();

if (!isset($_SESSION['username'])) {
    echo json_encode(['error' => 'You must log in first.']);
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['error' => 'DB Connection Failed: ' . $conn->connect_error]);
    exit;
}

$input = json_decode(file_get_contents("php://input"), true);
if (!$input) {
    echo json_encode(['error' => 'No data received']);
    exit;
}

$name = $conn->real_escape_string($input['name']);
$phone = $conn->real_escape_string($input['phone']);
$email = $conn->real_escape_string($input['email']);
$cart = $input['cart'];

if (empty($name) || empty($phone) || empty($email) || empty($cart)) {
    echo json_encode(['error' => 'Missing fields or empty cart']);
    exit;
}

$reservation_ids = [];
foreach($cart as $item) {
    $product = $conn->real_escape_string($item['name']);
    $ref = $conn->real_escape_string($item['ref']);
    $price = floatval($item['price']);

    $sql = "INSERT INTO Orders (Product, RefNo, FullName, Email, PhoneNo, Price) 
            VALUES ('$product','$ref','$name','$email','$phone',$price)";
    if($conn->query($sql)) {
        $reservation_ids[] = $conn->insert_id;
    } else {
        echo json_encode(['error' => $conn->error]);
        exit;
    }
}

echo json_encode(['reservation_id' => implode(',', $reservation_ids)]);
$conn->close();