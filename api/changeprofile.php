<?php

require_once 'config.php';


session_start();


$name = $lastname = $email = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];

    $user_id = $_SESSION['user_id'];


    $sql = "UPDATE users SET firstname = ?, lastname = ?, email = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $lastname, $email, $user_id);

    if ($stmt->execute()) {

        echo "Profile information updated.";
    } else {

        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}
?>
