<?php
	session_start(); # Inicializamos la gestion de sesiones

	require_once("includes/conexionBD.inc"); # Contiene los datos de conexion al servidor
	
	if(!isset($_SESSION["usuario"])){
		if(isset($_COOKIE["recordar"])){
			$host = $_SERVER['HTTP_HOST']; 
			$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\');
			$extra = 'P11/controlAcces.php?msg=modDatos.php'; 
			header("Location: http://$host$uri/$extra");
			exit;
		}

		$host = $_SERVER['HTTP_HOST']; 
		$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
		$extra = 'P11/login.php?Error1=accesoUsuarioNoRegistrado'; 
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
	<title>PRETI/Modificar Datos</title>

	<?php
		require_once("includes/estilos.inc");  # Contiene todos los enlaces con el css necesario para las paginas
	?>
</head>
<body>

	<?php
		require_once("includes/cabecera1.inc");  # Cabecera de la pagina con solo logo

		$site = 'mod'; # Variable que nos permite identificar la version del formulario de registro que debemos mostrar
		
		$usuario = $_SESSION['usuario'];
		$tdata = $mysqli->query("SELECT * FROM usuarios WHERE NomUsuario='$usuario'");
		$userData = $tdata->fetch_assoc();

		$pais = $userData['Pais'];
		$tpais = $mysqli->query("SELECT * FROM paises WHERE IdPais=$pais");
		$outpais =  $tpais->fetch_assoc();

		$pam = array(
					$userData['NomUsuario'],
					$userData['Clave'],
					$userData['Email'],
					$userData['FNacimiento'],
					$userData['Ciudad'],
					$outpais['NomPais'],
					$userData['Foto']
				);

		#Control de error de campos de modificar datos
		$error = Null;

		if($_GET && isset($_GET['Error1'])) 
		{
			$error = $_GET['Error1']; #Se ha producido un error, lo almacenamos para comprobar cual es
		}
		

		require_once("includes/regForm.inc");

		require_once("includes/pie.inc");  # Pie de la pagina con el copyright
	?>

</body>
</html>
<?php
	}
?>