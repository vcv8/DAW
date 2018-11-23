<?php
	session_start(); # Inicializamos la gestion de sesiones

	require_once("includes/conexionBD.inc"); # Contiene los datos de conexion al servidor
	
	if(!isset($_SESSION["usuario"])){
		if(isset($_COOKIE["recordar"])){
			$host = $_SERVER['HTTP_HOST']; 
			$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\');
			$extra = "P8/controlAcces.php?msg=misAlbumes.php"; 
			$plus = '?alb=' . $_GET['alb'];
			header("Location: http://$host$uri/$extra$plus");
			exit;
		}

		$host = $_SERVER['HTTP_HOST']; 
		$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
		$extra = 'P8/login.php?Error1=accesoUsuarioNoRegistrado'; 
		header("Location: http://$host$uri/$extra");
		exit;	
	}
	else{
		require_once("includes/mBienvenida.inc");
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0" /> <!-- Para que se pueda aplicar un diseño adaptable y la correcta visualizacion en dispo móviles -->
	<title>PRETI/Album</title>

	<?php
		require_once("includes/estilos.inc");  # Contiene todos los enlaces con el css necesario para las paginas
	?>
</head>
<body>

	<?php
		require_once("includes/cabecera1.inc");  # Cabecera de la pagina con solo logo

		if($_GET)
		{
			if (isset($_GET['alb'])) {
				
				$album = $_GET['alb'];
				/*echo $album;*/
				$falbum = $mysqli->query("SELECT IdAlbumes , Descripción FROM albumes WHERE Titulo='$album'");
				$falbum2 = $falbum->fetch_assoc();
				if($falbum2){
					

					echo "<p><b>". $_GET['alb'] ."</b></p>
							  <p>". $falbum2['Descripción'] ."</p>";

					$album = $falbum2['IdAlbumes'];
					$ffoto = $mysqli->query("SELECT IdFoto , Titulo , Pais , Fichero , FRegistro , Alternativo FROM fotos WHERE Album=$album");
					$ffotoalt = $mysqli->query("SELECT MIN(FRegistro) minimo , MAX(FRegistro) maximo FROM fotos WHERE Album=$album");

					if ($ffoto && $ffotoalt) {
						$ffotoalt2 = $ffotoalt->fetch_assoc();
						echo "<p>Fecha entre <b>". $ffotoalt2['minimo'] ."</b> y <b>". $ffotoalt2['maximo'] ."</b></p>";
		?>
		<section class="preview">

			<?php
				while($ffoto2 = $ffoto->fetch_assoc())  # Obtenemos el resultado fila a fila en forma de array asociativo
				{
					$idPais = $ffoto2['Pais'];
					if( $idPais != NULL )
					{
						$fpaises = $mysqli->query("SELECT NomPais FROM paises WHERE IdPais=$idPais");  # Devuelve un objeto con el pais que tenga el mismo ID

						if(!$fpaises || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
						{
							die("Error: no se pudo realizar la consulta: " . $mysqli->error);
						}
						$fpaises2 = $fpaises->fetch_assoc();
					}
			?>
			<article>
				<a href=<?php echo "'detalleFoto.php?id_foto=" . $ffoto2['IdFoto'] . "' >"; ?> 
					<figure>
						<img <?php echo "src='" . $ffoto2['Fichero'] . "'" ?> class="prov" alt="<?php echo $ffoto2['Alternativo'] ?>">
						<figcaption class="top-right">
							<div class="imgResume">
								<p><b><?php echo $ffoto2['Titulo']; ?></b></p>
								<p><?php echo str_replace('-', '/', date('d F Y', strtotime($ffoto2['FRegistro']))); ?></p>
								<p><?php echo str_replace('-', '/', date('h:i:s A', strtotime($ffoto2['FRegistro']))); ?></p>
								<p id="irPais">
									<?php 
										if( $idPais != NULL )
										{
											echo $fpaises2['NomPais'];
										}
									?>	
								</p>
							</div>
						</figcaption>
					</figure>
				</a>
			</article>

			<?php
					if($idPais != NULL){
						$fpaises->free();
					}
				}
				# Liberamos la memoria
				$falbum->free();
				$ffoto->free();
				$ffotoalt->free();
			?>
		</section>
		<?php				
					}else{
						#Error No Albumes tuyos
						echo '<p id="errorMSG"> Este álbum no contiene fotos todavía.</p>';
					}
				}else{
					#Error no hay ese usuario
					echo '<p id="errorMSG">¡<span>ERROR</span>! No existe ese álbum.</p>';
				}
			}else{
				#Error no se aespecificado usuario
				echo '<p id="errorMSG">¡<span>ERROR</span>! No se ha especificado álbum.</p>';
			}
		}else{
			#Error no se aespecificado usuario
			echo '<p id="errorMSG">¡<span>ERROR</span>! No se ha especificado álbum.</p>';
		}

		require_once("includes/pie.inc");  # Pie de la pagina con el copyright
	?>

</body>
</html>
<?php
		# Cerramos la sesión
		$mysqli->close();
	}
?>