<?php
require '../db.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        
        if ($action === 'create' || $action === 'update') {
            $id = $_POST['id'] ?? null;
            $cate_name = $_POST['cate_name'];
           
            


            if ($action === 'create') {
                // Insert new product
                $stmt = $conn->prepare("INSERT INTO categories (cate_name) VALUES (?)");
                $stmt->execute([$cate_name]);
            } else {
                // Update existing product
                
                $stmt = $conn->prepare("UPDATE categories SET cate_name=? WHERE id=?");
                $stmt->execute([$cate_name, $id]);
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
        $categoryId = $data['id']; // Get and sanitize the category ID

        // Prepare the DELETE query
        $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->bind_param("s", $categoryId); // Bind categoryId as a string (UUID)
        $stmt->execute();

        // Check if the category was deleted
        if ($stmt->affected_rows > 0) {
            echo json_encode(["success" => true, "message" => "category deleted successfully"]);
        } else {
            echo json_encode(["success" => false, "message" => "Cannot delete category or category not found"]);
        }

        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(["success" => false, "message" => "category ID not provided"]);
    }


}

?>
