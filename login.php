<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "educational_platform");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users2 WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            session_regenerate_id(true); // Secure session handling
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["role"] = $row["role"];
            header("Location: index.html");
            exit;
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "User not found.";
    }
    $stmt->close();
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Code Champs Academy - Login</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <link href="1719803730283.png" rel="icon">
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-4">Login</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="login.php">
                            <div class="form-group">
                                <label class="small mb-1" for="inputEmail">Username</label>
                                <input class="form-control py-2" id="inputEmail" name="username" type="text" placeholder="Enter username" required />
                            </div>
                            <div class="form-group">
                                <label class="small mb-1" for="inputPassword">Password</label>
                                <input class="form-control py-2" id="inputPassword" name="password" type="password" placeholder="Enter password" required />
                            </div>
                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                <a class="small" href="password.html">Forgot Password?</a>
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                            <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <div class="small"><a href="register.html">Don't have an account? Register!</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
