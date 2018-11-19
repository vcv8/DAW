<?php
	session_start(); # Inicializamos la gestion de sesiones
	
	if(!isset($_SESSION["usuario"])){
		if(isset($_COOKIE["recordar"])){
			$host = $_SERVER['HTTP_HOST']; 
			$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\');
			$extra = 'P7/controlAcces.php?msg=usuarioRegistrado.php'; 
			header("Location: http://$host$uri/$extra");
			exit;
		}

		$host = $_SERVER['HTTP_HOST']; 
		$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
		$extra = 'P7/login.php?Error1=accesoUsuarioNoRegistrado'; 
		header("Location: http://$host$uri/$extra");
		exit;	
	}
	else{
		$dia = date('d');
		$mes = date('F');
		$anyo = date('Y');
		$hora = date('h');
		$min = date('i');
		$sec = date('s');
		$pm = date('A');
		setcookie("lasttime" . $_SESSION["usuario"], "Bienvenido " . $_SESSION['usuario'] . ", no te veíamos desde el día $dia de $mes de $anyo a las $hora:$min:$sec $pm.", time() + (100 * 24 * 60 * 60));
		if (!isset($_COOKIE['firsttime']))
		{
		    setcookie("firsttime", "no");

		    if(isset($_COOKIE['lasttime' . $_SESSION["usuario"]])){
		    	$saludo = '<p id="errorMSG">' . $_COOKIE['lasttime' . $_SESSION["usuario"]] . '</p>';
		    }
		}
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
					<li><p class="listaInfo"><b>Correo </b> pepitodelospalotes@hotmail.com</p></li>
					<li><p><b>Sexo </b> Hombre</p></li>
					<li><p><b>Fecha de Nacimiento </b> 12/09/1968</p></li>
					<li><p><b>Ciudad </b> Valencia</p></li>
					<li><p><b>País </b> España</p></li>
					<li><p><b>Álbumes </b></p>
						<p class="menu display-great display-medium"><a class="enlacesUsuario" href="usuarioRegistrado.php" title="Accede a tu lista de Álbumes">Mis Álbumes</a> <a class="enlacesUsuario" href="crearAlbum.php" title="Crea un nuevo Álbum">Crear Álbum</a> <a class="enlacesUsuario" href="solicitudAlbum.php" title="Solicita la impresion de un Álbum">Solicitar Álbum</a> </p>

						<p class="display-mini"><a class="enlacesUsuario" href="usuarioRegistrado.php" title="Accede a tu lista de Álbumes">Mis Álbumes</a></p> <p class="display-mini"> <a class="enlacesUsuario" href="crearAlbum.php" title="Crea un nuevo Álbum">Crear Álbum</a></p> <p class="display-mini"> <a class="enlacesUsuario" href="solicitudAlbum.html" title="Solicita la impresion de un Álbum">Solicitar Álbum</a> </p>
					</li>
				</ul>
				<hr class="display-mini">
				<div id="Modificar-Borrar">
					<p class="menu display-great display-medium"><a class="enlacesUsuario" href="usuarioRegistrado.php" title="Modifica tus datos personales">Modificar datos</a>
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
		require_once("includes/pie.inc");  # Pie de la pagina con el copyright
	?>

</body>
</html>
<?php 
	}
?>