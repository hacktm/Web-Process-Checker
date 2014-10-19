<?php
	require("../load.php");
	
	if(isset($_GET['com']))
	{
		if(mysqli_query($conn, "INSERT INTO commands (command,process,user) VALUES ('".$_GET['com']."', '".$_GET['proc']."', '".$log_user['username']."')"))
			header("Location: ../processes.php?process=".$_GET['proc']);
		else
			echo "Error";
	}
?>