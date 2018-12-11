<?php
	session_start(); # Inicializamos la gestion de sesiones

	require_once("includes/conexionBD.inc"); # Comprobamos la conexion a la base de datos

	if(!isset($_SESSION["usuario"])){
		if(isset($_COOKIE["recordar"])){
			$host = $_SERVER['HTTP_HOST']; 
			$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
			$extra = 'P10/controlAcces.php?msg=crearAlbum.php'; 
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

		$sentencia1 = "SELECT Titulo, Descripción FROM albumes ORDER BY idAlbumes DESC LIMIT 1"; #Obtenemos el ultimo album insertado
		$ultAlbum = $mysqli->query($sentencia1);  

		if(!$ultAlbum || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
		{
			die("Error: no se pudo realizar la consulta: " . $mysqli->error);
		}

		$fila = $ultAlbum->fetch_assoc();

		$titulo = $fila['Titulo'];
		$descripcion = $fila['Descripción'];
	?>
	<section class="Inicio-Registro">
		<fieldset class="marcoInicioRegistro">
			
			<h2>Confirmación de creación del album :</h2>
			<p><b>Titulo: </b><?php echo $titulo; ?></p>
			<p><b>Descripcion: </b><?php echo $descripcion; ?></p>
			<p>¿Quiere subir su primera fotografía en este album? <a href="subirFoto.php" class="swaplink">Subir foto</a>.</p>
			<a href="usuarioRegistrado.php" class="swaplink">Volver a mi perfil</a>
			
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