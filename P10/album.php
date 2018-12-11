<?php
	session_start(); # Inicializamos la gestion de sesiones

	require_once("includes/conexionBD.inc"); # Contiene los datos de conexion al servidor
	
	if(!isset($_SESSION["usuario"])){
		if(isset($_COOKIE["recordar"])){
			$host = $_SERVER['HTTP_HOST']; 
			$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\');
			$extra = "P10/controlAcces.php?msg=misAlbumes.php"; 
			$plus = '?alb=' . $_GET['alb'];
			header("Location: http://$host$uri/$extra$plus");
			exit;
		}

		$host = $_SERVER['HTTP_HOST']; 
		$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
		$extra = 'P10/login.php?Error1=accesoUsuarioNoRegistrado'; 
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
					$ffoto = $mysqli->query("SELECT IdFoto , Titulo , Pais , Fichero , Fecha , Alternativo FROM fotos WHERE Album=$album");
					
					if ($ffoto->num_rows > 0) {
						$ffotoalt = $mysqli->query("SELECT DISTINCT MIN(Fecha) minimo, MAX(Fecha) maximo FROM fotos WHERE Album=$album");
						$ffotops = $mysqli->query("SELECT DISTINCT IdPais , Pais , NomPais FROM fotos f , paises p WHERE f.Pais=p.IdPais and f.Album=$album");

						$ffotoalt2 = $ffotoalt->fetch_assoc();
						if($ffotoalt2['minimo'] != NULL || $ffotoalt2['minimo'] != NULL){
							echo "<p>Fecha entre <b>". str_replace('-', '/', date('d/m/Y', strtotime($ffotoalt2['minimo']))) ."</b> y <b>". str_replace('-', '/', date('d/m/Y', strtotime($ffotoalt2['maximo']))) ."</b></p>";
						}else{
							echo "<p>No hay fechas registradas.</p>";
						}
						if($ffotops->num_rows > 0){
							echo "<p>Países: <b>";
							while ($ffotops2 = $ffotops->fetch_assoc()) {
							 	echo $ffotops2['NomPais'] . ' ';
							 } 
							echo "</b></p>";
						}else{
							echo "<p>No hay países registrados.</p>";
						}
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
								<p><?php if($ffoto2['Fecha']!=NULL){ echo str_replace('-', '/', date('d/m/Y', strtotime($ffoto2['Fecha']))); } ?></p>
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