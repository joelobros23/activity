<?php
// Start the session
session_start();

// Check if the user is already logged in, then redirect to the home page
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Include the config.php file
require_once 'api/config.php';

// Define variables and initialize with empty values
$email = $password = '';
$email_err = $password_err = '';

// Process form data when the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate email and password
    if (empty($email)) {
        $email_err = 'Please enter your email.';
    }
    if (empty($password)) {
        $password_err = 'Please enter your password.';
    }

    // Check if there are no errors, then attempt to login
    if (empty($email_err) && empty($password_err)) {
        $sql = "SELECT id, email, password FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $user_id = $row['id'];
            $hashed_password = $row['password'];

            // Verify the password
            if (password_verify($password, $hashed_password)) {
                // Password is correct, start a new session
                session_start();

                // Store data in session variables
                $_SESSION['user_id'] = $user_id;

                // Redirect to the home page
                header("Location: index.php");
                exit();
            } else {
                // Password is incorrect
                $password_err = 'Invalid password.';
            }
        } else {
            // No user found with the provided email
            $email_err = 'No account found with that email.';
        }

        $stmt->close();
    }

    // Close the database connection
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="card col-sm-6 mx-auto">
            <div class="card-header">
                Login
            </div>
            <div class="card-body">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" id="email" name="email" value="<?php echo $email; ?>">
                        <div class="invalid-feedback"><?php echo $email_err; ?></div>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" id="password" name="password">
                        <div class="invalid-feedback"><?php echo $password_err; ?></div>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>