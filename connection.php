<?php
//$con = mysqli_connect('localhost', 'encokjnb_attand', 'rehman123');
//$db = mysqli_select_db($con, 'encokjnb_attandence');
$con = mysqli_connect('localhost', 'root', '');
$db = mysqli_select_db($con, 'attendance_db');

/*
if($db){ echo "connected";
}else{
	echo "Not connected";
}
*/
////////////////////////////////////////////////////////////////////////////// Get Mac Address
// Turn on output buffering  
ob_start();  

//Get the ipconfig details using system commond  
system('ipconfig /all');  

// Capture the output into a variable  
$mycomsys=ob_get_contents();  

// Clean (erase) the output buffer  
ob_clean();  

$find_mac = "Physical"; 
//find the "Physical" & Find the position of Physical text  

$pmac = strpos($mycomsys, $find_mac);  
// Get Physical Address  

$macaddress=substr($mycomsys,($pmac+36),17);  
//Display Mac Address  

//echo $macaddress;  
?>