<?php
	session_start(); # Inicializamos la gestion de sesiones

	require_once("includes/conexionBD.inc"); # Comprobamos la conexion a la base de datos

	if(!isset($_SESSION["usuario"])){
		if(isset($_COOKIE["recordar"])){
			$host = $_SERVER['HTTP_HOST']; 
			$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\');
			if(isset($_GET['brapida'])) {
				$ext = $_GET['brapida'];
				$extra = "P8/controlAcces.php?msg=resBuscar.php?brapida=$ext";
			}else if(isset($_GET['titulo'])){
				$ext1 = $_GET['titulo'];
				$ext2 = $_GET['pais'];
				$ext3 = $_GET['fechaInicial'];
				$ext4 = $_GET['fechaFinal'];
				$ext = "titulo=$ext1&pais=$ext2&fechaInicial=$ext3&fechaFinal=$ext4";
				$extra = "P8/controlAcces.php?msg=resBuscar.php?$ext";
			}else{
				$extra = 'P8/controlAcces.php?msg=resBuscar.php';
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
			$pais = $_GET['pais']; 

			if($fechaFinal!=NULL)
			{
				$fechaFinalESP = str_replace('-', '/', date('d-m-Y', strtotime($fechaFinal)));
			}
			else
			{
				$fechaFinalESP = "30/11/2018";
				$fechaFinal = "2018-11-30";
			}

			if($fechaInicial!=NULL)
			{
				$fechaInicialESP = str_replace('-', '/', date('d-m-Y', strtotime($fechaInicial)));
			}
			else
			{
				$fechaInicialESP = "1/11/2018";
				$fechaInicial = "2018-11-1";
			}

			echo "<p>Mostrando resultados para</p>
				  <p>Título <b>$titulo</b></p>
				  <p>Fecha entre <b>$fechaInicialESP</b> y <b>$fechaFinalESP </b></p>
				  <p>País <b>$pais</b></p>";

			# Obtenemos el pais

			$sentencia2 = "SELECT IdPais FROM paises WHERE NomPais='$pais'";
			$pais = $mysqli->query($sentencia2);  # Devuelve un objeto con el pais con ese nombre

			if(!$pais || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
			{
				die("Error: no se pudo realizar la consulta: " . $mysqli->error);
			}


			$fila2 =  $pais->fetch_assoc();

			$idPais = $fila2['IdPais'];


			# Obtenemos las fotos con los datos del formulario de busqueda
			#$sentencia1 = "SELECT * FROM fotos WHERE (FRegistro BETWEEN '$fechaInicial' AND '$fechaFinal') AND Titulo='$titulo'"; # AND Pais=$idPais  Titulo='$titulo'
			#$fotos = $mysqli->query($sentencia1);  # Devuelve un objeto con todas las fotos

			#if(!$fotos || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
			#{
			#	die("Error: no se pudo realizar la consulta: " . $mysqli->error);
			#}

			$titulo2 = '%'.$titulo.'%';
			# Obtenemos todas las fotos en funcion de los parametros de la busqueda
			$sentencia1 = "SELECT * FROM fotos WHERE (FRegistro BETWEEN '$fechaInicial' AND '$fechaFinal') AND Titulo LIKE '$titulo2'";

			
			$fotos = $mysqli->query($sentencia1);  # Devuelve un objeto con todas las fotos encontradas
			if(!$fotos || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
			{
				die("Error: no se pudo realizar la consulta: " . $mysqli->error);
			}

			while($fila = $fotos->fetch_assoc())  # Obtenemos el resultado fila a fila en forma de array asociativo
			{

			 ?>

			<section class="preview"> 
				<article>
					<a href=<?php echo "'detalleFoto.php?id_foto=" . $fila['IdFoto'] . "' >"; ?> 
						<figure>
							<img <?php echo "src='" . $fila['Fichero'] . "'" ?> class="prov">
							<figcaption class="top-right">
								<div class="imgResume">
									<p><b><?php echo $fila['Titulo']; ?></b></p>
									<p><?php echo $fila['Fecha']; ?></p>
									<p>
										<?php 
											if( $idPais !=NULL )
											{
												echo $fila2['NomPais'];
											}
										?>	
									</p>
								</div>
							</figcaption>
						</figure>
					</a>
				</article>
			</section>



	<?php
			}
			$fotos ->free();

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
		}
		require_once("includes/pie.inc");  # Pie de la pagina con el copyright
	?>
	
</body>
</html>