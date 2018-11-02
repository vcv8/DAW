<?php
	session_start(); # Inicializamos la gestion de sesiones
?>
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

	<section class="preview"> <!-- 5 Ultimas Imagenes -->
		<article>
			<?php 
				if(isset($_SESSION["usuario"])){
			?>

			<a href="detalleFoto.php?1">

			<?php
				}
				else 
				{
			?>

			<a href="index.php">

			<?php
				}
			?>
				<figure>
					<img src="recursos/paisaje.png" class="prov">
					<figcaption class="top-right">
						<div class="imgResume">
							<p><b>Amanecer</b></p>
							<p>29 Septiembre 2018</p>
							<p>España</p>
						</div>
					</figcaption>
				</figure>
			</a>
		</article>
		<article>
			<?php 
				if(isset($_SESSION["usuario"])){
			?>

			<a href="detalleFoto.php?2">

			<?php
				}
				else 
				{
			?>

			<a href="index.php">

			<?php
				}
			?>
				<figure>
					<img src="recursos/Screenshot_20171128_183907.png" class="prov">
					<figcaption class="top-right">
						<div class="imgResume">
							<p><b>Hackea tu destino</b></p>
							<p>29 Septiembre 2018</p>
							<p>España</p>
						</div>
					</figcaption>
				</figure>
			</a>
		</article>
		<article>
			<?php 
				if(isset($_SESSION["usuario"])){
			?>

			<a href="detalleFoto.php?3">

			<?php
				}
				else 
				{
			?>

			<a href="index.php">

			<?php
				}
			?>
				<figure>
					<img src="recursos/artemania.jpg" class="prov">
					<figcaption class="top-right">
						<div class="imgResume">
							<p><b>ArteManía</b></p>
							<p>29 Septiembre 2018</p>
							<p>España</p>
						</div>
					</figcaption>
				</figure>
			</a>
		</article>
		<article>
			<?php 
				if(isset($_SESSION["usuario"])){
			?>

			<a href="detalleFoto.php?4">

			<?php
				}
				else 
				{
			?>

			<a href="index.php">

			<?php
				}
			?>
				<figure>
					<img src="recursos/gat2.jpg" class="prov">
					<figcaption class="top-right">
						<div class="imgResume">
							<p><b>Vichyssoise</b></p>
							<p>29 Septiembre 2018</p>
							<p>España</p>
						</div>
					</figcaption>
				</figure>
			</a>
		</article>
		<article>
			<?php 
				if(isset($_SESSION["usuario"])){
			?>

			<a href="detalleFoto.php?5">

			<?php
				}
				else 
				{
			?>

			<a href="index.php">

			<?php
				}
			?>
				<figure>
					<img src="recursos/gujero.jpg" class="prov">
					<figcaption class="top-right">
						<div class="imgResume">
							<p><b>Descanso</b></p>
							<p>29 Septiembre 2018</p>
							<p>España</p>
						</div>
					</figcaption>
				</figure>
			</a>
		</article>
	</section>

	<?php
		require_once("includes/pie.inc");  # Pie de la pagina con el copyright
	?>

</body>
</html>