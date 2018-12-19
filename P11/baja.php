<?php
	session_start(); # Inicializamos la gestion de sesiones

	require_once("includes/conexionBD.inc"); # Comprobamos la conexion a la base de datos
	
	if(!isset($_SESSION["usuario"])){  # Si el usuario no ha iniciado sesion no puede acceder al detalle de foto
		if(isset($_COOKIE["recordar"])){
			$host = $_SERVER['HTTP_HOST']; 
			$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
			$extra = "P11/controlAcces.php?msg=baja.php";
			header("Location: http://$host$uri/$extra");
			exit;
		}

		$host = $_SERVER['HTTP_HOST']; 
		$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
		$extra = 'P11/login.php?Error1=accesoUsuarioNoRegistrado'; 
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
		require_once("includes/cabecera1.inc");  # Cabecera de la pagina con el logo, login y registro
	?>

	<?php 
		$usuario = $_SESSION['usuario'];

		$albumesen = $mysqli->query("SELECT a.IdAlbumes , a.Titulo FROM albumes a JOIN usuarios u ON a.Usuario=u.IdUsuario WHERE NomUsuario='$usuario'");
		$falbumesen = $albumesen->fetch_assoc();

		echo '<p id="errorMSG"><span>ATENCIÓN</span>. Te dispones a borrar definitivamente tu usuario y los siguientes álbumes:</p>';

		if($falbumesen){

			do{
				$album = $falbumesen['IdAlbumes'];
				$fotosen = $mysqli->query("SELECT COUNT(*) AS fotosEn FROM fotos f JOIN albumes a ON a.IdAlbumes=f.Album WHERE IdAlbumes=$album");
				$ffotosen = $fotosen->fetch_assoc();

				echo '<p id="errorMSG"><b>'. $falbumesen['Titulo'] .'</b> con '. $ffotosen['fotosEn'] .' fotos.</p>';

				$fotosen ->free();

			}while($falbumesen = $albumesen->fetch_assoc());

			$allfotos = $mysqli->query("SELECT COUNT(*) AS totalFotos FROM usuarios u JOIN albumes a ON a.Usuario=u.IdUsuario JOIN fotos f ON a.IdAlbumes=f.Album WHERE NomUsuario='$usuario'");
			$fallfotos = $allfotos->fetch_assoc();

			echo '<p id="errorMSG">Lo que suma un total de '. $fallfotos['totalFotos'] .' fotos.</p>';

			$allfotos ->free();

	?>

	<?php
		# Cerramos la sesion con la BD y liberamos la memoria
		}else{
			echo '<p id="errorMSG">Sin álbumes ni fotos que borrar.</p>';
		}
		$albumesen ->free();

		$mysqli->close();

		if($_GET && $_GET['err'] && $_GET['err']==1){
			echo '<p id="errorMSG">¡<span>ERROR</span>! La contraseña introducida es incorrecta.</p>';
		}
	?>
		<section class="Inicio-Registro"> <!--Formulario de Registro -->
			<fieldset class="marcoInicioRegistro">
				<form action="controlAcces.php?baja=1" method="POST">
					<p>Introduce tu contraseña para confirmar: </p>
					<p><input class="boxesForm" type="password" name="Contraseña" placeholder="Contraseña" required></p>
					<p><input class="enlaceBoton" type="submit" value="Confirmar Baja"></p>
					<p id="errorMSG"><a href="usuarioRegistrado.php">Cancelar</a></p>
				</form>
			</fieldset>
		</section>

	<?php
		require_once("includes/pie.inc");  # Pie de la pagina con el copyright
	?>
	
</body>
</html>
<?php 
	}
?>