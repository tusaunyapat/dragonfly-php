<?php
header('Content-Type: application/json');
require '../db.php';

$sql = "SELECT * FROM categories";

$result = mysqli_query($conn, $sql);
$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

//return categories as a JSON response
echo json_encode(['categories' => $categories]);
exit;

?>

