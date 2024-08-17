<?php
// configuration
$dbhost = "localhost";
$dbname = "educational_platform";
$dbuser = "root";
$dbpass = "";

// create connection
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

// check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // query to retrieve user data
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // user found, redirect to lesson page
        header("Location: lesson.php");
        exit;
    } else {
        // user not found, display error message
        $error = "Invalid username or password";
    }
}

// close connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login Page</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="login-container">
    <h2>Login to Educational Platform</h2>
    <form method="post">
      <label for="username">Username:</label>
      <input type="text" id="username" name="username"><br><br>
      <label for="password">Password:</label>
      <input type="password" id="password" name="password"><br><br>
      <button type="submit">Login</button>
      <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
    </form>
  </div>
</body>
</html>