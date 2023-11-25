<?php
$error = "";
if (isset($_SESSION['team_created'])) {
    // Redirect users to another page (e.g., dashboard) or display an appropriate message
    header("Location: homepage.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all fields are filled
    $requiredFields = [
        "team_name",
        "student_name_1",
        "student_srn_1",
        "student_dept_1",
        "student_cgpa_1",
        "student_name_2",
        "student_srn_2",
        "student_dept_2",
        "student_cgpa_2",
        "student_name_3",
        "student_srn_3",
        "student_dept_3",
        "student_cgpa_3",
        "student_name_4",
        "student_srn_4",
        "student_dept_4",
        "student_cgpa_4"
    ];

    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            $error = "Please fill in all fields";
            break;
        }
    }

    if (empty($error)) {
        // Proceed if no error
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
        #CALLED PROCEDURE
        $validateCGPA = $conn->prepare("CALL ValidateTeamCGPA(?, ?, ?, ?)");
        $validateCGPA->bind_param("dddd", $_POST["student_cgpa_1"], $_POST["student_cgpa_2"], $_POST["student_cgpa_3"], $_POST["student_cgpa_4"]);
        $validateCGPA->execute();
        $validateCGPA->close();


        $studentSRNs = [
            $_POST["student_srn_1"],
            $_POST["student_srn_2"],
            $_POST["student_srn_3"],
            $_POST["student_srn_4"]
        ];

        // Prepare SQL statement for SRN validation
        $checkStmt = $conn->prepare("SELECT COUNT(*) AS total FROM student WHERE srn = ?");
        $checkStmt->bind_param("s", $studentSRN);

        $valid = true;

        // Loop through student SRNs
        foreach ($studentSRNs as $studentSRN) {
            $checkStmt->execute();
            $result = $checkStmt->get_result();
            $row = $result->fetch_assoc();

            if ($row['total'] == 0) {
                $valid = false;
                $error = "SRN $studentSRN does not exist in the students' records.";
                break;
            }
        }

        $checkStmt->close();

        if ($valid) {
            // Prepare SQL statement for team insertion
            $stmt = $conn->prepare("INSERT INTO team (team_name,student_name_1, student_srn_1, student_dept_1, student_cgpa_1, student_name_2, student_srn_2, student_dept_2, student_cgpa_2, student_name_3, student_srn_3, student_dept_3, student_cgpa_3, student_name_4, student_srn_4, student_dept_4, student_cgpa_4) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            // Bind parameters
            $stmt->bind_param(
                "sssssssssssssssss",
                $_POST["team_name"],
                $_POST["student_name_1"],
                $_POST["student_srn_1"],
                $_POST["student_dept_1"],
                $_POST["student_cgpa_1"],
                $_POST["student_name_2"],
                $_POST["student_srn_2"],
                $_POST["student_dept_2"],
                $_POST["student_cgpa_2"],
                $_POST["student_name_3"],
                $_POST["student_srn_3"],
                $_POST["student_dept_3"],
                $_POST["student_cgpa_3"],
                $_POST["student_name_4"],
                $_POST["student_srn_4"],
                $_POST["student_dept_4"],
                $_POST["student_cgpa_4"]
            );

            // Execute SQL statement
            $stmt->execute();
            $_SESSION['team_created'] = true;
            // Close statement
            $stmt->close();
        }
    }

        // Close connection
        $conn->close();
}
?>













<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Creation</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
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
      <ul class="navbar-nav me-auto mb-2 mb-lg-0"
          id="navLinks">
        <li class="nav-item">
          <a class="nav-link" 
             aria-current="page" 
             href="studenthome.php">Dashboard</a>
      </ul>
    </nav>
    <div class="container">
    <div class="row justify-content-center">
            <div class="col-md-8">
        <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Student Profile Creation</h5>
                    </div>
                    <div class="card-body">
        <form id="teamCreationForm" action="team.php" method="post">
            <div class="form-group">
                <label for="teamName">Team Name:</label>
                <input type="text" class="form-control" id="teamName" name="team_name" required>
            </div>
            <div class="form-group">
                    <label for="student_name_1">Student 1 Name:</label>
                    <input type="text" class="form-control" id="student_name_1" name="student_name_1" required>

                    <!-- Similar inputs for SRN, Department, CGPA for each student -->
                    <label for="student_srn_1">SRN Of Student 1:</label>
                    <input type="text" class="form-control" id="student_srn_1" name="student_srn_1" required>
                            
                    <label for="student_dept_1">Department Name OF Student 1:</label>
                    <input type="text" class="form-control" id="student_dept_1" name="student_dept_1" required>
                            
                    <label for="student_cgpa_1">CGPA Name OF Student 1:</label>
                    <input type="text" class="form-control" id="student_cgpa_1" name="student_cgpa_1" required>
            </div>
            <div class="form-group">
                    <label for="student_name_ 2">Student 2 Name:</label>
                    <input type="text" class="form-control" id="student_name_ 2" name="student_name_2" required>

                    <!-- Similar inputs for SRN, Department, CGPA for each student -->
                    <label for="student_srn_2">SRN Of Student 2:</label>
                    <input type="text" class="form-control" id="student_srn_2" name="student_srn_2" required>
                            
                    <label for="student_dept_2">Department Name OF Student 2:</label>
                    <input type="text" class="form-control" id="student_dept_2" name="student_dept_2" required>
                            
                    <label for="student_cgpa_2">CGPA Name OF Student 2:</label>
                    <input type="text" class="form-control" id="student_cgpa_2" name="student_cgpa_2" required>
            </div>
            <div class="form-group">
                    <label for="student_name_ 3">Student 3 Name:</label>
                    <input type="text" class="form-control" id="student_name_ 3" name="student_name_3" required>

                    <!-- Similar inputs for SRN, Department, CGPA for each student -->
                    <label for="student_srn_3">SRN Of Student 3:</label>
                    <input type="text" class="form-control" id="student_srn_3" name="student_srn_3" required>
                            
                    <label for="student_dept_3">Department Name OF Student 3:</label>
                    <input type="text" class="form-control" id="student_dept_3" name="student_dept_3" required>
                            
                    <label for="student_cgpa_3">CGPA Name OF Student 3:</label>
                    <input type="text" class="form-control" id="student_cgpa_3" name="student_cgpa_3" required>
            </div>
            <div class="form-group">
                    <label for="student_name_ 4">Student 4 Name:</label>
                    <input type="text" class="form-control" id="student_name_ 4" name="student_name_4" required>

                    <!-- Similar inputs for SRN, Department, CGPA for each student -->
                    <label for="student_srn_4">SRN Of Student 4:</label>
                    <input type="text" class="form-control" id="student_srn_4" name="student_srn_4" required>
                            
                    <label for="student_dept_4">Department Name OF Student 4:</label>
                    <input type="text" class="form-control" id="student_dept_4" name="student_dept_4" required>
                            
                    <label for="student_cgpa_4">CGPA Name OF Student 4:</label>
                    <input type="text" class="form-control" id="student_cgpa_4" name="student_cgpa_4" required>
            </div>
                    

            <button type="submit" class="btn btn-primary">Create Team</button>
        </form>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
        // Your JavaScript Functions
    </script>
</body>
</html>







<!-- <?php
$error = "";
if (isset($_SESSION['team_created'])) {
    // Redirect users to another page (e.g., dashboard) or display an appropriate message
    header("Location: homepage.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all fields are filled
    $requiredFields = [
        "team_name",
        "student_name_1",
        "student_srn_1",
        "student_dept_1",
        "student_cgpa_1",
        "student_name_2",
        "student_srn_2",
        "student_dept_2",
        "student_cgpa_2",
        "student_name_3",
        "student_srn_3",
        "student_dept_3",
        "student_cgpa_3",
        "student_name_4",
        "student_srn_4",
        "student_dept_4",
        "student_cgpa_4"
    ];

    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            $error = "Please fill in all fields";
            break;
        }
    }

    if (empty($error)) {
        // Proceed if no error
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
        $studentSRNs = [
            $_POST["student_srn_1"],
            $_POST["student_srn_2"],
            $_POST["student_srn_3"],
            $_POST["student_srn_4"]
        ];

        foreach ($studentSRNs as $studentSRN) {
            $checkTeamStmt = $conn->prepare("SELECT team_id FROM student WHERE srn = ?");
            $checkTeamStmt->bind_param("s", $studentSRN);
            $checkTeamStmt->execute();
            $checkTeamStmt->store_result();
            $checkTeamStmt->bind_result($team_id);
            $checkTeamStmt->fetch();

            if ($team_id !== null) {
                $error = "Student with SRN $studentSRN is already part of a team.";
                break;
            }
            $checkTeamStmt->free_result();
        }

        $checkTeamStmt->close();

        if (empty($error)) {
        // Prepare SQL statement for SRN validation
        $checkStmt = $conn->prepare("SELECT COUNT(*) AS total FROM student WHERE srn = ?");
        $checkStmt->bind_param("s", $studentSRN);

        $valid = true;

        // Loop through student SRNs
        for ($i = 1; $i <= 4; $i++) {
            $studentSRN = $_POST["student_srn_" . $i];

            // Check if the SRN exists
            $checkStmt->execute();
            $result = $checkStmt->get_result();
            $row = $result->fetch_assoc();

            if ($row['total'] == 0) {
                $valid = false;
                $error = "SRN $studentSRN does not exist in the students' records.";
                break; // Exit loop if any SRN doesn't exist
            }
        }

        $checkStmt->close();

        if ($valid) {
            // Prepare SQL statement for team insertion
            $stmt = $conn->prepare("INSERT INTO team (team_name,student_name_1, student_srn_1, student_dept_1, student_cgpa_1, student_name_2, student_srn_2, student_dept_2, student_cgpa_2, student_name_3, student_srn_3, student_dept_3, student_cgpa_3, student_name_4, student_srn_4, student_dept_4, student_cgpa_4) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            // Bind parameters
            $stmt->bind_param(
                "sssssssssssssssss",
                $_POST["team_name"],
                $_POST["student_name_1"],
                $_POST["student_srn_1"],
                $_POST["student_dept_1"],
                $_POST["student_cgpa_1"],
                $_POST["student_name_2"],
                $_POST["student_srn_2"],
                $_POST["student_dept_2"],
                $_POST["student_cgpa_2"],
                $_POST["student_name_3"],
                $_POST["student_srn_3"],
                $_POST["student_dept_3"],
                $_POST["student_cgpa_3"],
                $_POST["student_name_4"],
                $_POST["student_srn_4"],
                $_POST["student_dept_4"],
                $_POST["student_cgpa_4"]
            );

            // Execute SQL statement
            $stmt->execute();
            $_SESSION['team_created'] = true;
            // Close statement
            $stmt->close();
        }
    }

        // Close connection
        $conn->close();
    }
}
?> -->