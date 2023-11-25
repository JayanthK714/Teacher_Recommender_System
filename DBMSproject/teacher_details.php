<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "teacherdb"; // Replace with your actual database name

// Retrieve teacher ID from URL parameter
$teacherId = $_GET['id'];

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch teacher's information from the database based on ID
$fetchTeacherQuery = "SELECT * FROM teacher WHERE id = $teacherId";
$result = $conn->query($fetchTeacherQuery);

if ($result && $result->num_rows > 0) {
    $teacher = $result->fetch_assoc();
} else {
    // Redirect if the teacher ID is not found or invalid
    header("Location: teacher.php");
    exit();
}

$conn->close();
?>

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
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="teacher.php">Teacher list</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card text-center">
            <img style="margin-left: auto; margin-right: auto;" src="<?php echo 'data:image/jpeg;base64,' . base64_encode($teacher['image_path']); ?>" class="card-img-top teacher-img" alt="<?php echo $teacher['name']; ?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $teacher['name']; ?></h5>
                    <h5>Email: <?php echo $teacher['email']; ?></h5>
                    <h5>Phone: <?php echo $teacher['phone']; ?></h5>
                    <h5>Department: <?php echo $teacher['teacherdept']; ?></h5>
                    <h5>Campus: <?php echo $teacher['campus']; ?></h5>
                </div>
            </div>
        </div>
        <div class="col-md-8 details-container">
            <h3>Teacher Details</h3>
            
            <h5>Achievements:</h5>
            <ul>
                <?php
                // Splitting achievements into individual points
                $achievements = explode("\n", $teacher['achievements']);
                foreach ($achievements as $achievement) {
                    echo "<li>$achievement</li>";
                }
                ?>
            </ul>
            
            <h5>Teaching:</h5>
            <ul>
                <?php
                // Splitting teaching points
                $teaching = explode("\n", $teacher['Teaching']);
                foreach ($teaching as $teach) {
                    echo "<li>$teach</li>";
                }
                ?>
            </ul>
            
            <h5>Research Interest:</h5>
            <ul>
                <?php
                // Splitting research interests
                $researchInterests = explode("\n", $teacher['researchinterest']);
                foreach ($researchInterests as $interest) {
                    echo "<li>$interest</li>";
                }
                ?>
            </ul>
            
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="text-center">
        <a href="publications.php?id=<?php echo $teacher['id']; ?>" class="btn btn-primary">View Publications</a>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
