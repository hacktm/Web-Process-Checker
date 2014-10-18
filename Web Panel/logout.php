<?php
	setcookie('RammBasePanelUser', gone, time() - 100); 
	setcookie('RammBasePanelPass', gone, time() - 100);
	header("Location: login.php");
?>