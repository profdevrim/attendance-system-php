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

		<script src="js/jquery-1.9.1.min.js"></script>
		<script src='js/fullcalendar.min.js'></script>
<script type="text/javascript">

/* ---------- Calendars ---------- */
$(document).ready(function() {
			
	$('#calendar_new').fullCalendar({
		header: {
			left: 'title',
			right: 'prev,next today,month,'
		},
		events: [
		
		
		
			{
				title: 'Abdul Rehman',
				start: '2016-06-03T13:00:00',
				constraint: 'businessHours',
				color: '#00A300'
			},
			{
				title: 'M. Izhar',
				start: '2016-06-13T11:00:00',
				constraint: 'availableForMeeting', // defined below
				color: '#EB3C00'
			},
			{
				id : 553,
				title: 'Kamran',
				start: '2016-06-18',
				end: '2016-06-20',
				color: '#FFC40D'
			},
			
			{
				id : 505,
				title: 'Adeel',
				start: '2016-06-18',
				end: '2016-06-20',
				color: '#000'
			},
			
			{
				id : 5,
				title: 'Haseeb',
				start: '2016-06-18',
				end: '2016-06-20',
				color: '#9F00A7'
			},
			
			{
				id : 550,
				title: 'Haseeb',
				start: '2016-06-18',
				end: '2016-06-20',
				color: '#2D89EF'
			},
			
			{
				id : 55,
				title: 'Wahab',
				start: '2016-06-29T20:00:00',
				color: '#EB3C00'
			}
		],
		editable: false,
		droppable: false 
		
	});
});
</script>
			<!-- start: Content -->
			<div id="content" class="span10">
			
						
			<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="index.html">Home</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li><a href="#">Calendar</a></li>
			</ul>
			
			<div class="row-fluid">	
				<div class="box span12">
					<div class="box-header">
						<h2><i class="halflings-icon hand-top"></i><span class="break"></span>Quick View</h2>
					</div>
					<div class="box-content">
						
						<a href='calendar.php?uid=<?php echo $_GET['uid']; ?>' class="quick-button-small span1">
							<i class="icon-calendar"></i>
							<p>Calendar View</p>
						</a>
						
						<a href='rpt_user_summary.php?uid=<?php echo $_GET['uid']; ?>' class="quick-button-small span1">
							<i class="icon-th-large"></i>
							<p>Summary View</p>
						</a>
						
						<a href='rpt_user_detail.php?uid=<?php echo $_GET['uid']; ?>' class="quick-button-small span1">
							<i class="icon-list"></i>
							<p>Detail View</p>
						</a>
						
						
						<div class="clearfix"></div>
					</div>	
				</div><!--/span-->
				
			</div><!--/row-->
			

			<div class="row-fluid ">
				<div class="box span12">
				  <div class="box-header" data-original-title>
					  <h2><i class="halflings-icon calendar"></i><span class="break"></span>Calendar</h2>
				  </div>
				  <div class="box-content">
					<div id="external-events" class="span3 hidden-phone hidden-tablet">
					
						<div class="box black span12" onTablet="span6" onDesktop="span12">
							<div class="box-header">
								<h2><i class="halflings-icon white user"></i><span class="break"></span>Summary</h2>
								<div class="box-icon">
									<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
									<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
								</div>
							</div>
							<div class="box-content">
								<ul class="dashboard-list metro">
<?php
$color_class = '';
$SQL_EMP = "select name, username from employee where role=0";
$query_EMP = mysqli_query($con, $SQL_EMP);
while($rows_EMP = mysqli_fetch_array($query_EMP)){ 	
	if($rows_EMP['username'] == 'ar'){ $color_class = 'green'; }
	if($rows_EMP['username'] == 'kamran'){ $color_class = 'yellow'; }
	if($rows_EMP['username'] == 'wahab'){ $color_class = 'red'; }
	if($rows_EMP['username'] == 'shahraz'){ $color_class = 'blue'; }
	if($rows_EMP['username'] == 'haseeb'){ $color_class = 'pink'; }
	if($rows_EMP['username'] == 'adeel'){ $color_class = 'black'; }									
	if($rows_EMP['username'] == 'izhar'){ $color_class = 'red'; }
									
?>									
									<li class="<?php echo $color_class; ?>">
										<a href="#">
											<img class="avatar" alt="<?php echo $rows_EMP['name']; ?>" src="img/avatar.jpg">
										</a>
										<strong>Name:</strong> <?php echo $rows_EMP['name']; ?><br>
										<strong>Since:</strong> Jul 25, 2012 11:09<br>
										<strong>Working Hr:</strong> 8
									</li>
<?php } ?>									
									
									
								</ul>
							</div>
						</div><!--/span-->
				
						
						</div>

						<div id="calendar_new" class="span9"></div>

						<div class="clearfix"></div>
					</div>
				</div>
			</div><!--/row-->
		

	</div><!--/.fluid-container-->
	
			<!-- end: Content -->
		</div><!--/#content.span10-->
		</div><!--/fluid-row-->
		
	<div class="modal hide fade" id="myModal">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">×</button>
			<h3>Settings</h3>
		</div>
		<div class="modal-body">
			<p>Here settings can be configured...</p>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn" data-dismiss="modal">Close</a>
			<a href="#" class="btn btn-primary">Save changes</a>
		</div>
	</div>
	
	<div class="clearfix"></div>
	
	<footer>

		<p>
			<span style="text-align:left;float:left">&copy; 2013 <a href="http://jiji262.github.io/Bootstrap_Metro_Dashboard/" alt="Bootstrap_Metro_Dashboard">Bootstrap Metro Dashboard</a></span>
			
		</p>

	</footer>
	
	<!-- start: JavaScript-->

	<script src="js/jquery-migrate-1.0.0.min.js"></script>
	
		<script src="js/jquery-ui-1.10.0.custom.min.js"></script>
	
		<script src="js/jquery.ui.touch-punch.js"></script>
	
		<script src="js/modernizr.js"></script>
	
		<script src="js/bootstrap.min.js"></script>
	
		<script src="js/jquery.cookie.js"></script>
	
		
	
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
