<?php
require '../db.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        
        if ($action === 'create' || $action === 'update') {
            $id = $_POST['id'] ?? null;
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $other = $_POST['other'];
            


            if ($action === 'create') {
                // Insert new product
                $stmt = $conn->prepare("INSERT INTO contact (name, phone, other) VALUES (?, ?, ?)");
                $stmt->execute([$name, $phone, $other]);
            } else {
                // Update existing product
                
                $stmt = $conn->prepare("UPDATE contact SET name = ?, phone = ?, other = ? WHERE id=?");
                $stmt->execute([$name, $phone, $other, $id]);
            }

            echo json_encode(['status' => 'success', 'message' => 'Contact saved successfully']);
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
        } elseif ($_GET['action'] === 'contact') {
            $stmt = $conn->query("SELECT * FROM categories");
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($categories);
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Get the raw POST data (it could be JSON or URL-encoded)
    $input = file_get_contents('php://input');
    $data = json_decode($input, true); // Decode JSON to an associative array

    if (isset($data['id'])) {
        $contactId = $data['id']; // Get and sanitize the contact ID

        // Prepare the DELETE query
        $stmt = $conn->prepare("DELETE FROM contact WHERE id = ?");
        $stmt->bind_param("s", $contactId); // Bind contactId as a string (UUID)
        $stmt->execute();

        // Check if the contact was deleted
        if ($stmt->affected_rows > 0) {
            echo json_encode(["success" => true, "message" => "contact deleted successfully"]);
        } else {
            echo json_encode(["success" => false, "message" => "Cannot delete contact or contact not found"]);
        }

        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(["success" => false, "message" => "contact ID not provided"]);
    }


}

?>
