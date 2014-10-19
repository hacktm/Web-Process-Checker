<?php 
	require("./includes/navbar.php"); 
	require("./includes/sidebar.php");
	
	$message = '';
	
	if(isset($_POST['delete']))
	{
		$check = mysqli_query($conn,"SELECT * FROM users WHERE id= '".$_POST['id']."'");
		if(mysqli_num_rows($check) != 0)
		{
			$user = mysqli_fetch_array($check);
			if(mysqli_query($conn,"DELETE FROM users WHERE id= '".$_POST['id']."'"))
			{
				$message = '<div class="alert alert-success">
								<a href="#" class="close" data-dismiss="alert">&times;</a>
								User deleted!
							</div>';
			}
			else
				$message = '<div class="alert alert-danger">
								<a href="#" class="close" data-dismiss="alert">&times;</a>
								Fatal error!
							</div>';
		}
		else
		{
			$message = '<div class="alert alert-danger">
								<a href="#" class="close" data-dismiss="alert">&times;</a>
								User does not exist!
							</div>';
		}
	}
?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Delete User</h1>
					<?php echo $message; ?>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
					<div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-minus fa-fw"></i> Choose User
                        </div>
                        <div class="panel-body">
                            <div class="row">
								<div class="col-lg-6">
									<form action="<?php echo $_SERVER['PHP_SELF']?>" role="form" method="POST">
										<fieldset>
											<div class="form-group">
												<select name="id">
													<?php
													$get = mysqli_query($conn,"SELECT * FROM users ORDER BY id");
													while($info = mysqli_fetch_array($get)) { ?>
														<option value="<?php echo $info['id']; ?>"><?php echo '[ID '.$info['id'].'] '.$info['username']; ?></option>
													<?php } ?>
												</select>
											</div>
											<button class="btn btn-lg btn-primary" name="delete">Delete User</button>
										</fieldset>
									</form>
								</div>
							</div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
<?php require("./includes/footer.php"); ?>