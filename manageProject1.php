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
		
	$sql = "SELECT * FROM Project WHERE Active = 1";
	$archivedUser = "SELECT * FROM Project WHERE Active = 0";

    

	$records1 = mysqli_query($con, $sql);
	$records2 = mysqli_query($con, $archivedUser);

	
	
?>

<html>

<head>
<style>
  div{
    float:right;
    color:blue;
  }

  span {
  float: right;

}
</style>
<title> Manage Project </title>

</head>

<body>

<span><a href="home.html">Go Back to Home</a></span>

<div name = "information"> </div>


<tr>
<td><form name="form1" method="post" action="">
<table width="400" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
 <tr>
<td bgcolor="#FFFFFF">&nbsp;</td>
<td colspan="3" bgcolor="#FFFFFF"><strong>Active</strong> </td>
<table width = "600" border ="1" cellpadding = "1" cellspacing = "1">

<tr>
<th> # </th>
<th> Project name</th>

</tr>

<?php
ini_set ('display_errors', '1');
error_reporting(E_ALL);

	while($user = mysqli_fetch_assoc($records1)){
?>

<tr>
<td align="center" ><input name="checkbox1[]" type="checkbox" value="<?php echo $user['Project_ID']; ?>"></td>
<td><?php echo $user['Project_Name']; ?></td>

</tr>

<?php
	}
	?>
<tr>
<td colspan="4" align="center"><input name="delete" type="submit" value="Deactivate"></td>
<td colspan="4" align="center"><input name="view" type="submit" value="View"></td>
</tr>

<?php

// Check if delete button active, start this 

if (isset($_POST['delete']) && isset($_POST['checkbox1'])) {
    foreach($_POST['checkbox1'] as $del_id){
        $del_id = (int)$del_id;
        $del = "UPDATE Project SET Active = 0 WHERE Project_ID = $del_id"; 
        $deactivate = mysqli_query($con, $del);
    }


if ($deactivate){
        echo "<meta http-equiv=\"refresh\" content = \"0; URL = manageProject1.php\">";
}else{
	echo "cant delete, the user still have a project active";
}
}
  
  
?>

</table>
   <?php
   if (isset($_POST['view']) && isset($_POST['checkbox1'])) {
    foreach($_POST['checkbox1'] as $del_id){
      $del_id = (int)$del_id;
      
      $sqlShow = "SELECT * FROM Project p WHERE Project_ID = $del_id";
      $sqlMembers = "SELECT User.User_First_Name, User.User_Last_Name
            FROM User
            INNER JOIN Project
            ON User.Project_Project_ID = Project.Project_ID
            WHERE Project.Project_ID = $del_id";
      
      $show = mysqli_query($con, $sqlShow);
      $showMember = mysqli_query($con, $sqlMembers);
      
      echo "<div>";
      while ($projectInfo = mysqli_fetch_assoc($show)){
        echo "Project ID:".$projectInfo['Project_ID']. "<br>";
        echo "Project Name: ". $projectInfo['Project_Name']. "<br>";
        echo "Project Description: ". $projectInfo['Project_Desc']. "<br>";
        echo "Project Start Date: ". $projectInfo['Project_Start_Date']. "<br>";
        echo "Project End Date: ". $projectInfo['Project_End_Date']. "<br>";
        
      }
      
      echo "Members: ";
      echo "<br>";
      while ($members = mysqli_fetch_assoc($showMember)){
        echo $members['User_First_Name']. " ". $members['User_Last_Name']. "<br>";
        
      }
      echo "</div>";
    }
  }
   
   ?>
</form>
</td>
</tr>

<tr>
<td><form name="form2" method="post" action="">
<table width="400" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
 <tr>
<td bgcolor="#FFFFFF">&nbsp;</td>
<td colspan="3" bgcolor="#FFFFFF"><strong>Archived</strong> </td>
<table width = "600" border ="1" cellpadding = "1" cellspacing = "1">

<tr>
<th> # </th>
<th> Project name</th>
</tr>

<?php
ini_set ('display_errors', '1');
error_reporting(E_ALL);

	while($user = mysqli_fetch_assoc($records2)){
?>

<tr>
<td align="center" ><input name="checkbox[]" type="checkbox" value="<?php echo $user['Project_ID']; ?>"></td>
<td><?php echo $user['Project_Name']; ?></td>
</tr>

<?php
	}
	?>
<tr>
<td colspan="4" align="center"><input name="delete" type="submit" value="Activate"></td>
</tr>

<?php

// Check if delete button active, start this 

if (isset($_POST['delete']) && isset($_POST['checkbox'])) {
    foreach($_POST['checkbox'] as $del_id){
        $del_id = (int)$del_id;
        $del = "UPDATE Project SET Active = 1 WHERE Project_ID = $del_id"; 
        $activate = mysqli_query($con, $del);
    }


if ($activate){
        echo "<meta http-equiv=\"refresh\" content = \"0; URL = manageProject.php\">";
}else{
	echo "cant delete, the user still have a project active";
}
}
?>




</body>
</html>