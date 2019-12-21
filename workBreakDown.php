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
      $sql = "SELECT Category.Category_Code, Category.Category_Name, Category.Category_ID, Category_Start_Date, Category_End_Date
              FROM Category
              INNER JOIN Proj_Cat
              ON Category.Category_ID = Proj_Cat.Category_Category_ID
              INNER JOIN Project
              ON Proj_Cat.Project_Project_ID = Project.Project_ID
              INNER JOIN User
              ON User.Project_Project_ID = Project.Project_ID
              WHERE User_ID = '$userId'";
      $sql2 = "SELECT Category.Category_ID
              FROM Category";
      $sql4 = "SELECT Project_Project_ID
              FROM User
              WHERE User_ID = '$userId'";
      $sql3 = "SELECT User.User_First_Name, User.User_Last_Name
            FROM User
            INNER JOIN Project
            ON User.Project_Project_ID = Project.Project_ID
            WHERE Project.Project_Name = 'daniel'";
    

      $sql0 = "SELECT Task.Task_Code, Task.Task_Name, Category.Category_ID, Task.Task_ID, Task.Task_Start_Date, Task.Task_End_Date, Task.Task_Budget
          FROM Task
          INNER JOIN Category
          ON Task.Category_Category_ID = Category.Category_ID";

      $records = mysqli_query($con, $sql);
      $records2 = mysqli_query($con, $sql2);
      $records3 = mysqli_query($con, $sql3);
      $records0 = mysqli_query($con, $sql0);
      $records4 = mysqli_query($con, $sql4);

  ?>

  <!DOCTYPE html>
  <html>
  <head>

    <style>
      span {
        float: right;

      }
      #category_row{
        background-color: gray;
      }
      
      #task_row{
        background-color: skyblue;
      }
    </style>
      <title>
          Work Breakdown Structure
      </title>

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>   
      <script type = "text/javascript">

/*        $(document).ready(function () {
          var counter = 1;
          $("#add_row_category").click(function () {
              new_elem = $("#template").clone().appendTo("#category_div").show().attr("id", "addr" + counter);
              counter += 1;
          });
          });*/

    </script>
    <script>
      $(function() {
      // HTML template of a row
      var html = '<tr><td><input type = "text" placeholder="Task Code" name = "taskCode[]"></td><td><input type = "text" placeholder="Task Name" name = "taskName[]"></td><td><input type = "text" style = "display:none" ></td><td><input type = "text" style = "display:none" ></td><td><input type = "text"></td><td> <input type ="text"></td><td> <input type ="text"></td></tr>';

      $('#myTable').delegate('button.add_row_task', 'click', function() {
          var row = $(this).closest('tr'); // get the parent row of the clicked button
          $(html).insertAfter(row); // insert content
      });
  });
    </script>  

    <script>
      //template for Editing category
      $(function() {
      // HTML template of a row
      var html = '<tr><td><input type = "text" placeholder="New Category Code" name = "newCategoryCode"></td><td><input type = "text" placeholder="New Category Name" name = "newCategoryName"></td></tr>';

      $('#myTable').delegate('button.edit_category', 'click', function() {
          var row = $(this).closest('tr'); // get the parent row of the clicked button
          $(html).insertAfter(row); // insert content
      });
  });
    </script>  

    <script>
      $(function() {
      // HTML template of a row
      var html = '<tr><td><input type = "text" placeholder="New Task Code" name = "newCategoryCode"></td><td><input type = "text" placeholder="New Task Name" name = "newCategoryName"></td></tr>';

      $('#myTable').delegate('button.edit_task', 'click', function() {
          var row = $(this).closest('tr'); // get the parent row of the clicked button
          $(html).insertAfter(row); // insert content
      });
  });
    </script>  

    <script>
      $(function() {

      $('#myTable').delegate('button.delete_task', 'click', function() {
          var row = $(this).closest('tr'); // get the parent row of the clicked button
          row.remove(); // delete whole row
      });
  });
    </script>  

     <script>
      $(function() {

        var html = '<tr><td><input type = "text" placeholder="New Category Code" name = "catCode[]"></td><td><input type = "text" placeholder="New Category Name" name = "catName[]"></td></tr>';

      $('#category_div').delegate('button.add_row_category', 'click', function() {
          var row = $(this).closest('div'); // get the parent row of the clicked button
          $(html).insertAfter(row); 
      });
  });
    </script>  

  </head>
  <body>
  <span><a href="pm_home.php">Go Back to Home</a></span>
 <form action="workBreakDown.php" method="post">
    <div id = "category_div">
 
    <button type="button" name="add_cat" class = "add_row_category"> Add Category</button>
      <input type = "submit" name = "add_new_category" value= "Create">
    </form>
    </div>

      <table id = "myTable">
          <tr id = "template" style = "display:none">
            <td><input type = "text" placeholder="Category Code" name = "catCode[]"></td>
            <td><input type = "text" placeholder="Category Name" name = "catName[]"> </td>
            <td><input type = "text" style = "display:none" ></td>
            <td><input type = "text" style = "display:none"></td>
            <td> <input type ="text" style = "display:none"></td>
          </tr>

          <tr>

              <th>
                  Code
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
                  Budget
              </th>
              <th>
              </th>
          </tr>
          <?php
          //	ini_set ('display_errors', '1');
          //	error_reporting(E_ALL);

              $j = 0;
              while($wt = mysqli_fetch_assoc($records)){
          ?>

          <tr id = "category_row">
            <form method = "post" action = "">
            <td> <input type = "text" name= "catCode1" value = "<?php echo $wt['Category_Code'] ?>"></td>
            <td> <input type = "text" name = "catName1" value = "<?php echo $wt['Category_Name'] ?>"> </td>
            

              <td> <input type = "text" name = "assignee[]" style= "display: none"> </td>
              <td> <?php echo $wt['Category_Start_Date'] ?> </td>
              <td> <?php echo $wt['Category_End_Date'] ?> </td>
              <td> <input type = "number" name="budget[]"style = "display: none"></td>
              <td> 
              <input type = "hidden" name = "catID" value = "<?php echo $wt['Category_ID']; ?>">
                <input type = "submit" name = "editNow" value = Save>
              </form>
              <form method = "post" action = "">
               <input type="hidden" name="delete_category" value="<?php echo $wt['Category_ID']; ?>">
               <input type = "submit" name = "delCategory" value = "Del">
                </form>


               <a href="addTask.php?idCat= <?php echo $wt['Category_ID'] ?> "> Add Task </a>          
            </td>   
              <?php
              //	if (isset($_POST['budget']) && isset($_POST['SAVE'])){
                      //$start = "2019-05-30";
              //		$budget = $_POST['budget'][$j];
              //		$sql5 = "UPDATE Category SET Category_Start_Date = '$end' WHERE Category_Code = 1000"; 

              //		if(mysqli_query($con, $sql4)){ 
              //			echo "Record was updated successfully."; 
              //		} else { 
              //			echo "ERROR: Could not able to execute $sql. " . mysqli_error($con); 
              //		}
              //	}
              ?>
          </tr>
          <?php
                $k = 0;
              while($wt2 = mysqli_fetch_assoc($records0)){
                  if($wt['Category_ID'] == $wt2['Category_ID']) {
                    $taskID = $wt2['Task_ID'];
          ?>

              <tr id = "task_row">
                <form method = "post" action = "">
                <td> <input type = "text" name = "taskCode" value =" <?php echo $wt2['Task_Code']; ?>"></td>
                <td> <input type = "text" name = "taskName" value =" <?php echo $wt2['Task_Name']; ?> "></td> 
                
              <td>
                <?php 
                    $assigned = "SELECT User_User_ID, User_First_Name, User_Last_Name
                                  FROM Task
                                  INNER JOIN User
                                  ON Task.User_User_ID = User.User_ID
                                  WHERE Task_ID = '$taskID'";
                    $assignedResult = mysqli_query($con, $assigned);
                    while($res = mysqli_fetch_assoc($assignedResult)){
                      echo $res['User_First_Name']. " ". $res['User_Last_Name'];
                    }
                    ?>
                  </br>
              <label>	
              </label>
              <select name = "assignee">
                  <?php
                      $i = 0;
                      while($wt4 = mysqli_fetch_assoc($records4)){
                        $projectID = $wt4['Project_Project_ID'];
                        
                        $sqlAssignee = "SELECT User_First_Name, User_Last_Name, User_ID
                                        FROM User
                                        WHERE Project_Project_ID = '$projectID'";
                        $assigneeRun = mysqli_query($con, $sqlAssignee);
                      while($wt3 = mysqli_fetch_assoc($assigneeRun)){
                  ?>
                  
                  <option value = "<?php echo $wt3['User_ID']?>"><?php echo $wt3['User_First_Name']." ".$wt3['User_Last_Name'] ?></option>
                
                  <?php
                      }
                        mysqli_data_seek($assigneeRun, 0);

                      }
                    mysqli_data_seek($records4, 0);

                  ?>
                
                </select> </td>
              <td> <input type = "date" name = "taskStartDate" value = "<?php echo $wt2['Task_Start_Date']; ?>"> </td>
              <td> <input type = "date" name = "taskEndDate" value = "<?php echo $wt2['Task_End_Date']; ?>"></td>
              <td> <input type = "number" name="taskBudget" value = "<?php echo $wt2['Task_Budget']; ?>"></td>
               <td> 
                 <input type="submit" name="edit" class = "edit_task" value = "Save">
              <input type = "hidden" name = "taskID" value = "<?php echo $wt2['Task_ID']; ?>"></form>
                <form method = "post" action = ""><input type="hidden" name="delete_task" value="<?php echo $wt2['Task_ID']; ?>"><input type = "submit" name = "delTask" class = "delete_task" value = "Del"></form>
                  
              
              </td>
              
          </tr>
          <?php
                  }
              }
              mysqli_data_seek($records0,0);
                              
              }

              //inserting new category
              if (isset($_POST['catCode']) && isset($_POST['catName'])){
                $catCode = $_POST['catCode'];
                $catName = $_POST['catName'];
                
                for ($i = 0 , $count = count($_POST['catCode']); $i < $count; $i++){
                

                $sqlAddCat = "INSERT INTO Category (Category_Name, Category_Start_Date, Category_End_Date, Category_Code) VALUES ('$catName[$i]', '2019-05-11', '2019-06-01', '$catCode[$i]')";
                                  
                $addCat = mysqli_query($con, $sqlAddCat);
                  
                $getCatID = "SELECT Category_ID FROM Category 
                            WHERE Category_Name = '$catName[$i]' AND Category_Code = '$catCode[$i]'";
                $runCatID = mysqli_query($con, $getCatID);
                
                  while ($result = mysqli_fetch_assoc($runCatID)){
                    while($wt4 = mysqli_fetch_assoc($records4)){
                    $projectID = $wt4['Project_Project_ID'];
                     
                 
                    $catID = $result['Category_ID'];
                      

                      
                    $sqlAddProjCat = "INSERT INTO Proj_Cat (Project_Project_ID, Category_Category_ID) VALUES ('$projectID', '$catID')";
                    
                    mysqli_query($con, $sqlAddProjCat);
                    }
                    mysqli_data_seek($records4,0);
                  }
                  mysqli_data_seek($runCatID,0);
                  
                

                }
              
                if ($addCat){
                  echo "<meta http-equiv=\"refresh\" content = \"0; URL = workBreakDown.php\">";
                }else{
                  echo 'not inserted';
                }
              
              }


              //deleting task
              if (isset($_POST['delTask'])){
                $del_id = strip_tags($_POST['delete_task']);
                $deleteTimesheet = mysqli_query($con, "DELETE FROM Weekly_Timesheet WHERE Task_Task_ID = $del_id");
                $deleteTask1 = mysqli_query($con, "DELETE FROM Task WHERE Task_ID = $del_id");

                if ($deleteTask1){
                  echo "<meta http-equiv=\"refresh\" content = \"0; URL = workBreakDown.php\">";
                }
                else{
                  echo "not deleted";
                }
              }

              //deleting category
              if (isset($_POST['delCategory'])){
                $del_id = strip_tags($_POST['delete_category']);
                $selectTask = "SELECT Task_ID FROM Task WHERE Category_Category_ID = $del_id";
                $recordTask = mysqli_query($con, $selectTask);

                while ($result = mysqli_fetch_assoc($recordTask)){
                  $taskid = $result['Task_ID'];
                 mysqli_query($con, "DELETE FROM Weekly_Timesheet WHERE Task_Task_ID = $taskid");
                }
                $deleteProjCat = mysqli_query($con, "DELETE FROM Proj_Cat WHERE Category_Category_ID = $del_id");
                $deleteTask = mysqli_query($con, "DELETE FROM Task WHERE Category_Category_ID = $del_id");
                $deleteCategory1 = mysqli_query($con, "DELETE FROM Category WHERE Category_ID = $del_id");


                if ($deleteCategory1){
                  echo "<meta http-equiv=\"refresh\" content = \"0; URL = workBreakDown.php\">";
                }
                else{
                  echo "not deleted";
                }
              }


/*              if (isset($_POST['newCategoryCode']) && isset($_POST['newCategoryName'])){
                 $del_id = strip_tags($_POST['delete_category']);
                $newCategoryName = $_POST['newCategoryName'];
                $newCategoryCode = $_POST['newCategoryCode'];

                $changeCategory = mysqli_query($con, "UPDATE Category SET Category_Name = '$newCategoryName', Category_Code = '$newCategoryCode' WHERE Category_ID = $del_id");

                if ($changeCategory){
                  //echo "<meta http-equiv=\"refresh\" content = \"0; URL = workBreakDown1.php\">";
                }
                else{
                  echo "not edited";
                }
              }*/

              // to edit category
              if (isset($_POST['catName1']) && isset($_POST['catCode1'])){
                    $del_id = strip_tags($_POST['catID']);
                    $catID = $_POST['catID'];

                    $catName = $_POST['catName1'];
                    $catCode = $_POST['catCode1'];

                    $changeCategory = mysqli_query($con, "UPDATE Category SET Category_Name = '$catName', Category_Code = '$catCode' WHERE Category_ID = '$del_id'");

                    if ($changeCategory){
                      echo "<meta http-equiv=\"refresh\" content = \"0; URL = workBreakDown.php\">";
                    }
                    else{
                      echo "not edited";
                    }
                }
        
                // to edit task
                if (isset($_POST['taskCode']) && isset($_POST['taskName']) && isset($_POST['taskStartDate']) && isset($_POST['taskEndDate']) && isset($_POST['taskBudget'])){
                  echo "hi";
                    $del_id = strip_tags($_POST['taskID']);

                    $taskCode = $_POST['taskCode'];
                    $taskName = $_POST['taskName'];
                    $taskStart = $_POST['taskStartDate'];
                    $taskEnd = $_POST['taskEndDate'];
                    $taskBudget = $_POST['taskBudget'];   
                    $assignee = $_POST['assignee'];

                    $changeTask = mysqli_query($con, "UPDATE Task SET Task_Name = '$taskName', Task_Code = '$taskCode', Task_Start_Date = '$taskStart', Task_End_Date = '$taskEnd', Task_Budget = '$taskBudget', User_User_ID = '$assignee' WHERE Task_ID = '$del_id'");

                    if ($changeTask){
                      echo "<meta http-equiv=\"refresh\" content = \"0; URL = workBreakDown.php\">";
                    }
                    else{
                      echo "not edited";
                    }
      }

              
        mysqli_close($con);

          ?>  
      </table>

  </body>
  </html>