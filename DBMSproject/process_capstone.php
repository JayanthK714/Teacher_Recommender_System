<?php
session_start(); // Ensure the session is started

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "teacherdb";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve SRN from session
    $srn = $_SESSION['username'];

    // Fetch team_id from the team table using SRN
    $teamId = null;
    $fetchTeamIdQuery = "SELECT team_id FROM team WHERE 
        student_srn_1 = '$srn' OR 
        student_srn_2 = '$srn' OR 
        student_srn_3 = '$srn' OR 
        student_srn_4 = '$srn'";

    $teamIdResult = $conn->query($fetchTeamIdQuery);

    if ($teamIdResult->num_rows > 0) {
        $row = $teamIdResult->fetch_assoc();
        $teamId = $row['team_id'];
    }

    $teamIdResult->close();

    $checkProjectQuery = "SELECT * FROM capstone WHERE team_id = ?";
    $checkProjectStmt = $conn->prepare($checkProjectQuery);
    $checkProjectStmt->bind_param("i", $teamId);
    $checkProjectStmt->execute();
    $checkProjectStmt->store_result();

    if ($checkProjectStmt->num_rows > 0) {
        // Display message indicating project details already exist for this team
        echo "Project details have already been created for this team.Click <a href='studenthome.php'>here</a> to got to homepage";
        exit(); // Or redirect as per your application flow
    }

$checkProjectStmt->close();

    // Insert capstone details into the capstone table
    $projectTitle = $_POST['project_title'];
    $projectDescription = $_POST['project_description'];
    $projectRequirements = $_POST['project_requirements'];

    // Insert capstone data
    $insertCapstone = $conn->prepare("INSERT INTO capstone (team_id, project_title, project_description, project_requirements) VALUES (?, ?, ?, ?)");
    $insertCapstone->bind_param("isss", $teamId, $projectTitle, $projectDescription, $projectRequirements);
    $insertCapstoneResult = $insertCapstone->execute();
    $insertCapstone->close();

    // Insert domain details into the domain table
    $domainInterest = $_POST['domain_of_interest'];

    // Insert domain data
    $insertDomain = $conn->prepare("INSERT INTO domain (team_id, domain_name) VALUES (?, ?)");
    $insertDomain->bind_param("is", $teamId, $domainInterest);
    $insertDomainResult = $insertDomain->execute();
    $insertDomain->close();
    $conn->close();
    // Close connection
    if ($insertCapstoneResult && $insertDomainResult) {
        header("Location: studenthome.php"); // Redirect to the homepage on success
        exit();
    } else {
        header("Location: capstone.php"); // Redirect to the capstone page on failure
        exit();
    }
}
?>
