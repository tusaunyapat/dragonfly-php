<?php
require '../db.php'; // Include your database connection file
header('Content-Type: application/json');
if (isset($_GET['id'])) {
    $contactId = $_GET['id']; // Get and sanitize the contact ID

    $stmt = $conn->prepare("SELECT * FROM contact WHERE id = ?");
    $stmt->bind_param("s", $contactId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($contact = $result->fetch_assoc()) {
        echo json_encode(["success" => true, "contact" => $contact]);
    } else {
        echo json_encode(["success" => false, "message" => "contact not found"]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "contact ID not provided"]);
}
exit;
?>
