<?php
	session_start(); # Inicializamos la gestion de sesiones
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
			<form action="controlAcces.php" method="POST">
				<h2>Inicio de Sesión</h2>
				<p><input class="boxesForm" type="text" name="usuario" placeholder="Introduce tu nombre de usuario" autocomplete="on" required></p>
				<p><input class="boxesForm" type="password" name="contraseña" placeholder="Introduce tu contraseña" required></p>
				<input class="enlaceBoton" type="submit" value="Iniciar Sesión">
			</form>
			<br>
			<p>¿No tienes ninguna cuenta? <a href="registro.php" class="swaplink">Regístrate</a> 
		</fieldset>
	</section>

	<?php
		require_once("includes/pie.inc");  # Pie de la pagina con el copyright
	?>
	
</body>
</html>