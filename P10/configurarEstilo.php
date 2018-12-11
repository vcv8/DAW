<?php
	session_start(); # Inicializamos la gestion de sesiones

	require_once("includes/conexionBD.inc"); # Comprobamos la conexion a la base de datos
	
	if(!isset($_SESSION["usuario"])){  # Si el usuario no ha iniciado sesion no puede acceder al detalle de foto
		if(isset($_COOKIE["recordar"])){
			$host = $_SERVER['HTTP_HOST']; 
			$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
			$f_id = $_GET['id_foto'];
			$extra = "P10/controlAcces.php?msg=detalleFoto.php?id_foto=$f_id"; 
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
	<title>PRETI/Configuración</title>

	<?php
		require_once("includes/estilos.inc");  # Contiene todos los enlaces con el css necesario para las paginas
	?>

</head>
<body>

	<?php
		require_once("includes/cabecera1.inc");  # Cabecera de la pagina con el logo, login y registro
	?>

	<section class="Inicio-Registro">
		<?php
			#Comprobamos el estilo que tiene actualmente el usuario
			$usuario = $_SESSION["usuario"];
			$eActual = $mysqli->query("SELECT IdEstilo, e.Nombre FROM usuarios INNER JOIN estilos e ON Estilo=IdEstilo WHERE NomUsuario='$usuario'");  
			if(!$eActual || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
			{
				die("Error: no se pudo realizar la consulta: " . $mysqli->error);
			}

			$fila = $eActual->fetch_assoc();

			#Obtenemos todods los estilos disponibles
			$sentencia1 = "SELECT IdEstilo, Nombre FROM estilos";
			$estilo = $mysqli->query($sentencia1);  
			if(!$estilo || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
			{
				die("Error: no se pudo realizar la consulta: " . $mysqli->error);
			}

			if($_GET){
				if(isset($_GET["enuevo"])){
					#Lanzamos mensaje si se ha cambiado el estilo correctamente
					echo '<p id="errorMSG">El estilo ha cambiado a: <span>'. $fila["Nombre"] .'</span>.</p>';
				}
			}
		?>
		<fieldset class="marcoInicioRegistro">
			<h2>Configurar Estilo de Página</h2>
			<form action="updateEstilo.php" method="GET">
				<p><select class="boxesForm" name="estilo" required>
						<option disabled value> - Selección del estilo - </option>
						<?php 
							while($fila1 = $estilo->fetch_assoc())  # Obtenemos el resultado fila a fila en forma de array asociativo
							{
						?>
						<option value="<?php echo $fila1['IdEstilo']; ?>" <?php if($fila['IdEstilo']==$fila1['IdEstilo']){echo 'selected';} ?> ><?php echo $fila1['Nombre']; ?></option>
						<?php 
							}
						?>
				</select></p>
				<p><input class="enlaceBoton" type="submit" value="Seleccionar" title="Seleccion del nuevo estilo de pagina"></p>
			</form>
		</fieldset>
	</section>

	<?php
		# Cerramos la sesion con la BD y liberamos la memoria
		$estilo ->free();
		$mysqli->close();
		require_once("includes/pie.inc");  # Pie de la pagina con el copyright
	?>
	
</body>
</html>
<?php 
	}
?>