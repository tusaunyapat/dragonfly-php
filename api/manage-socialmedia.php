<?php
require '../db.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        
        if ($action === 'create' || $action === 'update') {
            $id = $_POST['id'] ?? null;
            $platform = $_POST['platform'];
            $url = $_POST['url'];

            if ($action === 'create') {
                // Insert new product
                $stmt = $conn->prepare("INSERT INTO social_media (platform, url) VALUES (?, ?)");
                $stmt->execute([$platform, $url]);
            } else {
                // Update existing product
                
                $stmt = $conn->prepare("UPDATE social_media SET platform = ?, url = ? WHERE id=?");
                $stmt->execute([$platform, $url, $id]);
            }

            echo json_encode(['status' => 'success', 'message' => 'social_media saved successfully']);
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
        $social_mediaId = $data['id']; // Get and sanitize the social_media ID

        // Prepare the DELETE query
        $stmt = $conn->prepare("DELETE FROM social_media WHERE id = ?");
        $stmt->bind_param("s", $social_mediaId); // Bind contactId as a string (UUID)
        $stmt->execute();

        // Check if the contact was deleted
        if ($stmt->affected_rows > 0) {
            echo json_encode(["success" => true, "message" => "social media deleted successfully"]);
        } else {
            echo json_encode(["success" => false, "message" => "Cannot delete social media or social media not found"]);
        }

        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(["success" => false, "message" => "social media ID not provided"]);
    }


}

?>
