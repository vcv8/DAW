<?php
	session_start(); # Inicializamos la gestion de sesiones

	require_once("includes/conexionBD.inc"); # Comprobamos la conexion a la base de datos
	
	if(!isset($_SESSION["usuario"])){  # Si el usuario no ha iniciado sesion no puede acceder al detalle de foto
		if(isset($_COOKIE["recordar"])){
			$host = $_SERVER['HTTP_HOST']; 
			$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
			$extra = "P10/controlAcces.php?msg=resRegistro.php"; 
			header("Location: http://$host$uri/$extra");
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
	<title>PRETI/solicitud</title>

	<?php
		require("includes/estilos.inc");  # Contiene todos los enlaces con el css necesario para las paginas
	?>
	
</head>
<body>
	
	<?php
		require("includes/cabecera1.inc");  # Cabecera de la pagina con el logo, login y registro
	?>

	<section class="Inicio-Registro">
		<fieldset class="marcoInicioRegistro">
			<h2>Confirmación de solicitud</h2>

			<?php
				if($_GET && isset($_GET['sid']) && is_numeric($_GET['sid'])){
					$usuario = $_SESSION['usuario'];
					$id = $_GET['sid'];
					$sentencia1 = "SELECT Album, Coste, albumes.Titulo FROM solicitudes JOIN albumes ON Album=IdAlbumes JOIN usuarios ON Usuario=IdUsuario WHERE IdSolicitud=$id AND NomUsuario='$usuario' ORDER BY idSolicitud DESC LIMIT 1"; #Obtenemos el ultimo album insertado
					$ultSolicitud = $mysqli->query($sentencia1);  

					if(!$ultSolicitud || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
					{
						die("Error: no se pudo realizar la consulta: " . $mysqli->error);
					}

					$fila = $ultSolicitud->fetch_assoc();

					if($fila){
						$album= $fila['Album'];
						$total = $fila['Coste'];
						$nomAlbum= $fila['Titulo'];

						echo "<p>Se ha registrado su solicitud de impresión para el album <b>$nomAlbum</b> <p>";
						echo "<p>El coste total de la operación son <b>$total €</b>.</p>";

					}else{
						echo '<p id="errorMSG">¡<span>ERROR</span>! ID de solicitud incorrecto.</p>';
					}
					#Cerramos conexion con el SGBD
					$ultSolicitud ->free();
					$mysqli->close();
				}else{
					echo '<p id="errorMSG"> No hay solicitudes pendientes.</p>';
				}
			?>
			<a href="usuarioRegistrado.php" class="swaplink">Volver a mi perfil.</a>
		</fieldset>
	</section>

	<?php
		require("includes/pie.inc");  # Pie de la pagina con el copyright
	?>
	
</body>
</html>
<?php 
	}
?>