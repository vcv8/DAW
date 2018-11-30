<?php
	session_start(); # Inicializamos la gestion de sesiones

	require_once("includes/conexionBD.inc"); # Comprobamos la conexion a la base de datos

	if(!isset($_SESSION["usuario"])){
		if(isset($_COOKIE["recordar"])){
			$host = $_SERVER['HTTP_HOST']; 
			$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
			$extra = 'P8/controlAcces.php?msg=buscar.php'; 
			header("Location: http://$host$uri/$extra");
			exit;
		}	 
	}else{
		require_once("includes/mBienvenida.inc");
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0" /> <!-- Para que se pueda aplicar un diseño adaptable y la correcta visualizacion en dispo móviles -->
	<title>PRETI/buscar</title>
	
	<?php
		require("includes/estilos.inc");  # Contiene todos los enlaces con el css necesario para las paginas
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
		
	?>

	<section id="busquedaAvanzada">
		<fieldset class="marcoBusqueda">
			<h2>Búsqueda Avanzada</h2>
			<form action="resBuscar.php" method="GET">
				<p><label><b>Título </b></label><input class="boxesAlbum" type="text" name="titulo" placeholder=" Amanecer..."></p>
				<?php
						#Obtenemos los paises disponibles
						$sentencia1 = "SELECT NomPais FROM paises";
						$pais = $mysqli->query($sentencia1);  
						if(!$pais || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
						{
							die("Error: no se pudo realizar la consulta: " . $mysqli->error);
						}
				?>
				<p><label><b>Pais</b></label>
					<select class="direccion" name="pais">
						<option disabled selected value> - Selección pais - </option>
						<?php 
							while($fila1 = $pais->fetch_assoc())  # Obtenemos el resultado fila a fila en forma de array asociativo
							{

						?>
						<option value="<?php echo $fila1['NomPais']; ?>"><?php echo $fila1['NomPais']; ?></option>
						<?php 
							}
						?>
					</select>
				</p>
				<p><label><b>Fecha entre </b></label> <input class="boxesAlbum" type="date" name="fechaInicial"> <b> y </b> <input class="boxesAlbum" type="date" name="fechaFinal"></p>
				<p><input id="buscarFotos" type="submit" value="Buscar Fotos"></p>
			</form>
		</fieldset>
	</section>

	<?php
		# Cerramos la sesion con la BD y liberamos la memoria
		$pais ->free();
		$mysqli->close();
		require("includes/pie.inc");  # Pie de la pagina con el copyright
	?>
	
</body>
</html>