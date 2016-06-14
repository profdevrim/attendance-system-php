<?php
	session_start();
	$_SESSION['user_id'] = '';
	$_SESSION['role'] = '';
	session_destroy();
	echo '<script>window.location="index.php"</script>';  
?>