<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0" /> <!-- Para que se pueda aplicar un diseño adaptable y la correcta visualizacion en dispo móviles -->
	<title>PRETI</title>

	<?php
		require_once("includes/estilos.inc");  # Contiene todos los enlaces con el css necesario para las paginas
	?>
	
</head>
<body>
	
	<?php
		require_once("includes/cabecera.inc");  # Cabecera de la pagina con el logo, login y registro
	?>

	<section>
		<h2>Confirmación de solicitud</h2>
		<p>Se ha registrado su solicitud de impresión para el álbum <b>Paisajes</b>.</p>
		<p>El coste total de la operación son <b>13.40 €</b>.</p>
		<a href="usuarioRegistrado.php">Volver a mi perfil.</a>
	</section>

	<?php
		require_once("includes/pie.inc");  # Pie de la pagina con el copyright
	?>
	
</body>
</html>