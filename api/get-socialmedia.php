<?php
require '../db.php'; // Include your database connection file
header('Content-Type: application/json');
if (isset($_GET['id'])) {
    $socialmediaId = $_GET['id']; // Get and sanitize the product ID

    $stmt = $conn->prepare("SELECT * FROM social_media WHERE id = ?");
    $stmt->bind_param("s", $socialmediaId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($socialmedia = $result->fetch_assoc()) {
        echo json_encode(["success" => true, "socialmedia" => $socialmedia]);
    } else {
        echo json_encode(["success" => false, "message" => "socialmedia not found"]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "socialmedia ID not provided"]);
}
exit;
?>
