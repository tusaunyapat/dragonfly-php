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

            $existingImageUrls = isset($_POST['existingImages']) ? json_decode($_POST['existingImages'], true) : [];

            // $imagePaths should be an array containing the newly uploaded image URLs
            // You need to combine the existing image URLs and the newly uploaded ones
            $combinedImageUrls = array_merge($existingImageUrls, $imagePaths);

            // Now encode the combined array into JSON
            $urls = json_encode($combinedImageUrls);

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
            $sql = "SELECT p.*, c.cate_name 
                    FROM products p 
                    INNER JOIN categories c ON p.category = c.id 
                    WHERE 1";

            $result = mysqli_query($conn, $sql);

            // Check for errors in the query
            if (!$result) {
                echo json_encode(['error' => 'Error executing query: ' . mysqli_error($conn)]);
                exit;
            }

            $products = mysqli_fetch_all($result, MYSQLI_ASSOC);

            // Return the products as JSON
            echo json_encode(['products' => $products]);
        } elseif ($_GET['action'] === 'categories') {
            $stmt = $conn->query("SELECT id, cate_name FROM categories");
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($categories);
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Get the raw POST data (it could be JSON or URL-encoded)
    $input = file_get_contents('php://input');
    $data = json_decode($input, true); // Decode JSON to an associative array

    if (isset($data['id'])) {
        $productId = $data['id']; // Get and sanitize the product ID

        // Prepare the DELETE query
        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("s", $productId); // Bind productId as a string (UUID)
        $stmt->execute();

        // Check if the product was deleted
        if ($stmt->affected_rows > 0) {
            echo json_encode(["success" => true, "message" => "Product deleted successfully"]);
        } else {
            echo json_encode(["success" => false, "message" => "Cannot delete product or product not found"]);
        }

        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(["success" => false, "message" => "Product ID not provided"]);
    }


}

?>
