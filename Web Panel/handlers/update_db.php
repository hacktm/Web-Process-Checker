 <?php
	require('config.php');
	if($_POST['key'] == $key)
	{
		$query = mysqli_query($conn, "SELECT * FROM processes WHERE name = '".$_POST['name']."'");
		if(mysqli_num_rows($query) != 0)
		{
			mysqli_query($conn, "UPDATE processes SET status = '".$_POST['status']."', ram = '".$_POST['ram']."', peak = '".$_POST['peak']."' WHERE name = '".$_POST['name']."'");
		}
		else
		{
			mysqli_query($conn, "INSERT INTO processes (name, ram, peak, status) VALUES ('".$_POST['name']."','".$_POST['ram']."', '".$_POST['peak']."', '".$_POST['status']."')");
		}
	}
	else
		echo "Unauthorized!";
 ?>