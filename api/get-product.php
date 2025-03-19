<?php
require '../db.php'; // Include your database connection file
header('Content-Type: application/json');
if (isset($_GET['id'])) {
    $productId = $_GET['id']; // Get and sanitize the product ID

    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("s", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($product = $result->fetch_assoc()) {
        echo json_encode(["success" => true, "product" => $product]);
    } else {
        echo json_encode(["success" => false, "message" => "Product not found"]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Product ID not provided"]);
}
exit;
?>
