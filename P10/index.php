<?php
	session_start(); # Inicializamos la gestion de sesiones

	require_once("includes/conexionBD.inc"); # Comprobamos la conexion a la base de datos

	if(!isset($_SESSION["usuario"])){
		if(isset($_COOKIE["recordar"])){
			$host = $_SERVER['HTTP_HOST']; 
			$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
			$extra = 'P10/controlAcces.php?msg=index.php'; 
			header("Location: http://$host$uri/$extra");
			exit;
		}	 
	}else{
		require_once("includes/mBienvenidaIU.inc"); //Genera la cookie que necesaria para mostrar el mensaje de bienvenida con la fecha de la ultima conexion
	}
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
		if(isset($_SESSION["usuario"])){
			require_once("includes/cabecera1.inc");  # Cabecera de la pagina con el logo y usuario registrado
		}
		else{
			require_once("includes/cabecera.inc");  # Cabecera de la pagina con el logo, login y registro
		}

		if(isset($_SESSION["usuario"])){
			if (!isset($_COOKIE['firsttime']))
			{
				if(isset($_COOKIE['lasttime' . $_SESSION["usuario"]])){
					echo "$saludo";
				}
			}
		}
	?>


	<section class="preview"> <!-- 5 Ultimas Imagenes -->

		<?php

			#Seleccion de foto por critico 
			$ficheroFoto = file("./recursos/seleccionFotos.txt"); #Abrimos fichero
			$numLineas = count($ficheroFoto); # Numero de lineas que tiene el fichero

			#echo $numLineas;
			if($ficheroFoto)
			{
				$numRandom = rand(0,$numLineas-1);
				list($tituloFoto, $autor, $comentario) = explode("|", $ficheroFoto[$numRandom]); 

				$sentencia3 = "SELECT * FROM fotos WHERE Titulo='$tituloFoto'";
				$fotoFichero = $mysqli->query($sentencia3);

				if(!$fotoFichero || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
				{
					die("Error: no se pudo realizar la consulta: " . $mysqli->error);
				}

				$filaFotoFichero = $fotoFichero->fetch_assoc();

				$idPais2 =  $filaFotoFichero['Pais'];

				if($idPais2!=NULL)
				{
					$sentencia4 = "SELECT * FROM paises WHERE IdPais=$idPais2";
					$nomPaisesSelec = $mysqli->query($sentencia4);  # Devuelve un objeto con el pais que tenga el mismo ID

					if(!$nomPaisesSelec || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
					{
						die("Error: no se pudo realizar la consulta: " . $mysqli->error);
					}
						
					$filaPais =  $nomPaisesSelec->fetch_assoc();
				}
				
				

		?>

		<article>
			<a href=<?php echo "'detalleFoto.php?id_foto=" . $filaFotoFichero['IdFoto'] . "' >"; ?> 
				<figure>
					<img <?php echo "src='" . $filaFotoFichero['Fichero'] . "'" ?> class="prov">
					<figcaption class="top-right">
						<div class="imgResume">
							<p><b><?php echo $filaFotoFichero['Titulo']; ?></b></p>
							<p>
							<?php 
								if($filaFotoFichero['Fecha']!=null)
								{
									echo str_replace('-', '/', date('d/m/Y', strtotime($filaFotoFichero['Fecha']))); 
								}
							?>
							</p>
							<p id="irPais">
								<?php 
									if( $idPais2 !=NULL )
									{
										echo $filaPais['NomPais'];
									}
								?>	
							</p>
						</div>
					</figcaption>
				</figure>
			</a>
		</article>

		<!--<p><Strong>Foto destacada por el crítico de fotografia </Strong><?php echo $autor; ?></p>
		<p><?php echo $comentario; ?></p> -->

		<?php 

			}
			/*$esChars = $mysqli->query("SET NAMES 'utf8'");*/
			$sentencia1 = "SELECT * FROM fotos ORDER BY FRegistro DESC LIMIT 5";
			$fotos = $mysqli->query($sentencia1);  # Devuelve un objeto con todas las fotos
			/*$esChars = $mysqli->query("SET NAMES 'utf8'"); */
			
			if(!$fotos || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
			{
				die("Error: no se pudo realizar la consulta: " . $mysqli->error);
			}

			while($fila = $fotos->fetch_assoc())  # Obtenemos el resultado fila a fila en forma de array asociativo
			{
				$idPais = $fila['Pais'];
				if( $idPais !=NULL )
				{
					$sentencia2 = "SELECT * FROM paises WHERE IdPais=$idPais";
					$nomPaises = $mysqli->query($sentencia2);  # Devuelve un objeto con el pais que tenga el mismo ID

					if(!$nomPaises || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
					{
						die("Error: no se pudo realizar la consulta: " . $mysqli->error);
					}
					$fila2 =  $nomPaises->fetch_assoc();
				}
		?>
		<article>
			<a href=<?php echo "'detalleFoto.php?id_foto=" . $fila['IdFoto'] . "' >"; ?> 
				<figure>
					<img <?php echo "src='" . $fila['Fichero'] . "'" ?> class="prov">
					<figcaption class="top-right">
						<div class="imgResume">
							<p><b><?php echo $fila['Titulo']; ?></b></p>
							<p>
							<?php 
								if($fila['Fecha']!=null)
								{
									echo str_replace('-', '/', date('d/m/Y', strtotime($fila['Fecha']))); 
								}
							?>
							</p>
							<p id="irPais">
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

		<?php

			}

			# Cerramos la sesion y liberamos la memoria
			$fotos ->free();

			$mysqli->close();

		?>
	</section>

	<?php
		require_once("includes/pie.inc");  # Pie de la pagina con el copyright
	?>

</body>
</html>