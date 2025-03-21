<?php
require '../db.php'; // Include your database connection file
header('Content-Type: application/json');
if (isset($_GET['id'])) {
    $categoryId = $_GET['id']; // Get and sanitize the category ID

    $stmt = $conn->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->bind_param("s", $categoryId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($category = $result->fetch_assoc()) {
        echo json_encode(["success" => true, "category" => $category]);
    } else {
        echo json_encode(["success" => false, "message" => "category not found"]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "category ID not provided"]);
}
exit;
?>
