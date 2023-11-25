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

// Retrieve SRN from session
$srn = $_SESSION["username"];

// Fetch the student details based on the SRN
$fetchProfileQuery = "SELECT * FROM Student WHERE SRN = '$srn'";
$result = $conn->query($fetchProfileQuery);

if ($result) {
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = isset($row["name"]) ? $row["name"] : "Not available";
        $contactNumber = isset($row["contact"]) ? $row["contact"] : "Not available";
        $gender = isset($row["gender"]) ? $row["gender"] : "Not available";
        $dob = isset($row["dob"]) ? $row["dob"] : "Not available";
        $department = isset($row["deptname"]) ? $row["deptname"] : "Not available";
        $semester = isset($row["semester"]) ? $row["semester"] : "Not available";

        // Fetch the profile picture from the database
        $fetchProfilePictureQuery = "SELECT profile_picture FROM Student WHERE SRN = '$srn'";
        $resultPicture = $conn->query($fetchProfilePictureQuery);

        if ($resultPicture) {
            if ($resultPicture->num_rows > 0) {
                $rowPicture = $resultPicture->fetch_assoc();
                $profilePicture = $rowPicture["profile_picture"];
            }
        }
    } else {
        echo "Error: Profile not found.";
        exit;
    }
} else {
    // Handle the query error
    echo "Error: " . $conn->error;
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
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
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Student Profile</h5>
                    </div>
                    <div class="card-body">
                    <?php if (isset($profilePicture)): ?>
                            <div class="text-center mb-4">
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($profilePicture); ?>" alt="Profile Picture" class="img-fluid rounded-circle" style="width: 150px; height: 150px;">
                            </div>
                        <?php endif; ?>
                        <dl class="row">
                            <dt class="col-sm-3">Name:</dt>
                            <dd class="col-sm-9"><?php echo $name; ?></dd>

                            <dt class="col-sm-3">SRN:</dt>
                            <dd class="col-sm-9"><?php echo $srn; ?></dd>

                            <dt class="col-sm-3">Gender:</dt>
                            <dd class="col-sm-9"><?php echo $gender; ?></dd>

                            <dt class="col-sm-3">Date of Birth:</dt>
                            <dd class="col-sm-9"><?php echo $dob; ?></dd>

                            <dt class="col-sm-3">Contact Number:</dt>
                            <dd class="col-sm-9"><?php echo $contactNumber; ?></dd>

                            <dt class="col-sm-3">Department:</dt>
                            <dd class="col-sm-9"><?php echo $department; ?></dd>

                            <dt class="col-sm-3">Semester:</dt>
                            <dd class="col-sm-9"><?php echo $semester; ?></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

