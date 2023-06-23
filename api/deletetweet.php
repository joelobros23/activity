<?php

require_once '../api/config.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id'])) {

    $post_id = $_POST['post_id'];

    $sql = "DELETE FROM tweets WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $post_id);

    if ($stmt->execute()) {

        header("Location: ../frontend/index.php");
        exit();
    } else {
        // Error occurred while deleting the post
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
} else {
    // Redirect back to the index page if post ID is not provided
    header("Location: ../frontend/index.php");
    exit();
}
?>
