<?php
	require("includes/navbar.php");
	require("includes/sidebar.php");
?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Processes
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<?php
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
												<div class="huge"><?php echo $process['name']; ?></div>
											</div>
										</div>
									</div>
									<a href="processes.php?process=<?php echo $process['name']; ?>">
										<div class="panel-footer">
											<span class="pull-left">Manage <b><?php echo $process['name']; ?></b> process</span>
											<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
											<div class="clearfix"></div>
										</div>
									</a>
								</div>
							</div>
						<?php
							}
						?>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-8 -->
                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i> Notifications Panel
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="list-group">
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-comment fa-fw"></i> Pending Commands
                                    <span class="pull-right text-muted small"><em>4 minutes ago</em>
                                    </span>
                                </a>
                            </div>
                            <!-- /.list-group -->
                            <a href="#" class="btn btn-default btn-block">View All Alerts</a>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<?php require("includes/footer.php"); ?>