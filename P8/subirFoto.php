<?php
	session_start(); # Inicializamos la gestion de sesiones

	require_once("includes/conexionBD.inc"); # Contiene los datos de conexion al servidor
	
	if(!isset($_SESSION["usuario"])){
		if(isset($_COOKIE["recordar"])){
			$host = $_SERVER['HTTP_HOST']; 
			$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\');
			$extra = 'P8/controlAcces.php?msg=subirFoto.php'; 
			header("Location: http://$host$uri/$extra");
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
	<title>PRETI/Subir Foto</title>

	<?php
		require_once("includes/estilos.inc");  # Contiene todos los enlaces con el css necesario para las paginas
	?>
</head>
<body>

	<?php
		require_once("includes/cabecera1.inc");  # Cabecera de la pagina con solo logo
	?>
	
	<section class="Inicio-Registro"> <!--Formulario de Registro -->
		<fieldset class="marcoInicioRegistro">
			<h2>Añadir nueva foto</h2>
			<form action="usuarioRegistrado.php" method="GET">
				<p><label>Título de la foto:</label></p>
				<p><input class="boxesForm" type="text" name="Titulo" placeholder="Título" required></p>
				<p><label>Descripción:</label></p>
				<p><input class="boxesForm" type="text" name="Descripcion" placeholder="Descripción" required></p>
				<p><label>¿Cuándo se tomó la foto?</label></p>
				<p>
					<select required class="mes" name="Mes">
							<option disabled selected value selected="selected" >  Mes  </option>
						  	<option value="1">Enero</option>
						  	<option value="2">Febrero</option>
						  	<option value="3">Marzo</option>
					</select>
					<input class="diaMes" type="number" name="Dia" placeholder="Día" max="31" min="1"> <input class="diaMes"  type="number" name="Año" placeholder="Año" max="2000" min="1918">
			    </p>
			    <p><label>¿En qué país?</label></p>
			    <?php
					#Obtenemos los paises disponibles
					$pais = $mysqli->query("SELECT NomPais FROM paises");  
					if(!$pais || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
					{
						die("Error: no se pudo realizar la consulta: " . $mysqli->error);
					}
				?>
				<select class="boxesForm" name="pais">
					<option disabled selected value> - Selección del Pais - </option>
						<?php 
							while($fila1 = $pais->fetch_assoc())  # Obtenemos el resultado fila a fila en forma de array asociativo
							{

						?>
					<option value="<?php echo $fila1['NomPais'] ?>"><?php echo $fila1['NomPais'] ?></option>
						<?php 
							}

							# Cerramos la sesion con la BD y liberamos la memoria
							$pais ->free();
						?>
				</select>
				<p><label>Foto:</label></p>
				<p><input type="file" name="pic" accept="image/*"></p>
				<p><label>Texto alternativo para la foto:</label></p>
				<p><input class="boxesForm" type="text" name="tAlternativo" placeholder="Texto alternativo" required></p>
				<p><label>Álbum al que pertenece:</label></p>
				<?php
					#Comprobamos que usuario es 
					$usuario = $_SESSION["usuario"];
					$usuario = $mysqli->query("SELECT IdUsuario FROM usuarios WHERE NomUsuario='$usuario'");  
					if(!$usuario || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
					{
						die("Error: no se pudo realizar la consulta: " . $mysqli->error);
					}

					$fila = $usuario->fetch_assoc();

					# Obtenemos los albumes del usuario
					$idUsu = $fila['IdUsuario'];
					$album = $mysqli->query("SELECT Titulo FROM albumes WHERE Usuario=$idUsu");  
					if(!$album || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
					{
						die("Error: no se pudo realizar la consulta: " . $mysqli->error);
					}

				?>
				<select class="boxesForm" name="album" required>
					<option disabled selected value> - Mis álbumes - </option>
					<?php 
						while($fila2 = $album->fetch_assoc())  # Obtenemos el resultado fila a fila en forma de array asociativo
						{

					?>
					<option value="<?php echo $fila2['Titulo'] ?>"><?php echo $fila2['Titulo'] ?></option>
					<?php 
						}

						# Cerramos la sesion con la BD y liberamos la memoria
						$album ->free();
						$usuario ->free();
						$mysqli->close();
					?>
				</select>
				<p><input class="enlaceBoton" type="submit" value="Añadir" title="Añadir"></p>
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