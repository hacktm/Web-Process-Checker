<?php
	require("includes/navbar.php");
	require("includes/sidebar.php");
	
	if(!isset($_GET['process']))
	{
		echo '<script>alert("No process selected!");window.location.replace("index.php");</script>';
		die();
	}
	else
	{
		$query = mysqli_query($conn, "SELECT * FROM processes WHERE name = '".$_GET['process']."'");
		if(mysqli_num_rows($query) == 0)
		{
			echo '<script>alert("Process not found!");window.location.replace("index.php");</script>';
			die();
		}
	}
?>
		<script>
			function sendCommand(command, process) {
				// Returns successful data submission message when the entered information is stored in database.
				var dataString = 'com=' + command + '&proc=' + process;
				if (command == '' || process == '') {
				alert("Please type a command!");
				} else {
				// AJAX code to submit form.
				$.ajax({
				type: "GET",
				url: "handlers/add_command.php",
				data: dataString,
				cache: false
				});
				}
				return false;
			}
			function confirmCommand(command, process)
			{
				if(confirm('Send '+command+' command for process '+process+' ?'))
				{
					sendCommand(command, process);
					return false;
				}
				else
				{
					return false;
				}
			}
		</script>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Process <b><?php echo $_GET['process']; ?></b></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-reorder fa-fw"></i> Info & Commands
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
							<div id="process-info" class="row">
								
							</div>
							<div class="row">
								<div class="col-lg-6">
									<a href="" onclick="confirmCommand('RestartProcess', '<?php echo $_GET['process']; ?>');return false;" class="btn btn-large btn-primary btn-block"><i class="fa fa-rotate-left fa-fw"></i> Restart</a>
								</div>
								<div class="col-lg-6">
									<a href="" onclick="confirmCommand('StopProcess', '<?php echo $_GET['process']; ?>');return false;" class="btn btn-large btn-primary btn-block"><i class="fa fa-stop fa-fw"></i> Stop</a>
								</div>
							</div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
				<div class="col-lg-4">
                    <div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-bar-chart-o fa-fw"></i> Usage
						</div>
						<!-- /.panel-heading -->
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12">
									<div id="chart"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
            </div>
            <!-- /.row -->
				
        </div>
        <!-- /#page-wrapper -->
	<script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
	<script src="http://cdn.oesmith.co.uk/morris-0.4.1.min.js"></script>
		
	<script>
	function getProcess() {
		if (window.XMLHttpRequest) {
			processInfo=new XMLHttpRequest();
			} else {
			processInfo=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		  processInfo.onreadystatechange=function() {
			if (processInfo.readyState==4 && processInfo.status==200) {
			  document.getElementById("process-info").innerHTML=processInfo.responseText;
			}
		  }
		processInfo.open("GET","ajax/get_process_info.php?part=process-info&process=<?php echo $_GET['process']; ?>",true);
		processInfo.send();
		setTimeout(getProcess, 500);
	}
	getProcess();
	
	function getChartInfo() {
		if (window.XMLHttpRequest) {
			chartInfo=new XMLHttpRequest();
			} else {
			chartInfo=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		  chartInfo.onreadystatechange=function() {
			if (chartInfo.readyState==4 && chartInfo.status==200) {
			  document.getElementById("chart").innerHTML="";
			  var result = chartInfo.responseText.split("|");
			  Morris.Bar({
		  element: 'chart',
		  data: [
			{ y: result[0], ram: result[1], peak: result[2] }
		  ],
		  xkey: 'y',
		  ykeys: ['ram', 'peak'],
		  labels: ['RAM', 'Peak']
		});
			}
		  }
		chartInfo.open("GET","ajax/get_process_info.php?part=chart&process=<?php echo $_GET['process']; ?>",false);
		chartInfo.send();
		setTimeout(getChartInfo, 500);
	}
	getChartInfo();
	
	
	</script>
    </div>
    <!-- /#wrapper -->

<?php require("includes/footer.php"); ?>