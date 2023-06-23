<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../api/login.php");
    exit();
}

// Include the config.php file
require_once '../api/config.php';

// Retrieve user information from the database based on the user ID in the session
$userID = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();
$userDetails = $result->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <div class="container mt-5">
        <div class="card mb-4">
        <div class="card-header">
        User Information
      </div>
      <div class="card-body">
        <p><strong>Name:</strong> <?php echo $userDetails['firstname'] . ' ' . $userDetails['lastname']; ?></p>
        <p><strong>Email:</strong> <?php echo $userDetails['email']; ?></p>
        <p><strong>Birthdate:</strong> <?php echo $userDetails['birthdate']; ?></p>
      </div>
    </div>

    <div class="card">
      <div class="card-header">
        Social Media Posts
      </div>
      <div class="card-body">
        <?php
        // Retrieve social media posts from the database
        // Replace this with your own code to fetch posts from the database
        $socialMediaPosts = array(
          array(
            'post_id' => 1,
            'user_id' => 1,
            'content' => 'Hello, everyone! This is my first post.',
            'timestamp' => '2023-06-23 10:00:00'
          ),
          array(
            'post_id' => 2,
            'user_id' => 1,
            'content' => 'Feeling great today!',
            'timestamp' => '2023-06-24 15:30:00'
          )
        );
        ?>

        <?php foreach ($socialMediaPosts as $post): ?>
          <div class="card mb-3">
            <div class="card-body">
              <h5 class="card-title">Post ID: <?php echo $post['post_id']; ?></h5>
              <h6 class="card-subtitle mb-2 text-muted">User ID: <?php echo $post['user_id']; ?></h6>
              <p class="card-text"><?php echo $post['content']; ?></p>
              <p class="card-text"><small class="text-muted">Posted on: <?php echo $post['timestamp']; ?></small></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</body>
</html>

?>