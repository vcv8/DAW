
<?php
	/* Redirecciona a una página diferente que se encuentra en el directorio actual */ 
	$host = $_SERVER['HTTP_HOST']; 
	$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
	
	if($origen=="registro")
	{
		$extra ="P10/registro.php?Error1=" .$extra2; 
	}
	else
	{
		$extra ="P10/modDatos.php?Error1=" .$extra2; 
	}

	header("Location: http://$host$uri/$extra");
	exit;
?>