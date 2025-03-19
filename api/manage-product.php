<?php
require '../db.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        
        if ($action === 'create' || $action === 'update') {
            $id = $_POST['id'] ?? null;
            $name = $_POST['name'];
            $brand = $_POST['brand'];
            $category = $_POST['category'];
            $price = $_POST['price'];
            $description = $_POST['description'];
            $detail = $_POST['detail'];
            $status = $_POST['status'];
            $created_at = $action === 'create' ? date('Y-m-d H:i:s') : $_POST['created_at'];

            // Handling file uploads
            $imagePaths = [];

            if (isset($_FILES['images'])) {
    $uploadedFiles = $_FILES['images'];
    // Log files received
    error_log("Received Files: " . print_r($uploadedFiles, true)); // Log all received files info

    foreach ($uploadedFiles['tmp_name'] as $key => $tmp_name) {
        // Log each file name and temp name
        error_log("Processing File: " . $uploadedFiles['name'][$key] . " - Temp Name: " . $tmp_name);
    }
}


            if (!empty($_FILES['images']['name'][0])) {
                foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                    $fileName = time() . '-' . $_FILES['images']['name'][$key];
                    $filePath = 'uploads/' . $fileName;

                    // Move the uploaded file to the target directory
                    if (move_uploaded_file($tmp_name, '../' . $filePath)) {
                        $imagePaths[] = $filePath;
                    }
                }
            }

            $urls = json_encode($imagePaths); // Store image paths as JSON

            if ($action === 'create') {
                // Insert new product
                $stmt = $conn->prepare("INSERT INTO products (name, created_at, brand, category, price, description, detail, status, urls) 
                                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$name, $created_at, $brand, $category, $price, $description, $detail, $status, $urls]);
            } else {
                // Update existing product
                $stmt = $conn->prepare("UPDATE products SET name=?, brand=?, category=?, price=?, description=?, detail=?, status=?, urls=? WHERE id=?");
                $stmt->execute([$name, $brand, $category, $price, $description, $detail, $status, $urls, $id]);
            }

            echo json_encode(['status' => 'success', 'message' => 'Product saved successfully']);
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['action'])) {
        if ($_GET['action'] === 'fetch') {
            $stmt = $conn->query("SELECT * FROM products");
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($products);
        } elseif ($_GET['action'] === 'categories') {
            $stmt = $conn->query("SELECT id, cate_name FROM categories");
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($categories);
        }
    }
}
?>
