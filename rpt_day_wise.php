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
				<li><a href="#">Attandence</a></li>
			</ul>
<?php if($_SESSION['role']  != 0){ ?>
			<div class="row-fluid">	
				<div class="box blue span12">
					<div class="box-header">
						<h2><i class="halflings-icon hand-top"></i><span class="break"></span>Quick Buttons</h2>
					</div>
					<div class="box-content">
<?php 
	$SQL_EMP = "select name, username from employee where role=0";
	$query_EMP = mysqli_query($con, $SQL_EMP);
	while($rows_EMP = mysqli_fetch_array($query_EMP)){ 		
		$Condition = '';				
		$SQL = "select IFNULL(max(master_id), 0) as master_id from attandance_master where emp='".$rows_EMP['username']."' and master_status='Start' ";
		$query1 = mysqli_query($con, $SQL);
		$rows = mysqli_fetch_array($query1);
		//if(mysqli_num_rows($query1) <> 0 ){
		if($rows['master_id'] <> 0){	
			$master_id = $rows['master_id'];
			$Condition = 'Start';
		}	
		if($Condition == ''){
			$SQL = "select IFNULL(max(master_id), 0) as master_id from attandance_master where emp='".$rows_EMP['username']."' and master_status='Close' ";
			$query1 = mysqli_query($con, $SQL);
			$rows = mysqli_fetch_array($query1);
			//if(mysqli_num_rows($query1) <> 0 ){
			if($rows['master_id'] <> 0){	
				$master_id = $rows['master_id'];
				$Condition = 'Close';
			}	
		}		
		?>
			
						<a class="quick-button span2" href='calendar.php?uid=<?php echo base64_decode($rows_EMP['username']); ?>'>
							<i class="icon-user"></i>
							<p><?php echo $rows_EMP['name']; ?> </p>
							<span class="notification <?php echo ($Condition == 'Start' ? 'blue' : 'red'); ?>"><?php
	if($Condition == 'Start'){
		$SQL_Check = "select time__in from attandance_master 
		inner join attendance on attandance_master.master_id = attendance.master_id
		where emp='".$rows_EMP['username']."' and attandance_master.master_id=".$master_id." and status = 'Start'";	
		$query = mysqli_query($con, $SQL_Check);
		if(mysqli_num_rows($query) <> 0 ){ 
			$rows = mysqli_fetch_array($query);							
			$to_time = date('Y-m-d H:i:s', strtotime($rows['time__in']));
			$from_time = date('Y-m-d H:i:s');
			$datetime1 = new DateTime($to_time);
			$datetime2 = new DateTime($from_time);
			$interval = $datetime1->diff($datetime2);
			$elapsed = $interval->format('%h Hr:%i Min');
			ECHO  $elapsed;		
		}		
	}else{
		$_hr = $_mint = 0;
		$SQL_Check = "select time__in, time__out from attandance_master 
		inner join attendance on attandance_master.master_id = attendance.master_id
		where emp='".$rows_EMP['username']."' and attandance_master.master_id=".$master_id." ";	
		$query = mysqli_query($con, $SQL_Check);
		if(mysqli_num_rows($query) <> 0 ){ 
			while($rows = mysqli_fetch_array($query)){	
				$to_time = date('Y-m-d H:i:s', strtotime($rows['time__in']));
				$from_time = date('Y-m-d H:i:s', strtotime($rows['time__out']));
				$datetime1 = new DateTime($from_time);
				$datetime2 = new DateTime($to_time);
				$interval = $datetime1->diff($datetime2);
				$elapsed = $interval->format('%h Hr:%i Min');
				
				$_hr = $_hr + $interval->format('%h');
				$_mint = $_mint + $interval->format('%i');
			}
			//echo $_hr .  ":" .$_mint;	
			echo round($_hr + $_mint / 60) . "Hr";
		}		
		
	}
	?>
	
						</span>
						</a>
		<?php } ?>
						
						<div class="clearfix"></div>
					</div>	
				</div><!--/span-->
				
			</div><!--/row-->
<?php }else{ ?>			
			
			<div class="row-fluid">	
				<div class="box blue span12">
					<div class="box-header">
						<h2><i class="halflings-icon hand-top"></i><span class="break"></span>Summary Report</h2>
					</div>
					
					
					<div class="box-content">
<?php 
	$SQL_EMP = "select name, username from employee where username='".$_SESSION['user_id']."'";
	$query_EMP = mysqli_query($con, $SQL_EMP);
	while($rows_EMP = mysqli_fetch_array($query_EMP)){ 		
		$Condition = '';				
		$SQL = "select IFNULL(max(master_id), 0) as master_id from attandance_master where emp='".$rows_EMP['username']."' and master_status='Start' ";
		$query1 = mysqli_query($con, $SQL);
		$rows = mysqli_fetch_array($query1);
		//if(mysqli_num_rows($query1) <> 0 ){
		if($rows['master_id'] <> 0){	
			$master_id = $rows['master_id'];
			$Condition = 'Start';
		}	
		if($Condition == ''){
			$SQL = "select IFNULL(max(master_id), 0) as master_id from attandance_master where emp='".$rows_EMP['username']."' and master_status='Close' ";
			$query1 = mysqli_query($con, $SQL);
			$rows = mysqli_fetch_array($query1);
			//if(mysqli_num_rows($query1) <> 0 ){
			if($rows['master_id'] <> 0){	
				$master_id = $rows['master_id'];
				$Condition = 'Close';
			}	
		}		
		?>
			
						<a class="quick-button span2" href='calendar.php?uid=<?php echo base64_decode($rows_EMP['username']); ?>'>
							<i class="icon-time"></i>
							<p><?php echo $rows_EMP['name']; ?> </p>
							<span class="notification <?php echo ($Condition == 'Start' ? 'blue' : 'red'); ?>"><?php
	if($Condition == 'Start'){
		$SQL_Check = "select time__in from attandance_master 
		inner join attendance on attandance_master.master_id = attendance.master_id
		where emp='".$rows_EMP['username']."' and attandance_master.master_id=".$master_id." and status = 'Start'";	
		$query = mysqli_query($con, $SQL_Check);
		if(mysqli_num_rows($query) <> 0 ){ 
			$rows = mysqli_fetch_array($query);							
			$to_time = date('Y-m-d H:i:s', strtotime($rows['time__in']));
			$from_time = date('Y-m-d H:i:s');
			$datetime1 = new DateTime($to_time);
			$datetime2 = new DateTime($from_time);
			$interval = $datetime1->diff($datetime2);
			$elapsed = $interval->format('%h Hr:%i Min');
			ECHO  $elapsed;		
		}		
	}else{
		$SQL_Check = "select time__in, time__out from attandance_master 
		inner join attendance on attandance_master.master_id = attendance.master_id
		where emp='".$rows_EMP['username']."' and attandance_master.master_id=".$master_id." ";	
		$query = mysqli_query($con, $SQL_Check);
		if(mysqli_num_rows($query) <> 0 ){ 
			$rows = mysqli_fetch_array($query);							
			$to_time = date('Y-m-d h:i:s', strtotime($rows['time__in']));
			$from_time = date('Y-m-d h:i:s', strtotime($rows['time__out']));
			$datetime1 = new DateTime($from_time);
			$datetime2 = new DateTime($to_time);
			$interval = $datetime1->diff($datetime2);
			$elapsed = $interval->format('%h Hr:%i Min');
			ECHO  $elapsed;		
		}		
	}
	?>
						</span>
						</a>
		<?php } ?>
						
						
<?php 
	$SQL_EMP = "select name, username from employee where username='".$_SESSION['user_id']."'";
	$query_EMP = mysqli_query($con, $SQL_EMP);
	while($rows_EMP = mysqli_fetch_array($query_EMP)){ 		
		$Condition = '';				
		$SQL = "select IFNULL(max(master_id), 0) as master_id from attandance_master where emp='".$rows_EMP['username']."' and master_status='Start' ";
		$query1 = mysqli_query($con, $SQL);
		$rows = mysqli_fetch_array($query1);
		//if(mysqli_num_rows($query1) <> 0 ){
		if($rows['master_id'] <> 0){	
			$master_id = $rows['master_id'];
			$Condition = 'Start';
		}	
		if($Condition == ''){
			$SQL = "select IFNULL(max(master_id), 0) as master_id from attandance_master where emp='".$rows_EMP['username']."' and master_status='Close' ";
			$query1 = mysqli_query($con, $SQL);
			$rows = mysqli_fetch_array($query1);
			//if(mysqli_num_rows($query1) <> 0 ){
			if($rows['master_id'] <> 0){	
				$master_id = $rows['master_id'];
				$Condition = 'Close';
			}	
		}		
		?>

		<?php } ?>
		
						
						<div class="clearfix"></div>
					</div>	
					
					
				</div><!--/span-->
				
			</div><!--/row-->
			
<?php } ?>			
			<div class="row-fluid ">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon file"></i><span class="break"></span>Attandence Report : <?php echo date('d/m/Y', strtotime($_GET['date'])); ?></h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th>Username</th>
								  <th>Date</th>
								  <th>Check In</th>
								  <th>Check Out</th>
								  <th>Hr</th>
								  <th>Status</th>
							  </tr>
						  </thead>   
						  <tbody>
<?php
	if($_SESSION['role']  == 0){
		$SQL = "select name, entry_date, time__in, time__out, status from attandance_master 
		inner join attendance on attandance_master.master_id = attendance.master_id 
		inner join employee on employee.username = attandance_master.emp where username='".$_SESSION['user_id']."' AND entry_date='".date('Y-m-d', strtotime($_GET['date']))."'";
	}else{
		$SQL = "select name, entry_date, time__in, time__out, status from attandance_master 
		inner join attendance on attandance_master.master_id = attendance.master_id 
		inner join employee on employee.username = attandance_master.emp where 1=1 AND entry_date='".date('Y-m-d', strtotime($_GET['date']))."'";
	}
	$query = mysqli_query($con, $SQL);
		while($rows = mysqli_fetch_array($query)){
		
?>						  
							<tr>
							
								<td><?php echo $rows['name']; ?></td>
								<td class="center"><a href="rpt_day_wise.php?date=<?php echo date('Y-m-d', strtotime($rows['entry_date'])); ?>"><?php echo date('d/m/Y', strtotime($rows['entry_date'])); ?></a></td>
								<td class="center"><?php echo date('h:i', strtotime($rows['time__in'])); ?></td>
								<td class="center"><?php if($rows['time__out'] <> '0000-00-00 00:00:00'){ 
								echo date('h:i', strtotime($rows['time__out'])); 
								}		
										?></td>
										
								<td>
								<?php
									$to_time = date('Y-m-d H:i:s', strtotime($rows['time__in']));
									$from_time = date('Y-m-d H:i:s', strtotime($rows['time__out']));
									$datetime1 = new DateTime($from_time);
									$datetime2 = new DateTime($to_time);
									
									$interval = $datetime1->diff($datetime2);
									$elapsed = $interval->format('%h Hr:%i Min');
									if($rows['time__out'] <> '0000-00-00 00:00:00'){ 
									ECHO $elapsed;
									}
	?>
								</td>
								<td class="center">
									<?php 
									if($rows['status'] == 'Start'){ ?>
										<span class="label label-success">Start Time</span>
									<?php }
									if($rows['status'] == 'Namaz'){ ?>
										<span class="label label-warning"><?php echo $rows['status']; ?> Time</span>
									<?php } 
									if($rows['status'] == 'Sehri'){ ?>
										<span class="label label-pending"><?php echo $rows['status']; ?> Time</span>
										
									<?php } 
									if($rows['status'] == 'Dinner'){ ?>
										<span class="label label-info"><?php echo $rows['status']; ?> Time</span>
									<?php } 
									if($rows['status'] == 'Close'){ ?>
										<span class="label label-important"><?php echo $rows['status']; ?> Time</span>
									<?php } ?>
									
									
								</td>
								
							</tr>
	<?php 
	}
	?>
							
						  </tbody>
					  </table>            
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
