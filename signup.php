<?php
include("include/config.php");  // Make sure the database connection and other configurations are correct
error_reporting(E_ALL);  // Enable error reporting for debugging

if (isset($_POST['signup'])) {
    // Collect form data
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $useremail = $_POST['useremail'];
    $usermobile = $_POST['usermobile'];
    $loginpassword = $_POST['loginpassword'];

    // Hash the password before storing it
    $hashed_password = password_hash($loginpassword, PASSWORD_DEFAULT);

    // Check if username or email already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR useremail = ?");
    $stmt->bind_param("ss", $username, $useremail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Username or email already exists!";
    } else {
        // Insert into the database (Prepared Statement)
        $stmt = $conn->prepare("INSERT INTO users (fullname, username, useremail, usermobile, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $fullname, $username, $useremail, $usermobile, $hashed_password);

        if ($stmt->execute()) {
            echo "User registered successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Signup Page</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Signup</h2>
  <form action="signup.php" method="POST">
    <div class="form-group">
      <label for="fullname">Full Name:</label>
      <input type="text" class="form-control" id="fullname" placeholder="Enter full name" name="fullname" required>
    </div>
    <div class="form-group">
      <label for="username">Username:</label>
      <input type="text" class="form-control" id="username" placeholder="Enter username" name="username" required>
    </div>
    <div class="form-group">
      <label for="useremail">Email:</label>
      <input type="email" class="form-control" id="useremail" placeholder="Enter email" name="useremail" required>
    </div>
    <div class="form-group">
      <label for="usermobile">Mobile:</label>
      <input type="text" maxlength="10" pattern="^[0-9]{10}$" class="form-control" id="usermobile" placeholder="Enter mobile" name="usermobile" required>
      <small>Enter a valid 10-digit mobile number</small>
    </div>
    <div class="form-group">
      <label for="loginpassword">Password:</label>
      <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="loginpassword" required>
    </div>
    <div class="form-group form-check">
      <label class="form-check-label">
        <input class="form-check-input" type="checkbox" name="remember"> Remember me
      </label>
    </div>
    <button type="submit" name="signup" class="btn btn-primary">Submit</button>
  </form>
</div>

</body>
</html>
