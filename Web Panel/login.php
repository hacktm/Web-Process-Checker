<?php
	require("handlers/config.php");
	
	if(isset($_COOKIE['RammBasePanelUser']))
	{	
		$check = mysqli_query($conn,"SELECT * FROM users WHERE username = '".$_COOKIE['RammBasePanelUser']."'");
		$info = mysqli_fetch_array( $check );
		if ($_COOKIE['RammBasePanelPass'] == $info['password']) 
		{
			header("Location: index.php");
		}
	}
	
	if(isset($_POST['username']))
	{
		if(!$_POST['username'] || !$_POST['password'])
			echo '<script>alert("Complete all fields!")</script>';
		else
		{
			$query = mysqli_query($conn, "SELECT * FROM users WHERE username = '".$_POST['username']."'");
			if(mysqli_num_rows($query) != 0)
			{
				$info = mysqli_fetch_array($query);
				$_POST['password'] = MD5($_POST['password']);
				if($_POST['password'] == $info['password'])
				{
					if($_POST['remember'])
					{
						setcookie("RammBasePanelUser", $_POST['username'], time()+60*60*24*30);
						setcookie("RammBasePanelPass", $_POST['password'], time()+60*60*24*30);
					}
					else
					{
						setcookie("RammBasePanelUser", $_POST['username'], time()+3600);
						setcookie("RammBasePanelPass", $_POST['password'], time()+3600);
					}
					header("Location: index.php");
				}
				else
				{
					echo '<script>alert("Incorrect password!")</script>';
				}
			}
			else
			{
				echo '<script>alert("Username \''.$_POST['username'].'\' not found!")</script>';
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login | Process Checker</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Login</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="username" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div>
                                <button class="btn btn-lg btn-success btn-block">Login</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery Version 1.11.0 -->
    <script src="js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="js/plugins/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>

</body>

</html>
