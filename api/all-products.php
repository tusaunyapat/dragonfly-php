<?php
header('Content-Type: application/json');
require '../db.php';



// Build SQL query to join products and categories
$sql = "SELECT p.*, c.cate_name 
        FROM products p 
        LEFT JOIN categories c ON p.category = c.id 
        WHERE 1";

$result = mysqli_query($conn, $sql);

// Check for errors in the query
if (!$result) {
    echo json_encode(['error' => 'Error executing query: ' . mysqli_error($conn)]);
    exit;
}

$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

foreach ($products as &$product) {
    if (is_null($product['cate_name'])) {
        $product['cate_name'] = 'N/A';
    }
}

// Return the products as JSON
echo json_encode(['products' => $products]);
exit;
?>
