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
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Check if the username already exists
    $checkUsernameQuery = "SELECT * FROM users WHERE Username = '$username'";
    $result = $conn->query($checkUsernameQuery);

    if ($result->num_rows > 0) {
        // Display pop-up message using JavaScript
        echo '<script>alert("Error: Username already exists. Please choose a different username.");</script>';
    } else {
        // Insert new user into the database
        $sql = "INSERT INTO users (Username, Email, Password) VALUES ('$username', '$email', '$password')";

        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Registration successful! Redirecting to login page.");';
            echo 'window.location.href = "login.php";</script>';
            exit();
            $_SESSION["username"]=$username;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Add your meta tags, title, and other head elements here -->
    <script>
        // JavaScript to redirect to the index page after displaying the pop-up
        setTimeout(function() {
            window.location.href = "index.php";
        }, 3000); // Redirect after 3 seconds (adjust the time as needed)
    </script>
</head>
<body>
    <!-- Add your body content here -->
</body>
</html>
