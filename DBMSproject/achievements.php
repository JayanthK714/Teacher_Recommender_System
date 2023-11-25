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

// Check if the form for achievements is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["achievement"])) {
    $srn = $_SESSION["username"]; // Retrieve the SRN from the session
    $cgpa = $_POST["cgpa"];
    $achievement = $_POST["achievement"];
    $achievementDate = $_POST["achievement_date"];
    $certification = $_POST["certification"];

    // Prepare the call to the procedure using prepared statements
    $insertAchievementsProcedure = $conn->prepare("CALL InsertAchievements(?, ?, ?, ?, ?)");
    $insertAchievementsProcedure->bind_param("sssss", $srn, $cgpa, $achievement, $achievementDate, $certification);

    // Execute the procedure
    if ($insertAchievementsProcedure->execute()) {
        $result = $insertAchievementsProcedure->get_result();
        while ($row = $result->fetch_assoc()) {
            echo $row['Message']; // Display the procedure result message
        }
    } else {
        echo "Error executing the procedure: " . $conn->error;
    }

    $insertAchievementsProcedure->close();
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Achievements</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="logo.jpeg">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="">
      <img src="logo.jpeg" width="40">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0"
          id="navLinks">
        <li class="nav-item">
          <a class="nav-link" 
             aria-current="page" 
             href="studenthome.php">Dashboard</a>
      </ul>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Student Achievements</h5>
                    </div>
                    <div class="card-body">
                    <form action="achievements.php" method="post">
                    <div class="mb-3 row">
                        <label for="cgpa" class="col-sm-3 col-form-label">CGPA</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="cgpa" name="cgpa" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="achievement">Achievement</label>
                        <input type="text" name="achievement" class="form-control" id="achievement" required>
                    </div>
                    <div class="form-group">
                        <label for="achievement_date">Achievement Date</label>
                        <input type="text" name="achievement_date" class="form-control" id="achievement_date" required>
                    </div>
                    <div class="form-group">
                        <label for="certification">Certification</label>
                        <input type="text" name="certification" class="form-control" id="certification" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Achievement</button>
                </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <div class="container-fluid">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($profileCreated) ? 'disabled' : ''; ?>" href="profile_view.php">View Profile Created</a>
                </li>
            </ul>
        </div>
</body>
</html>
