<?php

require_once 'config.php';


session_start();


$name = $lastname = $email = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];

    $user_id = $_SESSION['user_id'];

    // Update user data in the database
    $sql = "UPDATE users SET firstname = ?, lastname = ?, email = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $lastname, $email, $user_id);

    if ($stmt->execute()) {
        // Profile information updated successfully
        echo "Profile information updated.";
    } else {
        // Error occurred while updating profile information
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}
?>
