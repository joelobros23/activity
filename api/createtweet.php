<?php
// Include the config.php file
require_once 'config.php';

// Start the session
session_start();

// Check if the user is logged in, otherwise redirect to the login page
if (!isset($_SESSION['user_id'])) {
  header("Location: ../frontend/login.php");
  exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve the user ID from the session
  $user_id = $_SESSION['user_id'];

  // Get the post content from the form
  $content = $_POST['content'];

  // Validate the post content
  if (empty($content)) {
    // Handle the case when the post content is empty
    // You can display an error message or perform any other necessary action
    echo "Post content cannot be empty.";
  } else {
    // Prepare and execute the SQL statement to insert the post into the database
    $sql = "INSERT INTO tweets (user_id, content) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $user_id, $content);
    
    if ($stmt->execute()) {
      // Post creation successful, redirect back to the index page
      header("Location: ../frontend/index.php");
      exit();
    } else {
      // Handle the case when the post creation fails
      // You can display an error message or perform any other necessary action
      echo "Error creating the post: " . $stmt->error;
    }

    $stmt->close();
  }
}

// Close the database connection
$conn->close();
?>
