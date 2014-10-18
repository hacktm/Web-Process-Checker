<?php
	if(!isset($_COOKIE['RammBasePanelUser']))
	{ 
		header('Location: login.php');
		die();
	}
	$user = $_COOKIE['RammBasePanelUser'];
	$pass = $_COOKIE['RammBasePanelPass'];
	$check = mysqli_query($conn,"SELECT * FROM users WHERE username = '".$user."'");
	$log_user = mysqli_fetch_array( $check );
	if ($pass != $log_user['password']) 
	{
		header('Location: login.php');
		die();
 	}
?>