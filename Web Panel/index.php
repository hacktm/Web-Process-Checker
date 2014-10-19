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
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Processes
                        </div>
                        <!-- /.panel-heading -->
                        <div id="processes" class="panel-body">
						
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
	<script>
	function getProcesses() {
		if (window.XMLHttpRequest) {
			dashboardProcesses=new XMLHttpRequest();
			} else {
			dashboardProcesses=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		  dashboardProcesses.onreadystatechange=function() {
			if (dashboardProcesses.readyState==4 && dashboardProcesses.status==200) {
			  document.getElementById("processes").innerHTML=dashboardProcesses.responseText;
			}
		  }
		dashboardProcesses.open("GET","ajax/get_processes.php?part=dashboard",true);
		dashboardProcesses.send();
		setTimeout(getProcesses, 500);
	}
	getProcesses();
	</script>
    </div>
    <!-- /#wrapper -->
<?php require("includes/footer.php"); ?>