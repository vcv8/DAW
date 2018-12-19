<?php
	session_start(); # Inicializamos la gestion de sesiones

	require_once("includes/conexionBD.inc"); # Comprobamos la conexion a la base de datos

	if(!isset($_SESSION["usuario"])){
		if(isset($_COOKIE["recordar"])){
			$host = $_SERVER['HTTP_HOST']; 
			$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\');
			if(isset($_GET['brapida'])) {
				$ext = $_GET['brapida'];
				$extra = "P11/controlAcces.php?msg=resBuscar.php?brapida=$ext";
			}else if(isset($_GET['titulo'])){
				$ext1 = $_GET['titulo'];
				$ext2 = $_GET['pais'];
				$ext3 = $_GET['fechaInicial'];
				$ext4 = $_GET['fechaFinal'];
				$ext = "titulo=$ext1&pais=$ext2&fechaInicial=$ext3&fechaFinal=$ext4";
				$extra = "P11/controlAcces.php?msg=resBuscar.php?$ext";
			}else{
				$extra = 'P11/controlAcces.php?msg=resBuscar.php';
			}			 
			header("Location: http://$host$uri/$extra");
			exit;
		}
	}else{
		require_once("includes/mBienvenida.inc");
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
		
		if(isset($_GET['titulo']))
		{
			$titulo = $_GET['titulo']; 
			$fechaInicial = $_GET['fechaInicial']; 
			$fechaFinal = $_GET['fechaFinal']; 
			$pais = "";
			if(isset($_GET['pais'])){
				$pais = $_GET['pais'];
			}

			echo "<p>Mostrando resultados para:</p>";

			$ppais = "";
			if($pais!=""){
				$ppais = "INNER JOIN paises ON Pais=IdPais WHERE NomPais='$pais'";
				echo "<p>País <b>$pais</b></p>";
			}
			$pfecha = "";
			if($fechaInicial!=NULL && $fechaFinal!=NULL){
				if($ppais != ""){
					$pfecha = "AND (FRegistro BETWEEN '$fechaInicial' AND '$fechaFinal')";
				}else{
					$pfecha = "LEFT JOIN paises ON Pais=IdPais WHERE (FRegistro BETWEEN '$fechaInicial' AND '$fechaFinal')";
				}
				$fechaFinalESP = str_replace('-', '/', date('d-m-Y', strtotime($fechaFinal)));
				$fechaInicialESP = str_replace('-', '/', date('d-m-Y', strtotime($fechaInicial)));
				echo "<p>Fecha entre <b>$fechaInicialESP</b> y <b>$fechaFinalESP </b></p>";
			}
			$ptitulo = "";
			if($titulo!=NULL){
				if($pfecha != "" || $ppais != ""){
					$ptitulo = "AND Titulo LIKE '%$titulo%'";
				}else{
					$ptitulo = "LEFT JOIN paises ON Pais=IdPais WHERE Titulo LIKE '%$titulo%'";
				}
				echo "<p>Título <b>$titulo</b></p>";
			}else if($pais=="" && $pfecha==""){
				$ptitulo = "LEFT JOIN paises ON Pais=IdPais";
			}
			# Obtenemos las fotos con los datos del formulario de busqueda
			$sentencia1 = "SELECT fotos.* , paises.NomPais FROM fotos $ppais $pfecha $ptitulo"; # AND Pais=$idPais  Titulo='$titulo'
			
			$fotos = $mysqli->query($sentencia1);  # Devuelve un objeto con todas las fotos

			if(!$fotos || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
			{
				die("Error: no se pudo realizar la consulta: " . $mysqli->error);
			}
			if ($fotos->num_rows<=0) {
				echo "<p><b>No hay coincidencias con los parámetros de búsqueda introducidos</b></p>";
			}
	?>
			<section class="preview"> 
	<?php
			while($fila = $fotos->fetch_assoc())  # Obtenemos el resultado fila a fila en forma de array asociativo
			{

			 ?>
				<article>
					<a href=<?php echo "'detalleFoto.php?id_foto=" . $fila['IdFoto'] . "' >"; ?> 
						<figure>
							<img <?php echo "src='" . $fila['Fichero'] . "'" ?> class="prov" alt="<?php echo $fila['Alternativo'] ?>">
							<figcaption class="top-right">
								<div class="imgResume">
									<p><b><?php echo $fila['Titulo']; ?></b></p>
									<p><?php echo str_replace('-', '/', date('d F Y', strtotime($fila['Fecha']))); ?></p>
									<p id="irPais">
										<?php 
											if( $fila['NomPais'] !=NULL )
											{
												echo $fila['NomPais'];
											}
										?>	
									</p>
								</div>
							</figcaption>
						</figure>
					</a>
				</article>
	<?php
			}
			$fotos ->free();
	?>
			</section>
	<?php

		}else if (isset($_GET['brapida'])) {
			$cadena = $_GET['brapida'];
			echo "<p>Mostrando resultados para</p>
				  <p><b>$cadena</b></p>";
	
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
		}else{
			#Error mala url
			echo '<p id="errorMSG">¡<span>ERROR</span>! La dirección introducida no es válida.</p>';
		}
		require_once("includes/pie.inc");  # Pie de la pagina con el copyright
	?>
	
</body>
</html>