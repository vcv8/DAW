<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0" /> <!-- Para que se pueda aplicar un diseño adaptable y la correcta visualizacion en dispo móviles -->
	<title>PRETI</title>

	<?php
		require("includes/estilos.inc");  # Contiene todos los enlaces con el css necesario para las paginas
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

				$album = $_GET['album'];  	# Album Seleccionado
				$copias = $_GET['copias'];	# Nº de copias del album
				$paginas = 5; 				# Nº de paginas del album
				$fotos = 8; 				# Nº de fotos del album
				$resolucion = $_GET['resolucion']; # Resolucion del album
				$tipoImpresion = $_GET['cimpresion']; 	# Tipo de impresion del album 

				$total = 0;
				$costePag = 0;
				$costeImpresion = 0;
				$costeResolucion = 0;

				# Calculamos el precio por pagina
				if ($paginas<5) {
				    $costePag = 0.10;

				} elseif ($paginas>=5 && $paginas<=10) {
				    $costePag = 0.08;

				} else { # Mas de 10 paginas
				    $costePag = 0.07;
				}

				# Si la impresion a color añadimos el coste
				if($tipoImpresion == "color")
				{
					$costeImpresion = 0.05;
				}

				if($resolucion >300)
				{
					$costeResolucion = 0.02;
				}

				#Calculo del precio final
				$costeFinalPag = $costePag * $paginas; # Coste total por numero de paginas

				$costeImpresion = $costeImpresion + $costeResolucion;
				$costeFinalFotos = $costeImpresion * $fotos;

				$total = ($costeFinalPag + $costeFinalFotos) * $copias;





				echo "<p>Se ha registrado su solicitud de impresión para el album <b>$album</b> <p>";
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