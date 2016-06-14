<?php
date_default_timezone_set('Asia/Karachi');

require_once('connection.php');


$SQL_Insert = "INSERT INTO `employee`(`name`, `father`, `cellno`, `nic`, `doj`, `username`, `password`, 
`macaddress`) VALUES ('"
.$_POST['name']."','"
.$_POST['father']."','"
.$_POST['cellno']."','"
.$_POST['nic']."','"
.$_POST['doj']."','"
.$_POST['username']."','"
.$_POST['password']."','"
.$_POST['macaddress']."')";

$query = mysqli_query($con, $SQL_Insert);
	
?>
Thank For Register...
<br>
<br>
<a href="index.php">Click Here for Login</a>