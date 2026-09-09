<?php
include 'side.php'; 

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = (int) $_GET['id'];
    $status = $conn->real_escape_string($_GET['status']);

    $sql = "UPDATE orders SET status='$status' WHERE id=$id";
    if ($conn->query($sql)) {
        header("Location: ordermanage.php?success=" . urlencode("Order status changed to $status"));
        exit();
    } else {
        echo "Error updating status: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}
?>