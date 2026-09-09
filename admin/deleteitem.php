<?php
include 'side.php'; 

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid order ID");
}

$order_id = intval($_GET['id']);


$stmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
$stmt->bind_param("i", $order_id);

if ($stmt->execute()) {
    $stmt->close();
    header("Location: ordermanage.php?success=Order+removed+successfully");
    exit;
} else {
    die("Failed to remove order.");
}
