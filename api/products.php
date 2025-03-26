<?php
header('Content-Type: application/json');
require '../db.php';

$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';

// Sanitize input to prevent SQL injection
$search = mysqli_real_escape_string($conn, $search);
$category = mysqli_real_escape_string($conn, $category);

// Build SQL query to join products and categories
$sql = "SELECT *
        FROM products p
        
        WHERE status = 'ACTIVE'";

if (!empty($search)) {
    $sql .= " AND p.name LIKE '%$search%'";
}

if (!empty($category)) {
    $sql .= " AND p.category LIKE '%$category%'";
}

$result = mysqli_query($conn, $sql);

$products = [];
while ($row = mysqli_fetch_assoc($result)) {
    $products[$row['id']] = [
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

    $categoryIds = json_decode($row['category']);
    
    // Loop through each category ID to fetch the category name
    if (is_array($categoryIds)) {
        foreach ($categoryIds as $categoryId) {
            // Fetch category name from the categories table
            $categoryQuery = "SELECT cate_name FROM categories WHERE id = '$categoryId'";
            $categoryResult = mysqli_query($conn, $categoryQuery);
            if ($categoryResult) {
                $category = mysqli_fetch_assoc($categoryResult);
                if ($category) {
                    // Add the category name to the product's category array
                    $products[$row['id']]['category'][] = [
                        'id' => $categoryId,
                        'name' => $category['cate_name']
                    ];
                }
            }
        }
    }
}



// Convert associative array to indexed array for JSON response
echo json_encode(['products' => array_values($products)]);
exit;
?>
