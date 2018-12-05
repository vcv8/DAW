<?php
	session_start(); # Inicializamos la gestion de sesiones

	require_once("includes/conexionBD.inc"); # Comprobamos la conexion a la base de datos
	
	if(!isset($_SESSION["usuario"])){  # Si el usuario no ha iniciado sesion no puede acceder al detalle de foto
		if(isset($_COOKIE["recordar"])){
			$host = $_SERVER['HTTP_HOST']; 
			$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
			$extra = "P9/controlAcces.php?msg=detalleFoto.php"; 
			$plus = '?id_foto=' . $_GET['id_foto'];
			header("Location: http://$host$uri/$extra$plus");
			exit;
		}

		$host = $_SERVER['HTTP_HOST']; 
		$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
		$extra = 'P9/login.php?Error1=accesoUsuarioNoRegistrado'; 
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
	<title>PRETI/detalleFoto</title>

	<?php
		require_once("includes/estilos.inc");  # Contiene todos los enlaces con el css necesario para las paginas
	?>

</head>
<body>

	<?php
		require_once("includes/cabecera3.inc");  # Cabecera de la pagina con el logo, login y registro
	?>

	<section id="detalle">
		<article>
		<?php
			if($_GET){
				if(isset($_GET['id_foto'])){
					if(is_numeric($_GET['id_foto'])){

						$id = $_GET['id_foto'];

						# Obtenemos la foto por su ID
						$sentencia = "SELECT Titulo, Fecha, Pais, Album, Fichero FROM fotos WHERE IdFoto=$id";
						$foto = $mysqli->query($sentencia);  # Devuelve un objeto con la foto que tenga esa id

						/*if(!$foto || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
						{
							die("Error: no se pudo realizar la consulta: " . $mysqli->error);
						}*/

						$fila = $foto->fetch_assoc();

						if($fila){

							# Obtenemos el nombre del pais por su ID
							$idPais = $fila['Pais'];

							if( $idPais !=NULL ) # Comprobamos que tenga un pais asociado primero
							{
								$sentencia2 = "SELECT NomPais FROM paises WHERE IdPais=$idPais";
								$pais = $mysqli->query($sentencia2);  # Devuelve un objeto con el pais que tiene ese ID
								if(!$pais || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
								{
									die("Error: no se pudo realizar la consulta: " . $mysqli->error);
								}
								$fila2 =  $pais->fetch_assoc();
							}

							#Obtenemos el nombre del Album y el usuario al que pertenece 
							$idAlbum = $fila['Album'];
							$sentencia3 = "SELECT Titulo, NomUsuario FROM albumes a, usuarios u WHERE IdAlbumes=$idAlbum AND IdUsuario=Usuario";
							$album = $mysqli->query($sentencia3);  # Devuelve un objeto con el album que tiene ese ID
							if(!$album || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
							{
								die("Error: no se pudo realizar la consulta: " . $mysqli->error);
							}
							$fila3 =  $album->fetch_assoc();				
		?>
			<figure>
				<div>
					<img src="<?php echo $fila['Fichero'];?>" alt="Foto con mas detalle" class="imagen2">
				</div>
				<figcaption>
					<h2><?php echo $fila['Titulo'];?></h2>
					<?php
						if($fila['Fecha']!=null)
						{
					?>
					<p class="info">Tomada el 
					<?php
						 	echo str_replace('-', '/', date('d-m-Y', strtotime($fila['Fecha'])));
						}
					  ?>
					 </p>
					<?php
							if( $idPais !=NULL )
							{
					?>
					<p class="info">en 
					<?php
								echo $fila2['NomPais'];
							}
					?>
					</p>
					<div>
						<p class="albuminfo">Pertenece al álbum <a href="album.php?alb=<?php echo $fila3['Titulo']; ?>" title="Acceso al album de Fotos">
						<?php 
							echo $fila3['Titulo'];
						?>
						</a>.
						</p>
						<p>Por <a href="misAlbumes.php?user=<?php echo $fila4['NomUsuario']; ?>" title="Acceso a albumes del usuario"><?php echo $fila3['NomUsuario']; ?></a></p>
					</div>
				</figcaption>
			</figure>


		<?php
					# Cerramos la sesion con la BD y liberamos la memoria
							$album ->free();
						}else{
							#Error ID incorrecto
							echo '<p id="errorMSG">¡<span>ERROR</span>! El ID introducido no corresponde con ninguna foto.</p>';
						}
						$foto ->free();
					}else{
						#Error ID incorrecto
						echo '<p id="errorMSG">¡<span>ERROR</span>! La ID de la foto introducida es errónea, debe tratarse de un ID numérico.</p>';
					}
				}else{
					#Error no se ha especificado id de foto
					echo '<p id="errorMSG">¡<span>ERROR</span>! No se ha especificado ID de foto.</p>';
				}
			}else{
				#Error no se ha especificado id de foto
				echo '<p id="errorMSG">¡<span>ERROR</span>! No se ha especificado ID de foto.</p>';
			}
			$mysqli->close();
		?>
		</article>
	</section>

	<?php
		require_once("includes/pie.inc");  # Pie de la pagina con el copyright
	?>
	
</body>
</html>
<?php 
	}
?>