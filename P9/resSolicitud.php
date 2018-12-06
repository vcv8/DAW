<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0" /> <!-- Para que se pueda aplicar un diseño adaptable y la correcta visualizacion en dispo móviles -->
	<title>PRETI/solicitud</title>

	<?php
		require("includes/estilos.inc");  # Contiene todos los enlaces con el css necesario para las paginas
		require_once("includes/conexionBD.inc"); # Contiene los datos de conexion al servidor
	?>
	
</head>
<body>
	
	<?php
		require("includes/cabecera.inc");  # Cabecera de la pagina con el logo, login y registro
	?>

	<article id="resAlbum">
		<fieldset id="marcoResAlbum">
			<h2>Confirmación de solicitud</h2>

			<?php

				$sentencia1 = "SELECT Album, Coste FROM solicitudes ORDER BY idSolicitud DESC LIMIT 1"; #Obtenemos el ultimo album insertado
				$ultSolicitud = $mysqli->query($sentencia1);  

				if(!$ultSolicitud || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
				{
					die("Error: no se pudo realizar la consulta: " . $mysqli->error);
				}

				$fila = $ultSolicitud->fetch_assoc();

				$album= $fila['Album'];
				$total = $fila['Coste'];

				$sentencia2 = "SELECT Titulo FROM albumes WHERE idAlbumes='$album'"; #Obtenemos el ultimo album insertado
				$nomAlbum = $mysqli->query($sentencia2);  

				if(!$nomAlbum || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
				{
					die("Error: no se pudo realizar la consulta: " . $mysqli->error);
				}

				$fila2 = $nomAlbum->fetch_assoc();

				$nomAlbum= $fila2['Titulo'];




				echo "<p>Se ha registrado su solicitud de impresión para el album <b>$nomAlbum</b> <p>";
				echo "<p>El coste total de la operación son <b>$total €</b>.</p>"
			?>
			<a href="usuarioRegistrado.php" class="swaplink">Volver a mi perfil.</a>
		</fieldset>
	</article>

	<?php
		require("includes/pie.inc");  # Pie de la pagina con el copyright
	?>
	
</body>
</html>