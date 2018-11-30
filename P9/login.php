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
	<title>PRETI/login</title>
	
	<?php
		require_once("includes/estilos.inc");  # Contiene todos los enlaces con el css necesario para las paginas
	?>

</head>
<body>

	<?php
		require_once("includes/cabecera2.inc");  # Cabecera de la pagina con solo logo
	
	?>
	<section class="Inicio-Registro"> <!--Formulario de Inicio de Sesión -->
		<fieldset class="marcoInicioRegistro">
			<form action="controlAcces.php?log=true" method="POST">
				<h2>Inicio de Sesión</h2>
				<p><input class="boxesForm" type="text" name="usuario" placeholder="Nombre de usuario" autocomplete="on" required></p>
				<p><input class="boxesForm" type="password" name="contraseña" placeholder="Contraseña" required></p>
				<p><input type="checkbox" name="recuerdame" id="recbox"><label id="reclabel">Recuérdame</label></p>
				<input class="enlaceBoton" type="submit" value="Iniciar Sesión">
			</form>
			<br>
			<p>¿No tienes ninguna cuenta? <a href="registro.php" class="swaplink">Regístrate</a> 
		</fieldset>
		<br><br>
		<?php
		#print_r($_GET);
			if($_GET && isset($_GET['Error1'])){
				if($_GET && $_GET['Error1']=="loginError") # Error cuando el usuario o la contraseña es incorrecta
				{ 
					echo '<p id="errorMSG">¡<span>ERROR</span>! La cuenta con la que se ha iniciado sesión no está registrada. <a href="registro.php">Registrarse</a>.</p>';
				}
				else
				{
					if($_GET && $_GET['Error1']=="accesoUsuarioNoRegistrado") # Error cuando se intenta acceder a una parte de la pagina que requiere estar registrado
					{
						echo '<p id="errorMSG">¡<span>ERROR</span>! Necesita iniciar sesion para poder acceder a esta parte. <a href="registro.php">Registrarse</a>.</p>';
					}
				}
			}
		?>
	</section>

	
	<?php	
		require_once("includes/pie.inc");  # Pie de la pagina con el copyright
	?>
	
</body>
</html>