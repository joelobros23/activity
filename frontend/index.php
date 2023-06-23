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
    <div class="card">
      <div class="card-header">
        Register
      </div>
      <div class="card-body">
        <form action="register_process.php" method="POST">
        <div class="form-group row">
            <div class="col-sm-4">
              <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name" required>
            </div>
            <div class="col-sm-4">
              <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last Name" required>
            </div>
          </div>
          <div class="form-group">

            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
          </div>
          <div class="form-group">

            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
          </div>
          <div class="form-group">
            <label for="birthdate">Birthdate</label>
            <input type="date" class="form-control" id="birthdate" name="birthdate" required>
          </div>
          <button type="submit" class="btn btn-primary">Register</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>