


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teams and Domain Preferences</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Add your custom styles here */
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
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h2>Teams and Their Domain Preferences</h2>
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
                $userSRN = $_SESSION['username'];

                // SQL query to retrieve team information with their domain preferences
                $sql = "SELECT team.team_id, team.team_name, domain.domain_name
                FROM team
                LEFT JOIN domain ON team.team_id = domain.team_id
                WHERE team.team_id IN (
                    SELECT team_id
                    FROM team
                    WHERE student_srn_1 = '$userSRN' 
                       OR student_srn_2 = '$userSRN' 
                       OR student_srn_3 = '$userSRN' 
                       OR student_srn_4 = '$userSRN'
                )";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo '<table class="table table-striped">';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th>Team ID</th>';
                    echo '<th>Team Name</th>';
                    echo '<th>Domain Preference</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row['team_id'] . '</td>';
                        echo '<td>' . $row['team_name'] . '</td>';
                        echo '<td>' . $row['domain_name'] . '</td>';
                        echo '</tr>';
                    }
                    echo '</tbody>';
                    echo '</table>';
                } else {
                    echo '<p>No data available</p>';
                }

                $conn->close();
                ?>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS link (if required) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
