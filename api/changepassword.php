<?php
// Include the config.php file
require_once 'config.php';

// Initialize variables with user data
$currentPassword = $newPassword = $confirmPassword = '';

// Process form data when the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // TODO: Validate and sanitize the input data
    // ...

    // Retrieve user ID from the session
    $user_id = $_SESSION['user_id'];

    // Retrieve user's current password from the database
    $sql = "SELECT password FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($hashedPassword);
    $stmt->fetch();
    $stmt->close();

    // Verify if the current password matches the one in the database
    if (password_verify($currentPassword, $hashedPassword)) {
        // Generate a new hashed password
        $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update the user's password in the database
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $newHashedPassword, $user_id);

        if ($stmt->execute()) {
            // Password updated successfully
            echo "Password updated successfully.";
        } else {
            // Error occurred while updating the password
            echo "Error: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    } else {
        // Current password is incorrect
        echo "Incorrect current password.";
    }
}
?>
