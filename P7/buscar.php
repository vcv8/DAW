<?php
	session_start(); # Inicializamos la gestion de sesiones

	if(!isset($_SESSION["usuario"])){
		if(isset($_COOKIE["recordar"])){
			$host = $_SERVER['HTTP_HOST']; 
			$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
			$extra = 'P7/controlAcces.php?msg=buscar.php'; 
			header("Location: http://$host$uri/$extra");
			exit;
		}	 
	}else{
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
		}
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
				<p><label><b>Título </b></label><input class="boxesAlbum" type="text" name="titulo" placeholder=" Amanecer..." required></p>
				<p><label><b>País </b></label><input class="boxesAlbum" type="text" name="pais" placeholder=" España..."required></p>
				<p><label><b>Fecha entre </b></label> <input class="boxesAlbum" type="date" name="fechaInicial" required> <b> y </b> <input class="boxesAlbum" type="date" name="fechaFinal" required></p>
				<p><input id="buscarFotos" type="submit" value="Buscar Fotos"></p>
			</form>
		</fieldset>
	</section>

	<?php
		require("includes/pie.inc");  # Pie de la pagina con el copyright
	?>
	
</body>
</html>