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
$userId = $_SESSION["id"];
$sql4 = "SELECT Project_Project_ID
              FROM User
              WHERE User_ID = '$userId'";

$records4 = mysqli_query($con, $sql4);
    

?>

<html>
  <head>
    <style>
      span {
        float: right;
      }
      th, td{
        text-align: center;
      }
    </style>
    <title> Weekly Report Page</title>
  </head>
  
  <body>
    <span><a href="pm_home.php">Go Back to Home</a></span>
    <form method = "post" action = ""><input type = "submit" value = "Previous week" name = "prevWeek"></form>
    <form method = "post" action = ""><input type = "submit" value = "Current week" name = "curWeek"></form>
    <table id = "myTable">
      <tr>
        <th>
          Task Code
        </th>
        <th>
          Name
        </th>
        <th>
          Assignee
        </th>
        <th>
          Start Date
        </th>
        <th>
          End Date
        </th>
        <th>
          Budget(hrs)
        </th>
        <th>
          Actual
        </th>
        <th>
          ETC
        </th>
        <th>
          Var
        </th>
        <th>
          EAC
        </th>
      </tr>
      
      <?php
      if (isset($_POST['curWeek'])){
      
        while($wt4 = mysqli_fetch_assoc($records4)){
          $projectID = $wt4['Project_Project_ID'];
          $curSQL = "SELECT * FROM Task
          INNER JOIN Category
          ON Category.Category_ID = Task.Category_Category_ID
          INNER JOIN Proj_Cat
          ON Category.Category_ID = Proj_Cat.Category_Category_ID
          INNER JOIN Project
          ON Project.Project_ID = Proj_Cat.Project_Project_ID
          INNER JOIN Weekly_Timesheet
          ON Task.Task_ID = Weekly_Timesheet.Task_Task_ID
          INNER JOIN User
          ON Task.User_User_ID = User.User_ID
          WHERE Project.Project_ID = '$projectID' AND yearweek(DATE(Week_Start_Date), 1) = yearweek(curdate(), 1)";
        
        
        $cur = mysqli_query($con, $curSQL);
        
        
        
        while ($wt = mysqli_fetch_assoc($cur)){
          $eac = $wt['ETC'] + $wt['Actuals'];
          $var = $wt['Task_Budget'] - $eac;
          
          ?>
          
      
      <tr>
        <td>
          <?php echo $wt['Task_Code']; ?>
        </td>
        <td>
          <?php echo $wt['Task_Name']; ?>
        </td>
        <td>
          <?php echo $wt['User_First_Name']. " ". $wt['User_Last_Name']; ?>
        </td>
        <td>
          <?php echo $wt['Task_Start_Date']; ?>
        </td>
        <td>
          <?php echo $wt['Task_End_Date']; ?>
        </td>
        <td>
          <?php echo $wt['Task_Budget']; ?>
        </td>
        <td>
          <?php echo $wt['Actuals']; ?>
        </td>
        <td>
          <?php echo $wt['ETC']; ?>
        </td>
        <td>
          <?php echo $var; ?>
        </td>
        <td>
          <?php echo $eac; ?>
        </td>
      </tr>
      <?php
        }
        }
        mysqli_data_seek($records4, 0);
      }
      
      if (isset($_POST['prevWeek'])){
        while($wt4 = mysqli_fetch_assoc($records4)){
          $projectID = $wt4['Project_Project_ID'];
          $prevSQL = "SELECT * FROM Task
          INNER JOIN Category
          ON Category.Category_ID = Task.Category_Category_ID
          INNER JOIN Proj_Cat
          ON Category.Category_ID = Proj_Cat.Category_Category_ID
          INNER JOIN Project
          ON Project.Project_ID = Proj_Cat.Project_Project_ID
          INNER JOIN Weekly_Timesheet
          ON Task.Task_ID = Weekly_Timesheet.Task_Task_ID
          INNER JOIN User
          ON Task.User_User_ID = User.User_ID
          WHERE Project.Project_ID = '$projectID' AND YEARWEEK(Week_Start_Date, 1) = YEARWEEK(NOW() - INTERVAL 1 WEEK, 1)";
        
      $prev = mysqli_query($con, $prevSQL);
        
        while ($wt2 = mysqli_fetch_assoc($prev)){
          $eac2 = $wt2['ETC'] + $wt2['Actuals'];
          $var2 = $wt2['Task_Budget'] - $eac2;
          
          ?>
          
      <tr>
        <td>
          <?php echo $wt2['Task_Code']; ?>
        </td>
        <td>
          <?php echo $wt2['Task_Name']; ?>
        </td>
        <td>
          <?php echo $wt2['User_First_Name']. " ". $wt2['User_Last_Name']; ?>
        </td>
        <td>
          <?php echo $wt2['Task_Start_Date']; ?>
        </td>
        <td>
          <?php echo $wt2['Task_End_Date']; ?>
        </td>
        <td>
          <?php echo $wt2['Task_Budget']; ?>
        </td>
        <td>
          <?php echo $wt2['Actuals']; ?>
        </td>
        <td>
          <?php echo $wt2['ETC']; ?>
        </td>
        <td>
          <?php echo $var2; ?>
        </td>
        <td>
          <?php echo $eac2; ?>
        </td>
      </tr>
      <?php
        }
        }
        mysqli_data_seek($records4, 0);
    }
      ?>
    </table>
  </body>
  

</html>