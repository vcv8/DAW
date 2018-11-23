<?php
	session_start(); # Inicializamos la gestion de sesiones

	require_once("includes/conexionBD.inc"); # Comprobamos la conexion a la base de datos
	
	if(!isset($_SESSION["usuario"])){  # Si el usuario no ha iniciado sesion no puede acceder al detalle de foto
		if(isset($_COOKIE["recordar"])){
			$host = $_SERVER['HTTP_HOST']; 
			$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
			$extra = "P8/controlAcces.php?msg=detalleFoto.php"; 
			$plus = '?id_foto=' . $_GET['id_foto'];
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
			if(!isset($_GET['id_foto'])){
				echo '<p id="errorMSG">¡<span>ERROR</span>! La ID de la foto introducida es errónea.</p>';
			}else{
				if (!is_numeric($_GET['id_foto'])) {
					echo '<p id="errorMSG">¡<span>ERROR</span>! La ID de la foto introducida es errónea.</p>';
				}else
				{
					$id = $_GET['id_foto'];

					# Obtenemos la foto por su ID
					$sentencia = "SELECT * FROM fotos WHERE IdFoto=$id";
					$foto = $mysqli->query($sentencia);  # Devuelve un objeto con la foto que tenga esa id

					if(!$foto || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
					{
						die("Error: no se pudo realizar la consulta: " . $mysqli->error);
					}

					$fila = $foto->fetch_assoc();

					# Obtenemos el nombre del pais por su ID
					$idPais = $fila['Pais'];

					if( $idPais !=NULL ) # Comprobamos que tenga un pais asociado primero
					{
						$sentencia2 = "SELECT * FROM paises WHERE IdPais=$idPais";
						$pais = $mysqli->query($sentencia2);  # Devuelve un objeto con el pais que tiene ese ID
						if(!$pais || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
						{
							die("Error: no se pudo realizar la consulta: " . $mysqli->error);
						}
						$fila2 =  $pais->fetch_assoc();
					}

					#Obtenemos el nombre del Album por su ID
					$idAlbum = $fila['Album'];
					$sentencia3 = "SELECT * FROM albumes WHERE IdAlbumes=$idAlbum";
					$album = $mysqli->query($sentencia3);  # Devuelve un objeto con el album que tiene ese ID
					if(!$album || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
					{
						die("Error: no se pudo realizar la consulta: " . $mysqli->error);
					}
					$fila3 =  $album->fetch_assoc();

					# Obtenemos el nombre de usuario al que pertenece el album por su ID
					$idUsuario = $fila3['Usuario'];
					$sentencia4 = "SELECT * FROM usuarios WHERE IdUsuario=$idUsuario";
					$usuario = $mysqli->query($sentencia4);  
					if(!$usuario || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
					{
						die("Error: no se pudo realizar la consulta: " . $mysqli->error);
					}
					$fila4 =  $usuario->fetch_assoc();
		?>
			<figure>
				<div>
					<img src="<?php echo $fila['Fichero'];?>" alt="Foto con mas detalle" class="imagen2">
				</div>
				<figcaption>
					<h2><?php echo $fila['Titulo'];?></h2>
					<p class="info">Tomada el 
					<?php
						if($fila['Fecha']!=null)
						{
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
						<p>Por <a href="misAlbumes.php?user=<?php echo $fila4['NomUsuario']; ?>" title="Acceso a albumes del usuario"><?php echo $fila4['NomUsuario']; ?></a></p>
					</div>
				</figcaption>
			</figure>


		<?php
				}
			}

			# Cerramos la sesion con la BD y liberamos la memoria
			$foto ->free();
			$album ->free();
			$usuario ->free();
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