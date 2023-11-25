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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"]; 
    $contactNumber = $_POST["contact"];
    $srn = $_POST["srn"];
    $gender = $_POST["gender"];
    $dob = $_POST["dob"];
    $department = $_POST["deptname"];
    $semester = $_POST["semester"];
    if ($_FILES["profile_picture"]["error"] == 0) {
        $targetDir = "uploads/";  // Create a folder named "uploads" in your project directory
        $targetFile = $targetDir . basename($_FILES["profile_picture"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
        // Check if the file is a valid image
        $validExtensions = array("jpg", "jpeg", "png");
        if (in_array($imageFileType, $validExtensions)) {
            // Move the uploaded file to the specified directory
            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $targetFile)) {
                echo "Profile picture uploaded successfully!";
                // Save the file path or additional information in the database if needed
            } else {
                echo "Error uploading profile picture.";
            }
        } else {
            echo "Invalid image format. Please upload a JPG or PNG file.";
        }
    }
    // Check if the student already exists
    $checkStudentQuery = "SELECT * FROM Student WHERE srn = '$srn'";
    $result = $conn->query($checkStudentQuery);

    if ($result->num_rows > 0) {
        echo "Error: Profile already exists. You can view your profile <a href='profile_view.php'>here</a> or Fill Up ACHIEVEMENT FORM <a href='achievements.php'>here</a>.";
    } else {
        // Insert new profile into the database
        $insertProfileQuery = "INSERT INTO Student (Name, Email, Contact, SRN, Gender, DOB, DeptName, Semester) VALUES ('$name', '$email', '$contactNumber', '$srn', '$gender', '$dob', '$department', '$semester')";

        if ($conn->query($insertProfileQuery) === TRUE) {
            echo "Profile created successfully!";
            $_SESSION["srn"] = $srn;
        } else {
            echo "Error: " . $insertProfileQuery . "<br>" . $conn->error;
        }
    }
}
$profilecreated = isset($_SESSION["srn"]);
if ($profilecreated){
    header("Location: achievements.php");
    exit();
}

$conn->close();
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile Creation</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="style.css"> <!-- Include your custom styles if needed -->
    <link rel="icon" href="logo.jpeg">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <!-- Your Navbar Content -->
        <a class="navbar-brand" href="">
            <img src="logo.jpeg" width="40">
        </a>
        <ul class="navbar-nav me-auto mb-2 mb-lg-0"
          id="navLinks">
        <li class="nav-item">
        
          <a class="nav-link" 
             aria-current="page" 
             href="studenthome.php">Dashboard</a>
        </ul>
        <ul class="navbar-nav me-auto mb-2 mb-lg-0"
          id="navLinks">
        <li class="nav-item">
          <a class="nav-link" 
             aria-current="page" 
             href="achievements.php">Achievement</a>
        </ul>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Student Profile Creation</h5>
                    </div>
                    <div class="card-body">
                        <form action="profilecreation.php" method="post" enctype="multipart/form-data">
                            <div class="mb-3 row">
                                <label for="name" class="col-sm-3 col-form-label">Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="srn" class="col-sm-3 col-form-label">SRN</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="srn" name="srn" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">Gender</label>
                                <div class="col-sm-9">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="male" value="Male" required>
                                        <label class="form-check-label" for="male">Male</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="female" value="Female" required>
                                        <label class="form-check-label" for="female">Female</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">Date of Birth</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control datepicker" name="dob" placeholder="Select Date of Birth" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="email" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="contact_number" class="col-sm-3 col-form-label">Contact Number</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="contact" name="contact" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">Department Name</label>
                                <div class="col-sm-9">
                                    <select class="form-select" name="deptname" required>
                                        <option value="CSE">Computer Science and Engineering (CSE)</option>
                                        <option value="ECE">Electronics and Communication Engineering (ECE)</option>
                                        <option value="EEE">Electrical and Electronics Engineering (EEE)</option>
                                        <option value="ME">Mechanical Engineering (ME)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="semester" class="col-sm-3 col-form-label">Semester</label>
                                <div class="col-sm-9">
                                <select class="form-select" name="semester" required>
                                        <option value="1st">First Semester</option>
                                        <option value="2nd">Second Semester</option>
                                        <option value="3rd">Third Semester</option>
                                        <option value="4th">Fouth Semester</option>
                                        <option value="5th">Fifth Semester</option>
                                        <option value="6th">Sixth Semester</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="profile_picture" class="col-sm-3 col-form-label">Profile Picture</label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*">
                                    <small class="text-muted">Upload a JPG or PNG file (max size: 2MB)</small>
                                </div>
                            </div>
                            <div class="text-left">
                                <button type="submit" class="btn btn-primary">Create Profile</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>
    </script>
    <script>
        // Initialize datepicker
        $(document).ready(function(){
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });
        });
    </script>
</body>
</html>
