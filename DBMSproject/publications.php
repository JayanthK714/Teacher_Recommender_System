<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "teacherdb"; // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve teacher ID from URL parameter
$teacherId = $_GET['id'];

// Fetch teacher's information from the database based on ID
$fetchTeacherQuery = "SELECT * FROM teacher WHERE id = $teacherId";
$result = $conn->query($fetchTeacherQuery);

if ($result && $result->num_rows > 0) {
    $teacher = $result->fetch_assoc();
} else {
    // Redirect if the teacher ID is not found or invalid
    header("Location: teacher_details.php");
    exit();
}

// Fetch publications of the selected teacher
$fetchPublicationsQuery = "SELECT * FROM publications WHERE id = $teacherId";
$publicationsResult = $conn->query($fetchPublicationsQuery);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Publications</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
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
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="teacher.php">Teacher List</a>
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
                </div>
            </div>
        </div>
            <div class="col-md-8 details-container">
                <?php if ($publicationsResult->num_rows > 0) : ?>
                    <ul>
                        <h5>Conferences:</h5>
                        <?php while ($row = $publicationsResult->fetch_assoc()) : ?>
                            <?php
                                // Splitting achievements into individual points
                                $conferences = explode("\n", $row['conferences']);
                                foreach ($conferences as $conference) {
                                echo "<li>$conference</li>";
                                }
                            ?>
                            <br>
                            <h5>Journals:</h5>
                            <?php
                                // Splitting achievements into individual points
                                $journals = explode("\n", $row['journals']);
                                foreach ($journals as $journal) {
                                echo "<li>$journal</li>";
                                }
                            ?>
                            <br>
                            <h5>Publications:</h5>
                            <?php
                                // Splitting achievements into individual points
                                $publications = explode("\n", $row['publications']);
                                foreach ($publications as $publication) {
                                echo "<li>$publication</li>";
                                }
                            ?>
                        <?php endwhile; ?>
                    </ul>
                <?php else : ?>
                    <p>No publications found for this teacher.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
