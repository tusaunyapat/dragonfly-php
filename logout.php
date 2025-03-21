<?php
// Start the session
session_start();

// Destroy the session to log the user out
session_destroy();

// Redirect to the login page (index.php in your case)
header("Location: index.php");
exit(); // Make sure no further code is executed
?>
