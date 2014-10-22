<?php
	require("../load.php");
	
	if($_GET['part'] == "dashboard")
	{
		if(mysqli_num_rows($processes_query) == 0)
			echo "<em>No processes are being monitored.</em>";
		else
			while($process = mysqli_fetch_array($processes_query))
			{
	?>
			<div class="col-lg-6 col-md-6">
				<div class="panel panel-<?php if($process['status']) echo 'green'; else echo 'red'; ?>">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-tasks fa-5x"></i>
							</div>
							<div class="col-xs-9 text-right">
								<div class="medium"><?php echo $process['name']; ?></div>
							</div>
						</div>
					</div>
					<a href="processes.php?process=<?php echo $process['name']; ?>">
						<div class="panel-footer">
							<span class="pull-left">Manage <b><?php echo $process['name']; ?></b></span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
				</div>
			</div>
	<?php
		}
	}
	else
		if($_GET['part'] == "menu")
		{
			if(mysqli_num_rows($processes_query) == 0)
				echo "<em>No processes are being monitored.</em>";
			else
				while($process = mysqli_fetch_array($processes_query))
				{
		?>
				<li>
					<a href="processes.php?process=<?php echo $process['name']; ?>"><i class="fa fa-tasks fa-fw"></i> <?php echo $process['name']; ?></a>
				</li>
		<?php
			}
		}
?>