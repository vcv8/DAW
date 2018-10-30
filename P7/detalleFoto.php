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
					<?php
						$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
						list($url, $parametro) = explode('?', $actual_link); # Separamos la url a partir de la interrogacion y lo asignamos a dos valores distintos
						if($parametro%'2'=='0'){ # En funcion de si es par o no, se almacena un array o otro
							$res = array('gat2.jpg', 'Vichyssoise', '20/10/2018','Francia', 'Animales', '@VictorCV8');
						}else{
							$res = array('paisaje.png', 'Amanecer', '19/09/2018','España', 'Paisajes', '@Roxo95');
						}
					?>
					<img src="recursos/<?php echo $res[0];?>" alt="Foto con mas detalle" class="imagen2">
				</div>
				<figcaption>
					<h2><?php echo $res[1]?></h2>
					<p class="info">Tomada el <?php echo $res[2]?></p>
					<p class="info">en <?php echo $res[3]?></p>
					<div>
						<p class="albuminfo">Pertenece al álbum <a href="" title="Acceso al album de Fotos"><?php echo $res[4]?></a>.</p>
						<p>Por <a href="usuarioRegistrado.php" title="Acceso al usuario Roxo95"><?php echo $res[5]?></a></p>
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