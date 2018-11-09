<?php
	session_start(); # Inicializamos la gestion de sesiones

	if(!isset($_SESSION["usuario"])){
		if(isset($_COOKIE["recordar"])){
			$host = $_SERVER['HTTP_HOST']; 
			$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\');
			if(isset($_GET['brapida'])) {
				$ext = $_GET['brapida'];
				$extra = "P7/controlAcces.php?msg=resBuscar.php?brapida=$ext";
			}else if(isset($_GET['titulo'])){
				$ext1 = $_GET['titulo'];
				$ext2 = $_GET['pais'];
				$ext3 = $_GET['fechaInicial'];
				$ext4 = $_GET['fechaFinal'];
				$ext = "titulo=$ext1&pais=$ext2&fechaInicial=$ext3&fechaFinal=$ext4";
				$extra = "P7/controlAcces.php?msg=resBuscar.php?$ext";
			}else{
				$extra = 'P7/controlAcces.php?msg=resBuscar.php';
			}			 
			header("Location: http://$host$uri/$extra");
			exit;
		}
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0" /> <!-- Para que se pueda aplicar un diseño adaptable y la correcta visualizacion en dispo móviles -->
	<title>PRETI/busqueda</title>

	<?php
		require_once("includes/estilos.inc");  # Contiene todos los enlaces con el css necesario para las paginas
	?>
</head>
<body>

	<?php
		if(isset($_SESSION["usuario"])){
			require_once("includes/cabecera3.inc");  # Cabecera de la pagina con el logo y usuario registrado
		}
		else{
			require_once("includes/cabecera4.inc");  # Cabecera de la pagina con el logo, login y registro
		}
		
	?>
	
	<?php
		if(isset($_GET['titulo'])){
			$titulo = $_GET['titulo']; 
			$fechaInicial = $_GET['fechaInicial']; 
			$fechaFinal = $_GET['fechaFinal']; 
			$pais = $_GET['pais']; 

			echo "<p>Mostrando resultados para</p>
				  <p>Título <b>$titulo</b></p>
				  <p>Fecha entre <b>$fechaInicial</b> y <b>$fechaFinal</b></p>
				  <p>País <b>$pais</b></p>";
		}else if (isset($_GET['brapida'])) {
			$cadena = $_GET['brapida'];
			echo "<p>Mostrando resultados para</p>
				  <p><b>$cadena</b></p>";
		}
		
	
	?>
	<section class="preview"> <!-- 5 Ultimas Imagenes -->
		<article>
			<a href="detalleFoto.php?id_foto=1">
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
			<a href="detalleFoto.php?id_foto=2">
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
			<a href="detalleFoto.php?id_foto=3">
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
			<a href="detalleFoto.php?id_foto=4">
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
			<a href="detalleFoto.php?id_foto=5">
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