<?php 
	require("./includes/navbar.php"); 
	require("./includes/sidebar.php");
	
	$message = '';
	
	if(isset($_POST['submit']))
	{
		$check = mysqli_query($conn,"SELECT * FROM users WHERE username = '".$_POST['username']."'");
		if(mysqli_num_rows($check) == 0)
		{
			$_POST['password'] = MD5($_POST['password']);
			if(mysqli_query($conn,"INSERT INTO users (username,password,email) VALUES ('".$_POST['username']."','".$_POST['password']."','".$_POST['email']."')"))
			{
				$message = '<div class="alert alert-success">
								<a href="#" class="close" data-dismiss="alert">&times;</a>
								User '.$_POST['username'].' added!
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
								Username already in use!
							</div>';
		}
	}
?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Add User</h1>
					<?php echo $message; ?>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-plus fa-fw"></i> Form
                        </div>
                        <div class="panel-body">
                            <div class="row">
								<div class="col-lg-6">
									<form action="<?php echo $_SERVER['PHP_SELF']?>" role="form" method="POST">
										<fieldset>
											<div class="form-group">
												<label>Username:</label>
												<input class="form-control" name="username" type="text">
											</div>
											<div class="form-group">
												<label>Password:</label>
												<input class="form-control" name="password" type="text">
											</div>
											<div class="form-group">
												<label>Email:</label>
												<input class="form-control" name="email" type="email">
											</div>
											<button class="btn btn-lg btn-primary" name="submit">Add User</button>
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