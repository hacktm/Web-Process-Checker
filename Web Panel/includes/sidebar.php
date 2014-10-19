            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Processes<span class="fa arrow"></span></a>
                            <ul id="menu-processes" class="nav nav-second-level">
							
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
						<li>
							<a href="#"><i class="fa fa-group fa-fw"></i> Administration<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="add_user.php"><i class="fa fa-user fa-fw"></i> Add User</a>
								</li>
								<li>
									<a href="delete_user.php"><i class="fa fa-minus-circle fa-fw"></i> Delete User</a>
								</li>
                            </ul>
						</li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
		<script>
		function getMenuProcesses() {
			if (window.XMLHttpRequest) {
				menuProcesses=new XMLHttpRequest();
				} else {
				menuProcesses=new ActiveXObject("Microsoft.XMLHTTP");
			  }
			  menuProcesses.onreadystatechange=function() {
				if (menuProcesses.readyState==4 && menuProcesses.status==200) {
				  document.getElementById("menu-processes").innerHTML=menuProcesses.responseText;
				}
			  }
			menuProcesses.open("GET","ajax/get_processes.php?part=menu",true);
			menuProcesses.send();
			setTimeout(getMenuProcesses, 5000);
		}
		getMenuProcesses();
		</script>