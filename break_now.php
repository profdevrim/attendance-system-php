<?php
date_default_timezone_set('Asia/Karachi');

session_start();

if(isset($_SESSION['user_id'])){
	
}else{
	echo '<script>window.location = "login.php";</script>';
}

require_once('connection.php');


//$SQL = "select * from attendance where emp='".$_SESSION['user_id']."' and time_out=''";
$SQL = "select * from attandance_master where emp='".$_SESSION['user_id']."' and master_status='Start'";
$query = mysqli_query($con, $SQL);
$rows = mysqli_fetch_array($query);
$master_id = $rows['master_id'];

$SQL = "SELECT max(recindex) as max_rec FROM `attendance` WHERE master_id=".$master_id;
$query = mysqli_query($con, $SQL);
$rows = mysqli_fetch_array($query);
$max_rec = $rows['max_rec'];



$SQL_Insert = "INSERT INTO `attendance`(`master_id`, `attendancedate`, `time__in`, `time_in`, status) VALUES ( 
	'".$master_id."',
	'".date('Y-m-d')."',
	'".date('Y-m-d h:i:s')."',
	'".date('h:i')."',
	'".$_GET['Break_Type']."')";
mysqli_query($con, $SQL_Insert);


$SQL_UPDATE = "Update attendance SET time_out='".date('h:i')."', time__out='".date('Y-m-d h:i:s')."' WHERE recindex='".$max_rec."'";
mysqli_query($con, $SQL_UPDATE);

echo '<script>window.location="index.php"</script>';  
?>