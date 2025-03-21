<?php
header('Content-Type: application/json');
require '../db.php';

$sql = "SELECT * FROM social_media";

$result = mysqli_query($conn, $sql);
$socialmedia = mysqli_fetch_all($result, MYSQLI_ASSOC);

//return socialmedia as a JSON response
echo json_encode(['socialmedia' => $socialmedia]);
exit;

?>