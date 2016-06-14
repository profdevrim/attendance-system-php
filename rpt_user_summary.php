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
			
			<div class="row-fluid">	
				<div class="box span12">
					<div class="box-header">
						<h2><i class="halflings-icon hand-top"></i><span class="break"></span>Quick Report</h2>
						<div class="box-icon">
								<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
						</div>
					</div>
					
					<div class="box-content" style="display:none;">						
						<a href='calendar.php?uid=<?php echo $_GET['uid']; ?>' class="quick-button-small span1">
							<i class="icon-calendar"></i>
							<p>Calendar Report</p>
						</a>
						
						<a href='rpt_user_summary.php?uid=<?php echo $_GET['uid']; ?>' class="quick-button-small span1">
							<i class="icon-th-large"></i>
							<p>Summary Report</p>
						</a>
						
						<a href='rpt_user_detail.php?uid=<?php echo $_GET['uid']; ?>' class="quick-button-small span1">
							<i class="icon-list"></i>
							<p>Detail Report</p>
						</a>
						
						<a href='rpt_user_monthly.php?uid=<?php echo $_GET['uid']; ?>' class="quick-button-small span1">
							<i class="icon-list"></i>
							<p>Monthly Report</p>
						</a>
						
						
						<div class="clearfix"></div>
					</div>	
				</div><!--/span-->
				
			</div><!--/row-->
			
<?php if($_SESSION['role']  != 0){ ?>
			<div class="row-fluid">	
				<div class="box blue span12">
					<div class="box-header">
						<h2><i class="halflings-icon hand-top"></i><span class="break"></span>Quick Buttons</h2>
						<div class="box-icon">
							<a href="#" class="btn-minimize" ><i class="halflings-icon chevron-up"></i></a>
						</div>
						
					</div>
					<div class="box-content" style="display:none;">
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
			
						<a class="quick-button span2" href='rpt_user_summary.php?uid=<?php echo base64_encode($rows_EMP['username']); ?>'>
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
		where emp='".$rows_EMP['username']."' and attandance_master.master_id=".$master_id." and status<>'sehri'";	
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
			
						<a class="quick-button span2" href='rpt_user_summary.php?uid=<?php echo base64_decode($rows_EMP['username']); ?>'>
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
						<h2><i class="halflings-icon file"></i><span class="break"></span>Attandence Summary : <strong> ( <?php
$SQL_EMP = "select name, username from employee where username='".base64_decode($_GET['uid'])."'";
	$query_EMP = mysqli_query($con, $SQL_EMP);
	while($rows_EMP = mysqli_fetch_array($query_EMP)){ 		
		echo $rows_EMP['name'];
	} ?> )</strong>
						</h2>
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
								 
								  <th>Date</th>
								  <th>Hr</th>
							  </tr>
						  </thead>   
						  <tbody>
<?php
		$__hr = 0;
		$SQL = "select name, entry_date, master_id, master_status from attandance_master 
		inner join employee on employee.username = attandance_master.emp where username='". base64_decode($_GET['uid'])."' and master_status='Close'";
		$query = mysqli_query($con, $SQL);
		while($rows = mysqli_fetch_array($query)){		
?>						  
							<tr>							
								<td class="center"><a href="rpt_day_wise.php?date=<?php echo date('Y-m-d', strtotime($rows['entry_date'])); ?>"><?php echo date('d/m/Y', strtotime($rows['entry_date'])); ?></a></td>
								<td>
								<?php
								$_hr = $_mint = 0;
									$SQL2 = "select time__in, time__out from attendance WHERE master_id=".$rows['master_id'];
									$query2 = mysqli_query($con, $SQL2);
									while($rows2 = mysqli_fetch_array($query2)){
										$to_time = date('Y-m-d H:i:s', strtotime($rows2['time__in']));
										$from_time = date('Y-m-d H:i:s', strtotime($rows2['time__out']));
										$datetime1 = new DateTime($from_time);
										$datetime2 = new DateTime($to_time);
										$interval = $datetime1->diff($datetime2);
										$elapsed = $interval->format('%h Hr:%i Min');
										$_hr = $_hr + $interval->format('%h');
										$_mint = $_mint + $interval->format('%i');
									}
									if($_mint > 60){
										$__mint = $_mint / 60;
										$_hr = round($_hr + $__mint);
										$GET_MINT = explode('.', $__mint);
										$print_mint = substr($GET_MINT[1], 0, 2);
									}else{
										$print_mint  =  $_mint;
									}
									
									if($print_mint < 10){
										$print_mint = "0".$print_mint;									
									}
									$__hr = $__hr + $_hr;
									echo $_hr . ":" . $print_mint;
									
	?>
								</td>
								
								
							</tr>
	<?php 
	}
	?>
							
						  </tbody>
						  <tfoot>
							<tr style="background-color:blue; font-weight:800; color:#fff;">
								<td> Total Hour </td>
								<td><?php echo $__hr; ?></td>
								
							</tr>
						  </tfoot>
					  </table>       


					  <div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon edit"></i><span class="break"></span>Date Wise Report Detail</h2>
						<div class="box-icon">
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<form class="form-horizontal">
						  <fieldset>
							
							<div class="control-group">
							  <label class="control-label" for="date01">Date From</label>
							  <div class="controls">
								<input type="text" class="input-xlarge datepicker" id="date01" value="<?php echo date('01/m/Y'); ?>">
							  </div>
							</div>

							<div class="control-group">
							  <label class="control-label" for="date01">Date To</label>
							  <div class="controls">
								<input type="text" class="input-xlarge datepicker" id="date02" value="<?php echo date('d/m/Y'); ?>">
							  </div>
							</div>

							
							<div class="form-actions">
							  <button type="submit" class="btn btn-primary">Show</button>
							  <button type="reset" class="btn">Cancel</button>
							</div>
						  </fieldset>
						</form>   

					</div>
				</div><!--/span-->

			</div><!--/row-->
					  
					  <table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								 
								  <th>Date</th>
								  <th>Hr</th>
							  </tr>
						  </thead>   
						  <tbody>
<?php
$Today = date('d');
	for($i=1; $i<=$Today; $i++){
		if($i <= 9)
		{
			$i = "0".$i;
		}
		$Get_Date = date('Y-m-'.$i); 
		//echo date('l', strtotime($Get_Date));
		
		$__hr = 0;
		$SQL = "select name, entry_date, master_id, master_status from attandance_master 
		inner join employee on employee.username = attandance_master.emp where username='". base64_decode($_GET['uid'])."' and master_status='Close' and entry_date='".$Get_Date."'";
		$query = mysqli_query($con, $SQL);
		if(mysqli_num_rows($query) == 0){ ?>
		
		<tr>							
								<td class="center">
								
								
									<a href="rpt_day_wise.php?date=<?php echo date('Y-m-d', strtotime($Get_Date)); ?>"><?php echo date('d/m/Y', strtotime($Get_Date)); ?></a>
								
								
								</td>
								<td> <?php echo "Sunday" ==  date('l', strtotime($Get_Date)) ? 'Holiday' : 'Absent'; ?> 
								
								
								</td>
		</tr>
			<?php 
			
		}else{
		
				while($rows = mysqli_fetch_array($query)){		
?>						  <tr>							
								<td class="center">
								
								
								<a href="rpt_day_wise.php?date=<?php echo date('Y-m-d', strtotime($rows['entry_date'])); ?>"><?php echo date('d/m/Y', strtotime($rows['entry_date'])); ?></a>
								
								
								</td>
								<td>
								<?php
								$_hr = $_mint = 0;
									$SQL2 = "select time__in, time__out from attendance WHERE master_id=".$rows['master_id'];
									$query2 = mysqli_query($con, $SQL2);
									while($rows2 = mysqli_fetch_array($query2)){
										$to_time = date('Y-m-d H:i:s', strtotime($rows2['time__in']));
										$from_time = date('Y-m-d H:i:s', strtotime($rows2['time__out']));
										$datetime1 = new DateTime($from_time);
										$datetime2 = new DateTime($to_time);
										$interval = $datetime1->diff($datetime2);
										$elapsed = $interval->format('%h Hr:%i Min');
										$_hr = $_hr + $interval->format('%h');
										$_mint = $_mint + $interval->format('%i');
									}
									if($_mint > 60){
										$__mint = $_mint / 60;
										$_hr = round($_hr + $__mint);
										$GET_MINT = explode('.', $__mint);
										$print_mint = substr($GET_MINT[1], 0, 2);
									}else{
										$print_mint  =  $_mint;
									}
									
									if($print_mint < 10){
										$print_mint = "0".$print_mint;									
									}
									$__hr = $__hr + $_hr;
									echo $_hr . ":" . $print_mint;
									
	?>
								</td>
								
								
							</tr>
	<?php 
		} /////
		} ///////////////////// While 
	} //// For Date
	?>
							
						  </tbody>
						  <tfoot>
							<tr style="background-color:blue; font-weight:800; color:#fff;">
								<td> Total Hour </td>
								<td><?php echo $__hr; ?></td>
								
							</tr>
						  </tfoot>
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
