<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Student - Home</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">
	<link rel="icon" href="logo.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
             href="">Dashboard</a>
      </ul>
      <ul class="navbar-nav me-right mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Logout</a>
        </li>
      </ul>
  </div>
    </div>
</nav>
     <div class="container mt-5">
         <div class="container text-center">
             <div class="row row-cols-5">
             <a href="profilecreation.php" class="col btn btn-dark m-2 py-3 col-5">
                 <i class="fa fa-user-graduate fs-1" aria-hidden="true"></i><br>
                  Profile Creation
               </a> 
               <a href="profile_view.php" 
                  class="col btn btn-dark m-2 py-3 col-5">
                 <i class="fa fa-user-md fs-1" aria-hidden="true" ></i><br>
                  Personal Information
               </a> 
               <a href="team.php" class="col btn btn-dark m-2 py-3 col-5">
                 <i class="fa fa-pencil-square fs-1" aria-hidden="true"></i><br>
                  Team Registration
               </a> 
               <a href="team_domain.php" class="col btn btn-dark m-2 py-3 col-5">
                 <i class="fa fa-cubes fs-1" aria-hidden="true"></i><br>
                  Team And Domain
               </a> 
               <a href="teacher.php" class="col btn btn-dark m-2 py-3 col-5">
                 <i class="fa fa-user fs-1" aria-hidden="true"></i><br>
                  Teachers
               </a> 
               <a href="" class="col btn btn-dark m-2 py-3 col-5">
                 <i class="fa fa-graduation-cap fs-1" aria-hidden="true"></i><br>
                  Your Achievments
               </a> 
               <a href="capstone.php" class="col btn btn-dark m-2 py-3 col-5">
                 <i class="fa fa-book fs-1" aria-hidden="true"></i><br>
                  Capstone Project
               </a> 
               <a href="teacherrecommend.php" class="col btn btn-dark m-2 py-3 col-12">
                 <i class="fa fa-envelope fs-1" aria-hidden="true"></i><br>
                  Recomennded Teachers
               </a> 
               <div class="row">
               <a href="" class="col btn btn-primary m-2 py-3 ">
                 <i class="fa fa-cogs fs-1" aria-hidden="true"></i><br>
                  Settings
               </a> </div>
               <a href="logout.php" class="col btn btn-warning m-2 py-3">
                 <i class="fa fa-sign-out fs-1" aria-hidden="true"></i><br>
                  Logout
               </a> 
             </div>
         </div>
     </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>	
    <script>
        $(document).ready(function(){
             $("#navLinks li:nth-child(1) a").addClass('active');
        });
    </script>

</body>
</html>