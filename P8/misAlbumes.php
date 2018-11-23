<?php
	session_start(); # Inicializamos la gestion de sesiones

	require_once("includes/conexionBD.inc"); # Contiene los datos de conexion al servidor
	
	if(!isset($_SESSION["usuario"])){
		if(isset($_COOKIE["recordar"])){
			$host = $_SERVER['HTTP_HOST']; 
			$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\');
			$extra = "P8/controlAcces.php?msg=misAlbumes.php"; 
			$plus = '?user=' . $_GET['user'];
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
	<title>PRETI/misAlbumes</title>

	<?php
		require_once("includes/estilos.inc");  # Contiene todos los enlaces con el css necesario para las paginas
	?>
</head>
<body>

	<?php
		require_once("includes/cabecera1.inc");  # Cabecera de la pagina con solo logo

		if($_GET)
		{
			if(isset($_GET['user']))
			{ 
				$usuario = $_GET['user'];
				/*echo $usuario;*/
				$fusu = $mysqli->query("SELECT IdUsuario FROM usuarios WHERE NomUsuario='$usuario'");
				$fusu2 = $fusu->fetch_assoc();

				if($fusu2){

					$usuario = $fusu2['IdUsuario'];
					$falbum = $mysqli->query("SELECT Titulo, Descripción FROM albumes WHERE Usuario=$usuario");
					$falbum2 = $falbum->fetch_assoc();

					if($falbum2){
		?>
		<section>
			<article id="tablaTarifas">
				<table>
					<caption><b>Álbumes de <?php echo $_GET['user']; ?></b></caption>
					<tr>
						<th>Título</th>
						<th>Descripción</th>
					</tr>
					<tr>
						<?php
							echo '<td><a class="abasico" href="album.php?alb='. $falbum2['Titulo'] .'">'. $falbum2['Titulo'] .'</a></td><td>'. $falbum2['Descripción'] .'</td>';
							while ($falbum2 = $falbum->fetch_assoc()) {
								echo '<td><a class="abasico" href="album.php?alb='. $falbum2['Titulo'] .'">'. $falbum2['Titulo'] .'</a></td><td>'. $falbum2['Descripción'] .'</td>';
							}
						?>
					</tr>
				</table>
			</article>
		</section>
		<?php				
					}else{
						#Error No Albumes tuyos
						echo '<p id="errorMSG"> No tienes ningún álbum a tu nombre. <a href="usuarioRegistrado.php">Volver a perfil</a>.</p>';
					}
				}else{
					#Error no hay ese usuario
					echo '<p id="errorMSG">¡<span>ERROR</span>! No conozco al usuario '. $_GET['user'] .'. <a href="usuarioRegistrado.php">Volver a perfil</a>.</p>';
				}
			}else{
				#Error no se aespecificado usuario
				echo '<p id="errorMSG">¡<span>ERROR</span>! No se ha especificado usuario. <a href="usuarioRegistrado.php">Volver a perfil</a>.</p>';
			}
		}else{
			#Error no se aespecificado usuario
			echo '<p id="errorMSG">¡<span>ERROR</span>! No se ha especificado usuario. <a href="usuarioRegistrado.php">Volver a perfil</a>.</p>';
		}

		require_once("includes/pie.inc");  # Pie de la pagina con el copyright
	?>

</body>
</html>
<?php
	}
?>