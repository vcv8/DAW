<?php
	session_start(); # Inicializamos la gestion de sesiones

	require_once("includes/conexionBD.inc"); # Contiene los datos de conexion al servidor
	
	if(!isset($_SESSION["usuario"])){
		if(isset($_COOKIE["recordar"])){
			$host = $_SERVER['HTTP_HOST']; 
			$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\');
			$extra = 'P8/controlAcces.php?msg=usuarioRegistrado.php'; 
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
		require_once("includes/mBienvenidaIU.inc");
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0" /> <!-- Para que se pueda aplicar un diseño adaptable y la correcta visualizacion en dispo móviles -->


	<?php

		if(isset($_SESSION["usuario"]))
		{
			echo "<title>PRETI/" . $_SESSION["usuario"] . "</title>";
		}
		else
		{

	?>

		<title>PRETI/usuarioRegistrado</title>

	<?php
	
		}
		require_once("includes/estilos.inc");  # Contiene todos los enlaces con el css necesario para las paginas
	?>

</head>
<body>

	<?php
		require_once("includes/cabecera1.inc");  # Cabecera de la pagina con el logo, login y registro
	?>

	<!-- Seccion que contiene la foto de perfil del usuario, sus datos, enlaces .... -->
	<section>
		<div id="FotoPerfil">
			<img src="recursos/EjemploPerfil.png" alt="Foto Perfil" id="fotoPerfil">
			<p id="NombreUsuario">
				<?php 
					if(isset($_SESSION["usuario"]))
					echo "<b>" . $_SESSION["usuario"] . "</b>" 
				?>
			</p>
			<p class="display-great"><a class="enlacesUsuario" href="cierreSesion.php" title="Cierra sesión en este dispositivo"> Cerrar Sesión</a></p>
		</div>

		<?php
			if(isset($_SESSION["usuario"])){
				if (!isset($_COOKIE['firsttime']))
				{
					if(isset($_COOKIE['lasttime' . $_SESSION["usuario"]])){
						echo "$saludo";
					}
				}
			}
		?>

		<div>
			<fieldset class="marcoUsuario">
				<h2>Detalles de Usuario</h2>
				<ul id="InfoUsuario"> <!-- Lista de datos del Usuario -->
					<?php 
						#Comprobamos que usuario es 
						$usuario = $_SESSION["usuario"];
						$sentencia1 = "SELECT * FROM usuarios WHERE NomUsuario='$usuario'";
						$usuario = $mysqli->query($sentencia1);  
						if(!$usuario || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
						{
							die("Error: no se pudo realizar la consulta: " . $mysqli->error);
						}

						$fila = $usuario->fetch_assoc();

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

					?>
					<li><p class="listaInfo"><b>Correo </b> <?php echo $fila['Email']; ?></p></li>
					<li><p><b>Sexo </b> 
					<?php
						if($fila['Sexo'] == 1)
						{
							echo "Mujer";
						}
						else
						{
							echo "Hombre";
						}
					 ?>
					</p></li>
					<li><p><b>Fecha de Nacimiento </b> <?php echo $fila['FNacimiento']; ?></p></li>
					<li><p><b>Ciudad </b> <?php echo $fila['Ciudad']; ?></p></li>
					<li><p><b>País </b> <?php echo $fila2['NomPais']; ?></p></li>
					<li><p><b>Estilo de Página </b></p> <p class="menu display-great display-medium"><a class="enlacesUsuario" href="configurarEstilo.php" title="Accede a tu lista de Álbumes">Cambiar Estilo</a> </p> 
					</li>
					<li><p><b>Álbumes </b></p>
						<p class="menu display-great display-medium"><a class="enlacesUsuario" href="usuarioRegistrado.php" title="Accede a tu lista de Álbumes">Mis Álbumes</a> <a class="enlacesUsuario" href="crearAlbum.php" title="Crea un nuevo Álbum">Crear Álbum</a> <a class="enlacesUsuario" href="solicitudAlbum.php" title="Solicita la impresion de un Álbum">Solicitar Álbum</a> </p>

						<p class="display-mini"><a class="enlacesUsuario" href="usuarioRegistrado.php" title="Accede a tu lista de Álbumes">Mis Álbumes</a></p> <p class="display-mini"> <a class="enlacesUsuario" href="crearAlbum.php" title="Crea un nuevo Álbum">Crear Álbum</a></p> <p class="display-mini"> <a class="enlacesUsuario" href="solicitudAlbum.html" title="Solicita la impresion de un Álbum">Solicitar Álbum</a> </p>
					</li>
				</ul>
				<hr class="display-mini">
				<div id="Modificar-Borrar">
					<p class="menu display-great display-medium"><a class="enlacesUsuario" href="modDatos.php" title="Modifica tus datos personales">Modificar datos</a>
					<a class="enlacesUsuario" href="usuarioRegistrado.php" title="Darte de baja en Preti">Darme de Baja</a></p>

					<p class="display-mini"><a class="enlacesUsuario" href="usuarioRegistrado.php" title="Modifica tus datos personales">Modificar datos</a></p>
					<p class="display-mini"> <a class="enlacesUsuario" href="usuarioRegistrado.php" title="Darte de baja en Preti">Darme de Baja</a></p>
				</div>
			</fieldset>
			<div class="menu display-mini display-medium" >
				<a id="cierreSesion" href="cierreSesion.php" title="Cierra sesión en este dispositivo"> Cerrar Sesión</a>
			</div>
	</section>

	<?php

		# Cerramos la sesion con la BD y liberamos la memoria
		$usuario ->free();
		$mysqli->close();

		require_once("includes/pie.inc");  # Pie de la pagina con el copyright
	?>

</body>
</html>
<?php 
	}
?>