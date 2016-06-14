<?php
require_once('connection.php');

$dataArray='';
if(!empty($_REQUEST['dataArray'])){
	$dataArrayDecode = base64_decode($_REQUEST['dataArray']);
	$dataArray = explode(',',$dataArrayDecode);
	print_r($dataArray);
}
$login_btn='';
if(!empty($dataArray[0])){
		$login_btn= $dataArray[0];
}
	
// if(isset($_REQUEST['login_btn']) || !empty($login_btn)){
	if(!empty($dataArray[1]) && !empty($dataArray[2])){
		$_REQUEST['username'] = $dataArray[1];
		$_REQUEST['password'] = $dataArray[2];
	}
	
	$SQL = "select * from employee where username='".$_REQUEST['username']."' and password='".$_REQUEST['password']."'";
	$query = mysqli_query($con, $SQL);
	if(mysqli_num_rows($query) > 0 ){ 
		$rows = mysqli_fetch_array($query);
		check_time_close($con);
		session_start();
		$_SESSION['user_id'] = $_REQUEST['username'];
		$_SESSION['role'] = $rows['role'];
		//echo '<script>window.location="https://encoderz.com/attandence/index.php?mac='.$macaddress.'"</script>';
		echo '<script>window.location="index.php?mac='.$macaddress.'"</script>';		
	}


function check_time_close($con)
{
	$Count_Hr  = 0;
	/// Loop for all User
	$SQL_EMP = "select name, username from employee where role=0";
	$query_EMP = mysqli_query($con, $SQL_EMP);
	while($rows_EMP = mysqli_fetch_array($query_EMP)){
		$SQL = "select IFNULL(max(master_id), 0) as master_id from attandance_master where emp='".$rows_EMP['username']."' and master_status='Start'";
		$query = mysqli_query($con, $SQL);
		$rows = mysqli_fetch_array($query);
		$master_id = $rows['master_id'];
		if($master_id <> 0){
			
			
			// select time__in, TIMESTAMPDIFF(HOUR, '2016-06-11 10:00:22','2016-06-12 10:00:22') from attendance WHERE master_id=19
			$_SQL_Check = "select sum(TIMESTAMPDIFF(HOUR, time__in, now() ))  as Count_Hr from attendance WHERE master_id=".$master_id;
			$_query = mysqli_query($con, $_SQL_Check);
			$_rows = mysqli_fetch_array($_query);
			$Count_HR  = $_rows['Count_Hr'];
			
			if($Count_HR > '20'){
				
				$SQL_Check = "select time__in, DATE_ADD(time__in, INTERVAL 8 HOUR) as System_Time_Out  from attendance WHERE master_id=".$master_id;
				$query = mysqli_query($con, $SQL_Check);
				$rows = mysqli_fetch_array($query);
				$System_Time_Out = $rows['System_Time_Out'];
				
				$SQL_UPDATE = "Update attandance_master SET master_status='Close' WHERE master_id='".$master_id."'";
				mysqli_query($con, $SQL_UPDATE);

				
			$SQL = "SELECT max(recindex) as max_rec FROM `attendance` WHERE master_id=".$master_id;
			$query = mysqli_query($con, $SQL);
			$rows = mysqli_fetch_array($query);
			$max_rec = $rows['max_rec'];
			
			
				$SQL_UPDATE = "Update attendance SET time_out='".date('h:i', strtotime($System_Time_Out))."', time__out='".$System_Time_Out."', status='Close' WHERE recindex='".$max_rec."'";
				mysqli_query($con, $SQL_UPDATE);

			} // Count Hr 
		} /// Master ID Is Not 0
	} //// Loop End of User LIST
	
}	
//}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	
	<!-- start: Meta -->
	<meta charset="utf-8">
	<title>Attendacne System Login</title>
	<meta name="description" content="Bootstrap Metro Dashboard">
	<meta name="author" content="Dennis Ji">
	<meta name="keyword" content="Metro, Metro UI, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
	<!-- end: Meta -->
	
	<!-- start: Mobile Specific -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- end: Mobile Specific -->
	
	<!-- start: CSS -->
	<link id="bootstrap-style" href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
	<link id="base-style" href="css/style.css" rel="stylesheet">
	<link id="base-style-responsive" href="css/style-responsive.css" rel="stylesheet">
	<!-- end: CSS -->
	

	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<link id="ie-style" href="css/ie.css" rel="stylesheet">
	<![endif]-->
	
	<!--[if IE 9]>
		<link id="ie9style" href="css/ie9.css" rel="stylesheet">
	<![endif]-->
		
	<!-- start: Favicon -->
	<link rel="shortcut icon" href="img/favicon.ico">
	<!-- end: Favicon -->
	
		<style type="text/css">
			body { background: url(img/bg-login.jpg) !important; }
		</style>
		
		
		
</head>

<body>
		<div class="container-fluid-full">
		<div class="row-fluid">
					
			<div class="row-fluid">
				<div class="login-box">
					<div class="icons">
						<a href="index.php"><i class="halflings-icon home"></i></a>
						<a href="#"><i class="halflings-icon cog"></i></a>
					</div>
					<h2>Login to your account</h2>
					<form class="form-horizontal" method="post">
						<fieldset>
							
							<div class="input-prepend" title="Username">
								<span class="add-on"><i class="halflings-icon user"></i></span>
								<input class="input-large span10" name="username" id="username" type="text" placeholder="type username"/>
							</div>
							<div class="clearfix"></div>

							<div class="input-prepend" title="Password">
								<span class="add-on"><i class="halflings-icon lock"></i></span>
								<input class="input-large span10" name="password" id="password" type="password" placeholder="type password"/>
							</div>
							<div class="clearfix"></div>
							
							

							<div class="button-login">	
								<button type="submit" name="login_btn" class="btn btn-primary">Login</button>
								<a href='register_emp.php' class="btn btn-primary">Register Employee</a>
							</div>
							<div class="clearfix"></div>
					</form>
					<hr>
					
				</div><!--/span-->
			</div><!--/row-->
			

	</div><!--/.fluid-container-->
	
		</div><!--/fluid-row-->
	
	<!-- start: JavaScript-->

		<script src="js/jquery-1.9.1.min.js"></script>
	<script src="js/jquery-migrate-1.0.0.min.js"></script>
	
		<script src="js/jquery-ui-1.10.0.custom.min.js"></script>
	
		<script src="js/jquery.ui.touch-punch.js"></script>
	
		<script src="js/modernizr.js"></script>
	
		<script src="js/bootstrap.min.js"></script>
	
		<script src="js/jquery.cookie.js"></script>
	
		<script src='js/fullcalendar.min.js'></script>
	
		<script src='js/jquery.dataTables.min.js'></script>

		<script src="js/excanvas.js"></script>
	<script src="js/jquery.flot.js"></script>
	<script src="js/jquery.flot.pie.js"></script>
	<script src="js/jquery.flot.stack.js"></script>
	<script src="js/jquery.flot.resize.min.js"></script>
	
		<script src="js/jquery.chosen.min.js"></script>
	
		<script src="js/jquery.uniform.min.js"></script>
		
		<script src="js/jquery.cleditor.min.js"></script>
	
		<script src="js/jquery.noty.js"></script>
	
		<script src="js/jquery.elfinder.min.js"></script>
	
		<script src="js/jquery.raty.min.js"></script>
	
		<script src="js/jquery.iphone.toggle.js"></script>
	
		<script src="js/jquery.uploadify-3.1.min.js"></script>
	
		<script src="js/jquery.gritter.min.js"></script>
	
		<script src="js/jquery.imagesloaded.js"></script>
	
		<script src="js/jquery.masonry.min.js"></script>
	
		<script src="js/jquery.knob.modified.js"></script>
	
		<script src="js/jquery.sparkline.min.js"></script>
	
		<script src="js/counter.js"></script>
	
		<script src="js/retina.js"></script>

		<script src="js/custom.js"></script>
	<!-- end: JavaScript-->
	
</body>
</html>
