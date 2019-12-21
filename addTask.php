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

    $sql1 = "SELECT User.User_First_Name, User.User_Last_Name
        FROM User
        INNER JOIN Project
        ON User.Project_Project_ID = Project.Project_ID
        WHERE Project.Project_Name = 'daniel'";

      $sql4 = "SELECT Project_Project_ID
              FROM User
              WHERE User_ID = '$userId'";

    $records1 = mysqli_query($con, $sql1);
    $records4 = mysqli_query($con, $sql4);
?>
<?php

/*if (isset($_GET['id']) && isset($_POST['newCatName']) && isset($_POST['newCatCode'])){
  
  $catID = $_GET['id'];
  $catName = $_POST['newCatName'];
  $catCode = $_POST['newCatCode'];
  
  $changeCategory = mysqli_query($con, "UPDATE Category SET Category_Name = '$catName', Category_Code = '$catCode' WHERE Category_ID = '$catID'");
              
  if ($changeCategory){
    echo "edited";
  }
  else{
    echo "not edited";
  }
  
  
}*/
    
    if (isset($_GET['idCat'])){
      $catID = $_GET['idCat'];
      
      $sql = "SELECT * FROM Category WHERE Category_ID = '$catID'";
      
      $record = mysqli_query ($con, $sql);
    
    
    while ($a = mysqli_fetch_assoc($record)){
      
    
?>

<html>
  <head>
  <style>
  span {
        float: right;

      }
  </style>
  </head>

  <body>
  <span><a href="workBreakDown.php">Go Back to WBS</a></span>
  <form action="addTask.php" method="post">
    <input type = "text" name = "newTaskName" placeholder = "Input new task name" >
    <input type = "text" name = "newTaskCode" placeholder = "Input new task code" >
    <select name = "assignee">
    <?php
        $i = 0;
      while($wt4 = mysqli_fetch_assoc($records4)){
             $projectID = $wt4['Project_Project_ID'];
             
             $sqlAssignee = "SELECT User_First_Name, User_Last_Name, User_ID
                             FROM User
                             WHERE Project_Project_ID = '$projectID'";
             $assigneeRun = mysqli_query($con, $sqlAssignee);
        while($wt1 = mysqli_fetch_assoc($assigneeRun)){
    ?>
        <option value = "<?php echo $wt1['User_ID']; ?>"><?php echo $wt1['User_First_Name']." ".$wt1['User_Last_Name'] ?></option>
    <?php
        }
        mysqli_data_seek($assigneeRun, 0);
      }
        mysqli_data_seek($records4, 0);
    ?>
    </select>
    <input type = "date" name="newTaskStart">
    <input type = "date" name="newTaskEnd">
    <input type = "number" name = "budget">
    <input type = "hidden" name = "catID" value = "<?php echo $a['Category_ID']; ?>">
    <input type = "submit" name = "addNow" value = add>
  

  </form>
    
    <?php
    }
    }

    if (isset($_POST['newTaskName']) && isset($_POST['newTaskCode']) && isset($_POST['newTaskStart'])
        && isset($_POST['newTaskEnd']) && isset($_POST['budget'])) {
      
        $catID = $_POST['catID'];
        $taskName = $_POST['newTaskName'];
        $taskCode = $_POST['newTaskCode'];
        $taskStart = $_POST['newTaskStart'];
        $taskEnd = $_POST['newTaskEnd'];
        $taskBudget = $_POST['budget'];
        $selectAssignee = $_POST['assignee'];
        
  
        $addNewTask = mysqli_query($con, "INSERT INTO Task (Task_Name, Task_Start_Date, Task_End_Date, Task_Budget, Task_code, Category_Category_ID, User_User_ID) VALUES ('$taskName', '$taskStart', '$taskEnd', '$taskBudget', '$taskCode', '$catID', '$selectAssignee')");
      
        $startDateCatSQL = "SELECT MIN(Task_Start_Date) 
                        FROM Task
                        WHERE Category_Category_ID = '$catID'";
        $endDateCatSQL = "SELECT MAX(Task_End_Date) 
                        FROM Task
                        WHERE Category_Category_ID = '$catID'";
      
        $startDateCat = mysqli_query($con, $startDateCatSQL);
        $endDateCat = mysqli_query($con, $endDateCatSQL);
                    
        while ($result1 = mysqli_fetch_assoc($startDateCat)){
          $startDate = $result1['MIN(Task_Start_Date)'];
          mysqli_query($con, "UPDATE Category SET Category_Start_Date = '$startDate' WHERE Category_ID = '$catID'");
        }
        
        while($result2 = mysqli_fetch_assoc($endDateCat)){
          $endDate = $result2['MAX(Task_End_Date)'];
          mysqli_query($con, "UPDATE Category SET Category_End_Date = '$endDate' WHERE Category_ID = '$catID'");
        }
              
        if ($addNewTask){
            echo "<meta http-equiv=\"refresh\" content = \"0; URL = workBreakDown.php\">";
        } else{
            echo "not added";
        }
    }

    ?>
    </body>
</html>
