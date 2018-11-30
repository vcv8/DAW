<?php
	session_start(); # Inicializamos la gestion de sesiones

	require_once("includes/conexionBD.inc"); # Comprobamos la conexion a la base de datos

	// Borra todas las variables de sesión 
	$_SESSION = array(); 
	 
	// Borra la cookie que almacena la sesión 
	if(isset($_COOKIE[session_name()])) { 
	   setcookie(session_name(), '', time() - 42000, '/'); 
	}
	if (isset($_COOKIE["firsttime"])) {
		setcookie("firsttime", '', time() - 3600);
	}
	if (isset($_COOKIE["recordar"])) {
		setcookie("recordar", '', time() - 3600);
	}
	
	session_destroy(); # Elimina la sesión del usuario actual
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0" /> <!-- Para que se pueda aplicar un diseño adaptable y la correcta visualizacion en dispo móviles -->
	<title>PRETI/registro</title>

	<?php
		require_once("includes/estilos.inc");  # Contiene todos los enlaces con el css necesario para las paginas
	?>
</head>
<body>

	<?php
		require_once("includes/cabecera2.inc");  # Cabecera de la pagina con solo logo

		$site = 'reg'; # Variable que nos permite identificar la version del formulario de registro que debemos mostrar

		$pam = '<p>¿Ya tienes cuenta? <a href="login.php" class="swaplink">Iniciar Sesión</a> </p>'; # Cadena unica para el formulario de Registro

		require_once("includes/regForm.inc");

		require_once("includes/pie.inc");  # Pie de la pagina con el copyright
	?>

</body>
</html>