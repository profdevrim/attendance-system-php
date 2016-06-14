<?php
date_default_timezone_set('Asia/Karachi');

session_start();

if(isset($_SESSION['user_id'])){
	
}else{
	echo '<script>window.location = "login.php";</script>';
}

require_once('connection.php');

$SQL_Check = "select * from attandance_master where emp='".$_SESSION['user_id']."' and master_status='Close' and entry_date='".date('Y-m-d')."'";
$query = mysqli_query($con, $SQL_Check);
if(mysqli_num_rows($query) == 0 ){ 
	
	$SQL_Insert_master = "INSERT INTO `attandance_master`(`emp`, `master_status`, `entry_date`) VALUES (
	'".$_SESSION['user_id']."',
	'Start',
	'".date('Y-m-d')."')";
	$_query = mysqli_query($con, $SQL_Insert_master);
	$master_id = mysqli_insert_id($con);
	
	$SQL_Insert = "INSERT INTO `attendance`(`master_id`, `attendancedate`, `time__in`, `time_in`, status) VALUES ( 
	'".$master_id."',
	'".date('Y-m-d')."',
	'".date('Y-m-d H:i:s')."',
	'".date('h:i')."',
	'Start')";
	
	mysqli_query($con, $SQL_Insert);
}

/*
$SQL_Check = "select * from attendance where emp='".$_SESSION['user_id']."' and time_out=''";
$query = mysqli_query($con, $SQL_Check);
if(mysqli_num_rows($query) == 0 ){ 
	
	
	$SQL_Insert = "INSERT INTO `attendance`(`emp`, `attendancedate`, `time__in`, `time_in`) VALUES ( 
	'".$_SESSION['user_id']."',
	'".date('Y-m-d')."',
	'".date('Y-m-d h:i:s')."',
	'".date('h:i')."')";
	$query = mysqli_query($con, $SQL_Insert);
}
*/
echo '<script>window.location="index.php"</script>';  
?>