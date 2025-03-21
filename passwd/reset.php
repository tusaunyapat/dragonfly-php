<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the input values from the form
    $reset_request = trim($_POST['reset_request']);
    $new_password = trim($_POST['new_password']);
    
    // Validate the reset request
    if ($reset_request === 'i want to reset the password' && !empty($new_password)) {
        // Hash the new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        // Define the file path to store the hashed password
        $file_path = 'passwd/hashed_password.txt';
        
        // Overwrite the file with the hashed password
        if (file_put_contents($file_path, $hashed_password)) {
            echo "Password has been reset successfully.";
        } else {
            echo "Failed to overwrite the password file.";
        }
    } else {
        echo "Invalid reset request or empty password.";
    }
} else {
    // Display the form to the user
    echo '<form method="POST" action="">
            <label for="reset_request">Enter reset phrase:</label>
            <input type="text" id="reset_request" name="reset_request" required />
            <br><br>
            <label for="new_password">Enter new password:</label>
            <input type="password" id="new_password" name="new_password" required />
            <br><br>
            <button type="submit">Reset Password</button>
          </form>';
}
?>
