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
				<li><a href="#">Break</a></li>
			</ul>

			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon bell"></i><span class="break"></span>Break</h2>
						<?php /*
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>
						*/
						?>
					</div>
<?php 
$master_id = 0;
$SQL = "select * from attandance_master where emp='".$_SESSION['user_id']."' and master_status='Start'";
$query = mysqli_query($con, $SQL);
$rows = mysqli_fetch_array($query);
if(mysqli_num_rows($query) <> 0 ){ 
	$master_id = $rows['master_id'];


	$SQL = "SELECT max(recindex) as max_rec FROM `attendance` WHERE master_id=".$master_id;
	$query = mysqli_query($con, $SQL);
	$rows = mysqli_fetch_array($query);
	$max_rec = $rows['max_rec'];

	$SQL = "SELECT status FROM `attendance` WHERE recindex=".$max_rec;
	$query = mysqli_query($con, $SQL);
	$rows = mysqli_fetch_array($query);
	$status = $rows['status'];
	if($status == 'Sehri' || $status == 'Namaz' || $status == 'Dinner'){ ?>

	<div class="box-content">
		<a class="quick-button span2" onclick="myFunction_return()" >
			<i class="icon-share"></i>
			<p><?php echo "On Break ( $status )"; ?><Br>
			
	<script>
	function myFunction_return() {
		var SelBreak = $('#break_type').val();    
		if( SelBreak == "Select" ){
			alert('Please select The Break Type...');
		}else{
			window.location="break_return_now.php?Break_Type="+SelBreak;
		}
	}
	</script>
	</p>						
	</a>
		<br><br><br><br><br><br><br>
			
	</div>	

	<?php
	}else{
	?>										
	<div class="box-content">
		<a class="quick-button span2" onclick="myFunction()" >
			<i class="icon-time"></i>
			<p><?php echo "Take Break..."; ?>
	<script>
	function myFunction() {
		var SelBreak = $('#break_type').val();    
		if( SelBreak == "Select" ){
			alert('Please select The Break Type...');
		}else{
			window.location="break_now.php?Break_Type="+SelBreak;
		}
	}
	</script>
	</p>						
	</a>
		<br><br><br><br><br><br><br>
		<select id="break_type" name="break_type">
			<option>Select</option>
			<option>Sehri</option>
			<option>Namaz</option>
			<option>Dinner</option>
		</select>
	</div>
	<?php } 
	
}else{ ?>
	<div class="box-content">
		<a class="quick-button span2" >
			<i class="icon-question-sign"></i>
			<p>Timer Not Started</p>						
		</a>	
		<br><br><br><br><br><br><br>
	</div>
<?php } ?>					
					
					
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
