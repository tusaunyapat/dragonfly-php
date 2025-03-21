<?php
header('Content-Type: application/json');
require '../db.php';

$sql = "SELECT * FROM contact";

$result = mysqli_query($conn, $sql);
$contacts = mysqli_fetch_all($result, MYSQLI_ASSOC);

//return categories as a JSON response
echo json_encode(['contacts' => $contacts]);
exit;

?>

