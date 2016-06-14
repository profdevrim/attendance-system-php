<?php
date_default_timezone_set('Asia/Karachi');

session_start();

if(isset($_SESSION['user_id'])){
	
}else{
	echo '<script>window.location = "login.php";</script>';
}

require_once('connection.php');
include('header.php'); 
?>

			
			<!-- start: Content -->
			<div id="content" class="span10">
			
			
			<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="index.html">Home</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li><a href="#">Day Close</a></li>
			</ul>

			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon file"></i><span class="break"></span>Day Close</h2>
						<?php /*
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>
						*/
						?>
					</div>
					<div class="box-content">
						<a class="quick-button span2" onclick="myFunction()" >
							<i class="icon-user"></i>
							<p><?php
//$SQL_Check = "select time__in, time_out from attendance where emp='".$_SESSION['user_id']."' and time_out = ''";
$SQL_Check = "select time__in from attandance_master 
inner join attendance on attandance_master.master_id = attendance.master_id
where emp='".$_SESSION['user_id']."' and status = 'Start'";
$query = mysqli_query($con, $SQL_Check);

if(mysqli_num_rows($query) <> 0 ){ 

	$rows = mysqli_fetch_array($query);							

	$to_time = date('Y-m-d H:i:s', strtotime($rows['time__in']));
	$from_time = date('Y-m-d h:i:s');
	
	$datetime1 = new DateTime($from_time);
	$datetime2 = new DateTime($to_time);
	
	$interval = $datetime1->diff($datetime2);
	$elapsed = $interval->format('%h Hr:%i Min');
	ECHO "Office Hour = <br>" . $elapsed;
	?>

<script>

function myFunction() {
    x = confirm("Do you want start day!");
	if(x === true){
		window.location="day_start_now.php";
	}
}
</script>
<?php
}else{
	echo "Timer is Not Start";
}
?>
<script>

function myFunction() {
    x = confirm("Do You want Close day!");
	if(x === true){
		window.location="day_close_now.php";
	}
}
</script>


</p>
						</a>
						
						<br><br><br><br><br><br><br><br><br>
						<strong style="color:Red;">Click on Timer, if you want to close Day</strong>
					</div>
				</div><!--/span-->		
			</div><!--/row-->

	</div><!--/.fluid-container-->
	
			<!-- end: Content -->
		</div><!--/#content.span10-->
		</div><!--/fluid-row-->
		
	
	<div class="clearfix"></div>
	
	<footer>

		<p>
			<span style="text-align:left;float:left">&copy; 2016 <a href="#" alt="Encoder ">Encoder </a></span>
			
		</p>

	</footer>
	
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
