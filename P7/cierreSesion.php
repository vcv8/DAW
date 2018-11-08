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

		// Borra todas las variables de sesión 
		 $_SESSION = array(); 
		 
		 // Borra la cookie que almacena la sesión 
		 if(isset($_COOKIE[session_name()])) { 
		   setcookie(session_name(), ’’, time() - 42000, ’/’); 
		 } 
		 
		 // Finalmente, destruye la sesión 
		 session_destroy(); 
		
		$host = $_SERVER['HTTP_HOST']; 
		$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
		$extra = 'P7/index.php'; 
		header("Location: http://$host$uri/$extra");
		exit; 
	?>
</body>
</html>