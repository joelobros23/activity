<!-- settings.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Settings</h2>

        <!-- Change Email Form -->
        <div class="card mt-4">
            <div class="card-header">
                Change Email
            </div>
            <div class="card-body">
                <form action="update_email.php" method="POST">
                    <div class="form-group">
                        <label for="new_email">New Email</label>
                        <input type="email" class="form-control" id="new_email" name="new_email" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Email</button>
                </form>
            </div>
        </div>

        <!-- Change Profile Information Form -->
        <div class="card mt-4">
            <div class="card-header">
                Change Profile Information
            </div>
            <div class="card-body">
                <form action="update_profile.php" method="POST">
                    <div class="form-group">
                        <label for="new_firstname">First Name</label>
                        <input type="text" class="form-control" id="new_firstname" name="new_firstname" required>
                    </div>
                    <div class="form-group">
                        <label for="new_lastname">Last Name</label>
                        <input type="text" class="form-control" id="new_lastname" name="new_lastname" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
