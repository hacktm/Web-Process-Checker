            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Processes<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
							<?php
								while($process = mysqli_fetch_array($processes_menu_query))
								{
							?>
                                <li>
                                    <a href="processes.php?process=<?php echo $process['name']; ?>"><i class="fa fa-tasks fa-fw"></i> <?php echo $process['name']; ?></a>
                                </li>
							<?php
								}
							?>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>