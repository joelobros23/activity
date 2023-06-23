<?php
        // Include the config.php file
        require_once '../api/config.php';

        // Define variables and initialize with empty values
        $firstname = $lastname = $email = $password = $birthdate = '';
        
        // Process form data when the form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $birthdate = $_POST['birthdate'];

            // TODO: Validate and sanitize the input data
            // ...

            // Insert user data into the database
            $sql = "INSERT INTO users (firstname, lastname, email, birthdate, password) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $firstname, $lastname, $email, $birthdate, $password);

            if ($stmt->execute()) {
                // Registration successful, redirect to a success page
                header("Location: success.php");
                exit();
            } else {
                // Registration failed, display an error message
                echo "Error: " . $stmt->error;
            }

            // Close statement
            $stmt->close();
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5 d-flex justify-content-center">
    <div class="card col-sm-7">
      <div class="card-header">
        Register
      </div>
      <div class="card-body">
        <form action="register_process.php" method="POST col-sm-9 d-flex justify-content-center">
        <div class="form-group row">
            <div class="col-sm-6">
              <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name" required>
            </div>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last Name" required>
            </div>
          </div>
          <div class="form-group col-sm-12">
            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
          </div>
          <div class="form-group col-sm-12">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
          </div>
          <div class="form-group col-sm-12 mb-5">
            <label for="birthdate">Birthdate</label>
            <input type="date" class="form-control" id="birthdate" name="birthdate" required>
          </div>
          <button type="submit" class="btn btn-primary d-flex justify-content-center">Register</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>