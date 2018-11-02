<?php
	session_start(); # Inicializamos la gestion de sesiones
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>PRETI</title>
</head>
<body>
	<?php 	

		session_destroy(); # Elimina la sesion del usuario actual
		
		$host = $_SERVER['HTTP_HOST']; 
		$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
		$extra = 'P7/index.php'; 
		header("Location: http://$host$uri/$extra");
		exit; 
	?>
</body>
</html>