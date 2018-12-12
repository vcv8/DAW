<?php
	session_start(); # Inicializamos la gestion de sesiones

	require_once("includes/conexionBD.inc"); # Contiene los datos de conexion al servidor
	
	if(!isset($_SESSION["usuario"])){
		if(isset($_COOKIE["recordar"])){
			$host = $_SERVER['HTTP_HOST']; 
			$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\');
			$extra = 'P10/controlAcces.php?msg=usuarioRegistrado.php'; 
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
		<?php
			if($_GET && isset($_GET['Update'])) #Nuevo usuario registrado
			{
				if($_GET && $_GET['Update']=="cambioDatos")
				{
					echo '<p id="errorMSG"><b>¡Cambios guardados!</b>.</p>';
				}
			}

			#Obtenemos los datos del usuario y el pais
			$usuario = $_SESSION["usuario"];
			$sentencia1 = "SELECT Email, Sexo, FNacimiento, Ciudad, Pais, NomPais, Foto FROM usuarios u, paises p WHERE NomUsuario='$usuario' AND u.Pais=p.IdPais";
			$usuario = $mysqli->query($sentencia1);  
			if(!$usuario || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
			{
				die("Error: no se pudo realizar la consulta: " . $mysqli->error);
			}

			$fila = $usuario->fetch_assoc();
						

		?>
		<div id="FotoPerfil">
			<img src="recursos/<?php echo $fila['Foto'] ?>" alt="Foto Perfil" id="fotoPerfil">
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
					<li><p><b>Fecha de Nacimiento </b> <?php echo str_replace('-', '/', date('d-m-Y', strtotime($fila['FNacimiento']))); ?></p></li>
					<li><p><b>Ciudad </b> <?php echo $fila['Ciudad']; ?></p></li>
					<li><p><b>País </b> <?php echo $fila['NomPais']; ?></p></li>
					<li><p><b>Estilo de Página </b></p> <p class="menu display-great display-medium"><a class="enlacesUsuario" href="configurarEstilo.php" title="Accede a la configuración de estilos">Cambiar Estilo</a> </p> 
					</li>
					<li><p><b>Fotos </b></p> <p class="menu display-great display-medium"><a class="enlacesUsuario" href="subirFoto.php" title="Accede a la página de subida de fotos">Subir Foto</a> </p> 
					</li>
					<li><p><b>Álbumes </b></p>
						<p class="menu display-great display-medium"><a class="enlacesUsuario" href="misAlbumes.php?user=<?php echo $_SESSION['usuario'] ?>" title="Accede a tu lista de Álbumes">Mis Álbumes</a> <a class="enlacesUsuario" href="crearAlbum.php" title="Crea un nuevo Álbum">Crear Álbum</a> <a class="enlacesUsuario" href="solicitudAlbum.php" title="Solicita la impresion de un Álbum">Solicitar Álbum</a> </p>

						<p class="display-mini"><a class="enlacesUsuario" href="usuarioRegistrado.php" title="Accede a tu lista de Álbumes">Mis Álbumes</a></p> <p class="display-mini"> <a class="enlacesUsuario" href="crearAlbum.php" title="Crea un nuevo Álbum">Crear Álbum</a></p> <p class="display-mini"> <a class="enlacesUsuario" href="solicitudAlbum.html" title="Solicita la impresion de un Álbum">Solicitar Álbum</a> </p>
					</li>
				</ul>
				<hr class="display-mini">
				<div id="Modificar-Borrar">
					<p class="menu display-great display-medium"><a class="enlacesUsuario" href="modDatos.php" title="Modifica tus datos personales">Modificar datos</a>
					<a class="enlacesUsuario" href="baja.php" title="Darte de baja en Preti">Darme de Baja</a></p>

					<p class="display-mini"><a class="enlacesUsuario" href="usuarioRegistrado.php" title="Modifica tus datos personales">Modificar datos</a></p>
					<p class="display-mini"> <a class="enlacesUsuario" href="baja.php" title="Darte de baja en Preti">Darme de Baja</a></p>
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