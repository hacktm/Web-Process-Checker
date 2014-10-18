<?php
	require("handlers/config.php");
	require("handlers/cookie.php");
	
	$processes_query = mysqli_query($conn, "SELECT * FROM processes");
?>