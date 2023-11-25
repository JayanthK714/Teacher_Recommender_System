<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Capstone Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <style>
        /* Add your custom styles here */
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
    <a class="navbar-brand" href="">
    <img src="logo.jpeg" width="40">
    </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="studenthome.php">Dashboard</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <?php
                session_start();
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "teacherdb";

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                if (!isset($_SESSION['username'])) {
                    header("Location: login.php");
                    exit();
                }
                $srn = $_SESSION['username'];

                $teamDetailsQuery = "SELECT * FROM team WHERE 
                    student_srn_1 = '$srn' OR 
                    student_srn_2 = '$srn' OR 
                    student_srn_3 = '$srn' OR 
                    student_srn_4 = '$srn'";

                $teamDetailsResult = $conn->query($teamDetailsQuery);

                if ($teamDetailsResult->num_rows > 0) {
                    $row = $teamDetailsResult->fetch_assoc();
                    echo "<h2>Team Details</h2>";
                    echo "<h4>Team Name: " . $row["team_name"] . "</h4>";
                    echo "<p>Team ID: " . $row["team_id"] . "</p>";
                    echo "<p> Student 1 NAME:". $row["student_name_1"]."</p>";
                    echo "<p> Student 1 SRN:". $row["student_srn_1"]."</p>";
                    echo "<p> Student 1 Dept Name:". $row["student_dept_1"]."</p>";
                    echo "<p> Student 1 CGPA:". $row["student_cgpa_1"]."</p>";
                    echo "<p> Student 2 NAME:". $row["student_name_2"]."</p>";
                    echo "<p> Student 2 SRN:". $row["student_srn_2"]."</p>";
                    echo "<p> Student 2 Dept Name:". $row["student_dept_2"]."</p>";
                    echo "<p> Student 2 CGPA:". $row["student_cgpa_2"]."</p>";
                    echo "<p> Student 3 NAME:". $row["student_name_3"]."</p>";
                    echo "<p> Student 3 SRN:". $row["student_srn_3"]."</p>";
                    echo "<p> Student 3 Dept Name:". $row["student_dept_3"]."</p>";
                    echo "<p> Student 3 CGPA:". $row["student_cgpa_3"]."</p>";
                    echo "<p> Student 4 NAME:". $row["student_name_4"]."</p>";
                    echo "<p> Student 4 SRN:". $row["student_srn_4"]."</p>";
                    echo "<p> Student 4 Dept Name:". $row["student_dept_4"]."</p>";
                    echo "<p> Student 4 CGPA:". $row["student_cgpa_4"]."</p>";
                } else {
                    echo "<h3>You are not part of any team.</h3>";
                }
                $conn->close();
                ?>
            </div>
            <div class="col-md-6">
                <h2>Capstone Project Details Form</h2>
                <form action="process_capstone.php" method="post">
                    <div class="form-group">
                        <label for="projectTitle">Project Title:</label>
                        <input type="text" class="form-control" id="projectTitle" name="project_title" required>
                    </div>
                    <div class="form-group">
                        <label for="projectDescription">Project Description:</label>
                        <input type="text" class="form-control" id="projectDescription" name="project_description" required>
                    </div>
                    <div class="form-group">
                        <label for="projectRequirements">Project Requirements:</label>
                        <input type="text" class="form-control" id="projectRequirements" name="project_requirements" required>
                    </div>
                    <div class="form-group">
                        <label for="domainOfInterest">Domain of Interest:</label>
                        <select class="form-control" id="domainOfInterest" name="domain_of_interest" required>
                            <option value="">Select Domain</option>
                            <option value="Machine Learning">Machine Learning</option>
                            <option value="Deep Learning">Deep Learning</option>
                            <option value="Computer Networks">Computer Networks</option>
                            <option value="Cyber Security">Cyber Security</option>
                            <option value="IOT">IOT</option>
                            <option value="Natural Language Processing"> Natural Language Processing</option>
                            <option value="Data Science"> Data Science</option>
                            <!-- Add more options as needed -->
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
