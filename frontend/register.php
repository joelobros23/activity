<?php
// Include the config.php file
require_once '../api/config.php';

// Define variables and initialize with empty values
$firstname = $lastname = $email = $password = $birthdate = '';
$firstname_err = $lastname_err = $email_err = $password_err = $birthdate_err = '';

// Process form data when the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize the input data
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $birthdate = $_POST['birthdate'];

    // Validate firstname
    if (empty($firstname)) {
        $firstname_err = 'Please enter your firstname.';
    }

    // Validate lastname
    if (empty($lastname)) {
        $lastname_err = 'Please enter your lastname.';
    }

    // Validate email
    if (empty($email)) {
        $email_err = 'Please enter your email.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_err = 'Please enter a valid email address.';
    }

    // Validate password
    if (empty($password)) {
        $password_err = 'Please enter a password.';
    } elseif (strlen($password) < 6) {
        $password_err = 'Password must be at least 6 characters long.';
    }

    // Validate birthdate
    if (empty($birthdate)) {
        $birthdate_err = 'Please enter your birthdate.';
    }

    // Check if there are no errors, then attempt to register
    if (empty($firstname_err) && empty($lastname_err) && empty($email_err) && empty($password_err) && empty($birthdate_err)) {
        // Check if the email is already registered
        $sql = "SELECT id FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $email_err = 'Email is already registered.';
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert user data into the database
            $sql = "INSERT INTO users (firstname, lastname, email, birthdate, password) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $firstname, $lastname, $email, $birthdate, $hashed_password);

            if ($stmt->execute()) {
                // Registration successful, redirect to index.php
                header("Location: index.php");
                exit();
            } else {
                // Registration failed, display an error message
                echo "Error: " . $stmt->error;
            }
        }
    }

    // Close statement
    $stmt->close();

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="card col-sm-7 mx-auto">
            <div class="card-header">
                Register
            </div>
            <div class="card-body">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <input type="text" class="form-control <?php echo (!empty($firstname_err)) ? 'is-invalid' : ''; ?>" id="firstname" name="firstname" placeholder="First Name" required value="<?php echo $firstname; ?>">
                            <div class="invalid-feedback"><?php echo $firstname_err; ?></div>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control <?php echo (!empty($lastname_err)) ? 'is-invalid' : ''; ?>" id="lastname" name="lastname" placeholder="Last Name" required value="<?php echo $lastname; ?>">
                            <div class="invalid-feedback"><?php echo $lastname_err; ?></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" id="email" name="email" placeholder="Email" required value="<?php echo $email; ?>">
                        <div class="invalid-feedback"><?php echo $email_err; ?></div>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" id="password" name="password" placeholder="Password" required>
                        <div class="invalid-feedback"><?php echo $password_err; ?></div>
                    </div>
                    <div class="form-group">
                        <label for="birthdate">Birthdate</label>
                        <input type="date" class="form-control <?php echo (!empty($birthdate_err)) ? 'is-invalid' : ''; ?>" id="birthdate" name="birthdate" required value="<?php echo $birthdate; ?>">
                        <div class="invalid-feedback"><?php echo $birthdate_err; ?></div>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
