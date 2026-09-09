<?php
include 'connect.php';

if (isset($_POST['id']) && isset($_POST['status'])) {
    $id = intval($_POST['id']);
    $status = $conn->real_escape_string($_POST['status']);

    $sql = "UPDATE orders SET status='$status' WHERE id=$id";
    if ($conn->query($sql)) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "invalid";
}
?>