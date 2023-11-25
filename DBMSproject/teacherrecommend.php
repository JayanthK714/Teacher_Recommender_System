<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <style>
        /* Add your custom styles here */
        .teacher-img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 50%;
        }
        .details-container {
            margin-top: 20px;
        }
    </style>
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
            <ul class="navbar-nav me-auto mb-2 mb-lg-0" id="navLinks">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="studenthome.php">Dashboard</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>





<?php
// Start the session (make sure this is at the top of your PHP file)
session_start();

// Replace with your database credentials
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

// Assuming the user is logged in and their username (SRN) is stored in the session
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Retrieve the team_id based on the username
    $teamIdQuery = "SELECT team_id FROM student WHERE srn = '$username'";
    $teamIdResult = $conn->query($teamIdQuery);

    if ($teamIdResult->num_rows > 0) {
        $teamIdRow = $teamIdResult->fetch_assoc();
        $teamId = $teamIdRow['team_id'];

        // Retrieve the domain_name based on the team_id
        $domainQuery = "SELECT domain_name FROM domain WHERE team_id = '$teamId'";
        $domainResult = $conn->query($domainQuery);

        if ($domainResult->num_rows > 0) {
            $domainRow = $domainResult->fetch_assoc();
            $selectedDomain = $domainRow['domain_name'];

            // Retrieve teachers whose research interests match the selected domain
            $teacherQuery = "SELECT * FROM teacher";
            $teacherResult = $conn->query($teacherQuery);
            
            if ($teacherResult->num_rows > 0) {
                // Display the list of teachers matching the student's domain
                echo "<h2>Teachers Matching Student's Domain ($selectedDomain)</h2>";
                echo "<ul>";
                while ($row = $teacherResult->fetch_assoc()) {
                    $researchInterests = explode("\n", $row["researchinterest"]);
            
                    // Check if the selected domain matches any of the teacher's research interests
                    $matchFound = false;
                    foreach ($researchInterests as $interest) {
                        if (trim($interest) === $selectedDomain) {
                            $matchFound = true;
                            break;
                        }
                    }
            
                    if ($matchFound) {
                        echo "<li>";
                        echo "<strong>Teacher Name:</strong> " . $row["name"] . "<br>";
                        echo "<strong>Research Interests:</strong><br>";
                        echo "<ul>";
                        foreach ($researchInterests as $interest) {
                            echo "<li>$interest</li>";
                        }
                        echo "</ul>";
                        echo "<a href='teacher_details.php?id=" . $row['id'] . "' class='btn btn-primary'>View Details</a>";
                        echo "</li>";
                    }
                }
                echo "</ul>";
            } else {
                echo "No teachers found for the student's domain.";
            }
        } else {
            echo "No domain found for the team.";
        }
    } else {
        echo "Team not found with the provided username (SRN).";
    }
}

$conn->close();
?>



