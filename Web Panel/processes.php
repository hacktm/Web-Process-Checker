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
		$process = mysqli_fetch_array($query);
	}
?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Process <b><?php echo $process['name']; ?></b></h1>
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
							<div class="row">
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
							</div>
							<div class="row">
								<div class="col-lg-4">
									<button class="btn btn-large btn-primary btn-block"><i class="fa fa-play fa-fw"></i> Start</button>
								</div>
								<div class="col-lg-4">
									<button class="btn btn-large btn-primary btn-block"><i class="fa fa-rotate-left fa-fw"></i> Restart</button>
								</div>
								<div class="col-lg-4">
									<button class="btn btn-large btn-primary btn-block"><i class="fa fa-stop fa-fw"></i> Stop</button>
								</div>
							</div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-8 -->
				
                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i> Pending Commands
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="list-group">
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-comment fa-fw"></i> test
                                    <span class="pull-right text-muted small"><em>4 minutes ago</em>
                                    </span>
                                </a>
                            </div>
                            <!-- /.list-group -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
			<div class="row">
				<div class="col-lg-8">
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
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

<?php require("includes/footer.php"); ?>