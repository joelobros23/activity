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

// Fetch all posts from the database
$sql = "SELECT tweets.id AS post_id, tweets.content, tweets.created_at, users.firstname, users.lastname 
        FROM tweets 
        INNER JOIN users ON tweets.user_id = users.id 
        ORDER BY tweets.created_at DESC";
$result = $conn->query($sql);

// Check if there are posts
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $post_id = $row['post_id'];
    $firstname = $row['firstname'];
    $lastname = $row['lastname'];
    $content = $row['content'];
    $timestamp = $row['created_at'];

    // Display the post details
    echo '<div class="card mb-3">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">Post ID: ' . $post_id . '</h5>';
    echo '<h6 class="card-subtitle mb-2 text-muted">User: ' . $firstname . ' ' . $lastname . '</h6>';
    echo '<p class="card-text">' . $content . '</p>';
    echo '<p class="card-text"><small class="text-muted">Posted on: ' . $timestamp . '</small></p>';
    echo '</div>';
    echo '</div>';
  }
} else {
  // Handle the case when there are no posts
  echo 'No posts found.';
}

// Close the database connection
$conn->close();
?>
