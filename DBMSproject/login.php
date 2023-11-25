<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "teacherdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputUsername = $_POST["username"];
    $inputPassword = $_POST["password"];

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE Username=? AND Password=?");
    $stmt->bind_param("ss", $inputUsername, $inputPassword);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION["username"] = $inputUsername;
        echo "Login successful!";

        // Check user type and redirect accordingly
        if ($inputUsername == "admin") {
            header("Location: admin_dashboard.php");
            exit();
        } elseif ($inputUsername == "teacher") {
            header("Location: teacher_dashboard.php");
            exit();
        } else {
            header("Location: studenthome.php");
            exit();
        }
    } else {
        echo "Invalid username or password";
    }

    $stmt->close();
}

$conn->close();
?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="logo.jpeg">
</head>
<body class="body-login">
    <div class="black-fill"><br /> <br />
        <div class="d-flex justify-content-center align-items-center flex-column">
        <form class="login" action="login.php" method="post">
            <div class="text-center">
                <img src="logo.jpeg" width="100">
            </div>
            <h3>LOGIN</h3>
          <div class="mb-3">
            <label class="form-label">Username</label>
            <!-- Add the name attribute to the input -->
            <input type="text" class="form-control" placeholder="SRN ONLY" name="username">
          </div>
          
          <div class="mb-3">
            <label class="form-label">Password</label>
            <!-- Add the name attribute to the input -->
            <input type="password" class="form-control" name="password">
          </div>
          <button type="submit" class="btn btn-primary">Login</button>
          <a href="index.php" class="text-decoration-none">Home</a>
        </form>
        
        <br />

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>  
</body>
</html>
