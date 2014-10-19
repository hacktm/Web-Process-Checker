<?php
	require('config.php');
	if($_POST['key'] == "jf9uh4iuhjf0wehfj93")
	{
		$query = mysqli_query($conn, "SELECT * FROM processes WHERE name = '".$_POST['name']."'");
		if(mysqli_num_rows($query) != 0)
		{
			mysqli_query($conn, "DELETE FROM processes WHERE name = '".$_POST['name']."'");
		}
	}
?>