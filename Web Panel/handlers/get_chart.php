<?php
	require("../load.php");
	
	$query = mysqli_query($conn, "SELECT * FROM processes WHERE name = '".$_GET['process']."'");
	$process = mysqli_fetch_array($query);
	echo $process['ram'];
?>