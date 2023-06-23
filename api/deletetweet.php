<?php

require_once '../api/config.php';

// Check if the post ID is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id'])) {
    // Get the post ID from the form
    $post_id = $_POST['post_id'];

    // Prepare and execute the DELETE statement
    $sql = "DELETE FROM tweets WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $post_id);

    if ($stmt->execute()) {
        // Post deleted successfully, redirect back to the index page
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
