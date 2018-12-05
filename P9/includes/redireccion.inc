
<?php
	/* Redirecciona a una página diferente que se encuentra en el directorio actual */ 
	$host = $_SERVER['HTTP_HOST']; 
	$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
	header("Location: http://$host$uri/$extra");
	exit;
?>