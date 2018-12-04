<?php

	$host = $_SERVER['HTTP_HOST']; 
			$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\');
			$extra = "P9/controlAcces.php?msg=".basename(__FILE__); 
			$plus = '?user=' . $_GET['user'];
			header("Location: http://$host$uri/$extra$plus");
			exit;

?>