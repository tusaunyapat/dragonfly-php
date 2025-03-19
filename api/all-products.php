<?php
header('Content-Type: application/json');
require '../db.php';

$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';

// Sanitize input to prevent SQL injection
$search = mysqli_real_escape_string($conn, $search);
$category = mysqli_real_escape_string($conn, $category);

// Build SQL query to join products and categories
$sql = "SELECT p.*, c.cate_name 
        FROM products p 
        INNER JOIN categories c ON p.category = c.id 
        WHERE 1";

if (!empty($search)) {
    $sql .= " AND p.name LIKE '%$search%'";
}

if (!empty($category)) {
    $sql .= " AND p.category = '$category'";
}

$result = mysqli_query($conn, $sql);

// Check for errors in the query
if (!$result) {
    echo json_encode(['error' => 'Error executing query: ' . mysqli_error($conn)]);
    exit;
}

$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Return the products as JSON
echo json_encode(['products' => $products]);
exit;
?>
