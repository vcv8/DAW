<?php
	session_start(); # Inicializamos la gestion de sesiones
	
	if(!isset($_SESSION["usuario"])){
		$host = $_SERVER['HTTP_HOST']; 
		$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
		$extra = 'P7/login.php?Error1=accesoUsuarioNoRegistrado'; 
		header("Location: http://$host$uri/$extra");
		exit;	
	}
	else{
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0" /> <!-- Para que se pueda aplicar un diseño adaptable y la correcta visualizacion en dispo móviles -->
	<title>PRETI/crearAlbum</title>

	<?php
		require("includes/estilos.inc");  # Contiene todos los enlaces con el css necesario para las paginas
	?>

</head>
<body>

	<?php
		require("includes/cabecera1.inc");  # Cabecera de la pagina con el logo, login y registro
	?>

	<div id="crearAlbum">
		<fieldset id="marcoCrearAlbum">
			<h2>Crear Album</h2>
			<p>Los parámetros marcados con (*) son obligatorios.</p>
			<form action="usuarioRegistrado.php" method="GET">
				<p><label><b>Titulo (*)</b></label><input class="boxesAlbum" type="text" name="tituloAlbum" placeholder="Título del Album" maxlength="200" required></p>
				<p><label><b>Descripción</b> </label><input class="bigBoxes" type="text" name="descripcionAlbum" placeholder="Descripción del Álbum" maxlength="4000"></p>

				<p><input id="solicitarAlbum" type="submit" value="Crear Album" title="Creación de un nuevo Album"></p>
			</form>
		</fieldset>

	</div>

	<?php
		require("includes/pie.inc");  # Pie de la pagina con el copyright
	?>

</body>
</html>
<?php 
	}
?>