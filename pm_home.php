<?php
ini_set ('display_errors', '1');
  error_reporting(E_ALL);
      $con = mysqli_connect('ls-77e1472d76ad627554447c61511cf31b8998c2ce.c1ca77nowf79.us-west-2.rds.amazonaws.com', 'dbmasteruser', 'comp4900', 'database1');

          if (!$con){
                  echo 'not connected to server';
          }

          if (!mysqli_select_db($con, 'database1')){
                  echo 'database not selected' . mysqli_connect_error();
          }

session_start();
$userID = $_SESSION['id'];
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

  <style>
    .button {
	  display:block;
	  text-align:center;
  }
  </style>

  </head>


  
  
  <body>

    <div class="jumbotron text-center">
      <h1><b>PROJECT MANAGER HOME</b></h1>            
    </div>

    <span class="button">
    <div class="btn-group-vertical">
      <button onclick="location.href='pm_timesheet.php'" type="button" class="btn btn-outline-info">Timesheet</button>
      <br>
      <button onclick="location.href='workBreakDown.php'" type="button" class="btn btn-outline-info">Work Breakdown Structure</button>
      <br>
      <button onclick="location.href='report.php'" type="button" class="btn btn-outline-info">Report</button>
      <br>
      <a href="logout.php" class="btn btn-outline-danger">Sign Out of Your Account</a>
    </div>
  </span>
      
  
  </body>


</html>