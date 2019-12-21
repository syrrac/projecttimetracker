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
  //echo $userId;
	$sql = "SELECT Category.Category_Code, Task.Task_Code,
          Weekly_Timesheet.Actuals, Weekly_Timesheet.ETC, Weekly_Timesheet.Timesheet_ID,
          Task.Task_ID, User.User_ID, Task.Task_ID
          FROM User
			INNER JOIN Task
          ON Task.User_User_ID = User_ID
          INNER JOIN Category
          ON Category.Category_ID = Task.Category_Category_ID
          INNER JOIN Weekly_Timesheet
          ON Weekly_Timesheet.Task_Task_ID = Task.Task_ID
          WHERE Task.User_User_ID = '$userId' AND yearweek(DATE(Week_Start_Date), 1) = yearweek(curdate(), 1)";
	$records = mysqli_query($con, $sql);
	
?>

<html>

<head>    
  <style>
      span {
        float: right;
      }
  </style>

<title> Timesheet </title>

</head>

<body>

<span><a href="pm_home.php">Go Back to Home</a></span>
<form action= "pm_timesheet.php" method ="post">
  <div class="dropdown">
    <button class="dropbtn1">Dropdown</button>
      <div class="dropdown-content">
        <a href="#">Link 1</a>
        <a href="#">Link 2</a>
        <a href="#">Link 3</a>
      </div>
  </div>
  <div class="dropdown">
    <button class="dropbtn2">Dropdown</button>
      <div class="dropdown-content">
        <a href="#">Link 1</a>
        <a href="#">Link 2</a>
        <a href="#">Link 3</a>
      </div>
  </div>
<table width = "600" border ="1" cellpadding = "1" cellspacing = "1">

<tr>
<th> Category Code</th>
<th> Task Code</th>
<th> Actuals</th>
<th> ETC </th>

</tr>

<?php
ini_set ('display_errors', '1');
error_reporting(E_ALL);
  
  $j = 0;
	while($wt = mysqli_fetch_assoc($records)){
?>

  <tr>
    <td> <?php echo $wt['Category_Code']; ?></td>
    <td> <?php echo $wt['Task_Code']; ?></td>
    <td> <input type = "number" name = "Actuals[]" value = "<?php echo $wt['Actuals']?>"> </td>
    <td> <input type = "number" name = "ETC[]" value = "<?php echo $wt['ETC']?>"></td>
  </tr>
  
  <?php
    
    $taskID = $wt['Task_ID'];   
    //echo $taskID;
    if (isset($_POST['Actuals']) && isset($_POST['ETC'])){
  
      $charged = $_POST['Actuals'];
      $ETC = $_POST['ETC'];

/*      $changeTimesheet = mysqli_query($con, "UPDATE Weekly_Timesheet SET Actuals = '$charged', ETC = '$ETC'");
*/
/*      for ($c = 0, $count = count($_POST['Actuals']); $c < $count; $c++){
        mysqli_query($con, "UPDATE Weekly_Timesheet SET Actuals = '$charged[$c]', ETC = '$ETC[$c]'");
      }*/

      for ($c = $j, $count = count($_POST['Actuals']); $c < $count; $c++){
        $update = mysqli_query($con, "UPDATE Weekly_Timesheet SET Actuals = '$charged[$c]', ETC = '$ETC[$c]' WHERE Task_Task_ID = '$taskID'");
        ++$j;
        
        
        if ($update){
          echo "<meta http-equiv=\"refresh\" content = \"0; URL = pm_timesheet.php\">";

        }else{
          echo "not updated";
        }
        break;
      }

      /*if ($changeTimesheet){
        //echo "changed";
        echo "<meta http-equiv=\"refresh\" content = \"0; URL = pm_timesheet.php\">";
      }
      else{
        echo "not edited";
      }*/
  
/*    $charged = $_POST['Actuals'][$j];
        $ETC = $_POST['ETC'][$j];

    
  
      $sql2 = "INSERT INTO Weekly_Timesheet (Actuals, ETC, Task_Task_ID) VALUES (";
  for ($c = 0, $count = count($_POST['Actuals']); $c < $count; $c++){
      $sql2 .= "'". $charged[$c] . "' , '". $ETC[$c] . "' , '". $taskID . "') ,(";
  }
  
  $sql2 = substr($sql2, 0, -1);
  $sql2 = substr($sql2, 0, -1);
  
  $sql2 .= "\"";
  
  echo $sql2;*/
    
  
  /*
  for ($c = 0, $count = count($_POST['Actuals']); $c < $count; $c++){
    mysqli_query($con, "INSERT INTO Weekly_Timesheet (Actuals, ETC, Task_Task_ID) VALUES ('$charged[$c]', '$ETC[$c]', '$taskID')");
  }
  */

  /*
    if (!mysqli_query($con, $sql2)){
                echo 'not inserted';
        }else{
                echo 'inserted';
        }

    }
    */ 

}
//$j++;
    }


  ?>
</table>
    <input type="submit" name="SAVE">
  </form>
</body>
</html>

 