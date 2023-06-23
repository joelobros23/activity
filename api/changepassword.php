<?php

require_once 'config.php';

$currentPassword = $newPassword = $confirmPassword = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    $user_id = $_SESSION['user_id'];


    $sql = "SELECT password FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($hashedPassword);
    $stmt->fetch();
    $stmt->close();


    if (password_verify($currentPassword, $hashedPassword)) {

        $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);


        $sql = "UPDATE users SET password = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $newHashedPassword, $user_id);

        if ($stmt->execute()) {

            echo "Password updated successfully.";
        } else {

            echo "Error: " . $stmt->error;
        }


        $stmt->close();
    } else {
  
        echo "Incorrect current password.";
    }
}
?>
