<?php
	session_start(); # Inicializamos la gestion de sesiones

	require_once("includes/conexionBD.inc"); # Comprobamos la conexion a la base de datos
	
	if(!isset($_SESSION["usuario"])){
		if(isset($_COOKIE["recordar"])){
			$host = $_SERVER['HTTP_HOST']; 
			$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
			$extra = 'P9/controlAcces.php?msg=about.php'; 
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
	<title>PRETI/about</title>
	
	<?php
		require_once("includes/estilos.inc");  # Contiene todos los enlaces con el css necesario para las paginas
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

	<section>
		<article>
			<p>Página desarrollada por Alejandro Roca Vande Sype y Víctor Conejero Vicente. Desarrollo de aplicaciones Web, Universidad de Alicante.</p>
		</article>
	</section>

	<?php
		require_once("includes/pie.inc");  # Pie de la pagina con el copyright
	?>
	
</body>
</html>