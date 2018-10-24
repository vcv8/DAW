<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>PRETI</title>

	<?php
		require_once("includes/estilos.inc");  # Contiene todos los enlaces con el css necesario para las paginas
	?>

</head>
<body>

	<?php
		require_once("includes/cabecera.inc");  # Cabecera de la pagina con el logo, login y registro
	?>

	<section id="detalle">
		<article>
			<figure>
				<div>
					<img src="recursos/gat2.jpg" alt="Foto con mas detalle" class="imagen2">
				</div>
				<figcaption>
					<h2>Amanecer</h2>
					<p class="info">Tomada el 19/09/2018</p>
					<p class="info">en España</p>
					<div>
						<p class="albuminfo">Pertenece al álbum <a href="" title="Acceso al album de Fotos">Paisajes</a>.</p>
						<p>Por <a href="usuarioRegistrado.php" title="Acceso al usuario Roxo95">@Roxo95</a></p>
					</div>
				</figcaption>
			</figure>
		</article>
	</section>

	<?php
		require_once("includes/pie.inc");  # Pie de la pagina con el copyright
	?>
	
</body>
</html>