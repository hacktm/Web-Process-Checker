<?php
	require("../load.php");
	
	$query = mysqli_query($conn, "SELECT * FROM processes WHERE name = '".$_GET['process']."'");
	$process = mysqli_fetch_array($query);
	
	if($_GET['part'] == "process-info")
	{
		?>
			<div class="col-lg-4">
				<div class="panel-body text-center">
					RAM Usage
					<span class="badge"><?php echo SizeSuffix($process['ram']); ?></span>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="panel-body text-center">
					RAM Peak
					<span class="badge"><?php echo SizeSuffix($process['peak']); ?></span>
				 </div>
			</div>
			<div class="col-lg-4">
				<div class="panel-body text-center">
					Status
					<span class="badge"><?php if($process['status']) echo "Running"; else echo "Not Running"; ?></span>
				</div>
			</div>
		<?php
	}
	else
		if($_GET['part'] == "chart")
			echo date("H:i", time($process['date']))."|".$process['ram']."|".$process['peak'];
?>