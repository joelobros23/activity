<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../api/login.php");
    exit();
}

require_once '../api/config.php';


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
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Activity</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Settings</a>
                </li>
            </ul>
        </div>
    </nav>
<div class="container mt-5">
    <div class="container mt-5">
        <div class="card mb-4">
        <div class="card-header">
        User Informations
      </div>
      <div class="card-body">
        <p><strong>Name:</strong> <?php echo $userDetails['firstname'] . ' ' . $userDetails['lastname']; ?></p>
        <p><strong>Email:</strong> <?php echo $userDetails['email']; ?></p>
        <p><strong>Birthdate:</strong> <?php echo $userDetails['birthdate']; ?></p>
      </div>
    </div>

    <div class="card-body">

    <div class="card mb-3">
  <div class="card-body">
    <h5 class="card-title">Post ID: <?php echo $post_id; ?></h5>
    <h6 class="card-subtitle mb-2 text-muted">User: <?php echo $firstname . ' ' . $lastname; ?></h6>
    <p class="card-text"><?php echo $content; ?></p>
    <p class="card-text"><small class="text-muted">Posted on: <?php echo $timestamp; ?></small></p>
    <form action="delete_post.php" method="POST" class="delete-form">
      <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
      <button type="submit" class="btn btn-danger btn-sm delete-btn">Delete</button>
    </form>
  </div>
</div>


  <?php
  // Retrieve posts from the database
  $sql = "SELECT tweets.id AS post_id, tweets.content, tweets.created_at, users.firstname, users.lastname 
          FROM tweets 
          INNER JOIN users ON tweets.user_id = users.id 
          ORDER BY tweets.created_at DESC";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $post_id = $row['post_id'];
      $firstname = $row['firstname'];
      $lastname = $row['lastname'];
      $content = $row['content'];
      $timestamp = $row['created_at'];
  ?>

      <div class="card mb-3">
        <div class="card-body">
          <h3 class="card-subtitle mb-2"><?php echo $firstname . ' ' . $lastname; ?></h3>
          <h6 class="card-title  text-muted">Post ID: <?php echo $post_id; ?></h6>
          <p class="card-text"><?php echo $content; ?></p>
          <p class="card-text"><small class="text-muted">Posted on: <?php echo $timestamp; ?></small></p>
        </div>
      </div>
  <?php
    }
  } else {
    echo "No posts found.";
  }
  ?>
</div>


  </div>
</div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>