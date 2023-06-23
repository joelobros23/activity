<?php

require_once 'config.php';


session_start();


if (isset($_SESSION['user_id'])) {
    header("Location: ../frontend/index.php");
    exit();
}


$email = $password = '';
$email_err = $password_err = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'];
    $password = $_POST['password'];


    if (empty($email)) {
        $email_err = 'Please enter your email.';
    }
    if (empty($password)) {
        $password_err = 'Please enter your password.';
    }

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

    
            if (password_verify($password, $hashed_password)) {

                session_start();


                $_SESSION['user_id'] = $user_id;


                header("Location: ../frontend/index.php");
                exit();
            } else {

                $password_err = 'Invalid password.';
            }

        } else {
            // No user found with the provided email
            $email_err = 'No account found with that email.';
        }

        $stmt->close();
    } else {
        // Output database errors
        die('Error: ' . $conn->error);
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
    <title>Login</title>
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
