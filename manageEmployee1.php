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
		
	$sql = "SELECT * FROM User WHERE Active = 1";
	$archivedUser = "SELECT * FROM User WHERE Active = 0";
	$records = mysqli_query($con, $sql);
	$records1 = mysqli_query($con, $sql);
	$records2 = mysqli_query($con, $archivedUser);
	
	
?>

<html>

<head>
<style>
span {
  float: right;

}
</style>
<title> Manage Employee </title>

</head>

<body>

<span><a href="home.html">Go Back to Home</a></span>


<tr>
<td><form name="form1" method="post" action="">
<table width="400" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
 <tr>
<td bgcolor="#FFFFFF">&nbsp;</td>
<td colspan="3" bgcolor="#FFFFFF"><strong>Active</strong> </td>
<table width = "600" border ="1" cellpadding = "1" cellspacing = "1">

<tr>
<th> # </th>
<th> User ID</th>
<th> First name</th>
<th> Last name</th>
<th> Email </th>
<th> User Type</th>
</tr>

<?php
ini_set ('display_errors', '1');
error_reporting(E_ALL);

	while($user = mysqli_fetch_assoc($records1)){
?>

<tr>
<td align="center" ><input name="checkbox1[]" type="checkbox" value="<?php echo $user['User_ID']; ?>"></td>
<td><?php echo $user['User_ID']; ?></td>
<td><?php echo $user['User_First_Name']; ?></td>
<td><?php echo $user['User_Last_Name']; ?></td>
<td><?php echo $user['User_Email']; ?></td>
<td><?php echo $user['User_Type_User_Type_ID']; ?></td>
</tr>

<?php
	}
	?>
<tr>
<td colspan="4" align="center"><input name="delete" type="submit" value="Deactivate"></td>
</tr>

<?php

// Check if delete button active, start this 

if (isset($_POST['delete']) && isset($_POST['checkbox1'])) {
    foreach($_POST['checkbox1'] as $del_id){
        $del_id = (int)$del_id;
        $del = "UPDATE User SET Active = 0 WHERE User_ID = $del_id"; 
        $deactivate = mysqli_query($con, $del);
    }


if ($deactivate){
        echo "<meta http-equiv=\"refresh\" content = \"0; URL = manageEmployee1.php\">";
}else{
	echo "cant delete, the user still have a project active";
}
}
?>

</table>
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
<th> User ID</th>
<th> First name</th>
<th> Last name</th>
<th> Email </th>
<th> User Type</th>
</tr>

<?php
ini_set ('display_errors', '1');
error_reporting(E_ALL);

	while($user = mysqli_fetch_assoc($records2)){
?>

<tr>
<td align="center" ><input name="checkbox[]" type="checkbox" value="<?php echo $user['User_ID']; ?>"></td>
<td><?php echo $user['User_ID']; ?></td>
<td><?php echo $user['User_First_Name']; ?></td>
<td><?php echo $user['User_Last_Name']; ?></td>
<td><?php echo $user['User_Email']; ?></td>
<td><?php echo $user['User_Type_User_Type_ID']; ?></td>
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
        $del = "UPDATE User SET Active = 1 WHERE User_ID = $del_id"; 
        $activate = mysqli_query($con, $del);
    }


if ($activate){
        echo "<meta http-equiv=\"refresh\" content = \"0; URL = manageEmployee1.php\">";
}else{
	echo "cant delete, the user still have a project active";
}
}
?>



  
</body>
</html>

 