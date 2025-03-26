<?php
require '../db.php'; // Include your database connection file
header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $productId = $_GET['id']; // Get and sanitize the product ID

    // Prepare the SQL query
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("s", $productId);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        // Initialize the product array
        $product = [
            'id' => $row['id'],
            'name' => $row['name'],
            'price' => $row['price'],
            'status' => $row['status'],
            'brand' => $row['brand'],
            'description' => $row['description'],
            'urls' => $row['urls'],
            'detail' => $row['detail'],
            'category' => [] // Placeholder for categories
        ];

        // Decode the category IDs
        $categoryIds = json_decode($row['category']);

        // Loop through each category ID to fetch the category name
        if (is_array($categoryIds)) {
            foreach ($categoryIds as $categoryId) {
                // Fetch category name from the categories table
                $categoryQuery = "SELECT cate_name FROM categories WHERE id = ?";
                $categoryStmt = $conn->prepare($categoryQuery);
                $categoryStmt->bind_param("s", $categoryId);
                $categoryStmt->execute();
                $categoryResult = $categoryStmt->get_result();
                if ($category = $categoryResult->fetch_assoc()) {
                    // Add the category name to the product's category array
                    $product['category'][] = [
                        'id' => $categoryId,
                        'name' => $category['cate_name']
                    ];
                }
                $categoryStmt->close();
            }
        }

        // Return the product details in JSON format
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
