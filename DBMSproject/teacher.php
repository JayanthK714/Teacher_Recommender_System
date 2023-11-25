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

// Fetch teachers' information from the database
$fetchTeachersQuery = "SELECT * FROM teacher";
$result = $conn->query($fetchTeachersQuery);

$teachers = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $teachers[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teachers</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <style>
        /* Add your custom styles here */
        .teacher-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
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
      <ul class="navbar-nav me-auto mb-2 mb-lg-0"
          id="navLinks">
        <li class="nav-item">
          <a class="nav-link" 
             aria-current="page" 
             href="studenthome.php">Dashboard</a>
      </ul>
    </nav>
    <div class="container mt-5">
        <div class="row">
            <?php foreach ($teachers as $teacher): ?>
                <div class="col-md-3 mb-4">
                    <div class="card text-center">
                    <img style="margin-left: auto; margin-right: auto;" src="<?php echo 'data:image/jpeg;base64,' . base64_encode($teacher['image_path']); ?>" class="card-img-top teacher-img" alt="<?php echo $teacher['name']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $teacher['name']; ?></h5>
                            <a href="teacher_details.php?id=<?php echo $teacher['id']; ?>" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
