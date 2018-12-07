<?php
	session_start(); # Inicializamos la gestion de sesiones

	require_once("includes/conexionBD.inc"); # Contiene los datos de conexion al servidor
	
	if(!isset($_SESSION["usuario"])){
		if(isset($_COOKIE["recordar"])){
			$host = $_SERVER['HTTP_HOST']; 
			$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\');
			$extra = 'P9/controlAcces.php?msg=usuarioRegistrado.php'; 
			header("Location: http://$host$uri/$extra");
			exit;
		}

		$host = $_SERVER['HTTP_HOST']; 
		$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
		$extra = 'P9/login.php?Error1=accesoUsuarioNoRegistrado'; 
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
	<title>Control de update</title>

	<?php
		require_once("includes/estilos.inc");  # Contiene todos los enlaces con el css necesario para las paginas
	?>

</head>
<body>

	<?php
			require_once("includes/validacionDatosUsuario.inc"); #Se realiza la validacion de los campos introducidos por el usuario

			#Comrpobamos que usuario es el que esta modificando
			$usuarioSesion = $_SESSION["usuario"];

			$sentencia1 = "SELECT idUsuario FROM usuarios WHERE NomUsuario='$usuarioSesion'";
			$usuario2 = $mysqli->query($sentencia1);  

			if(!$usuario2 || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
			{
				die("Error: no se pudo realizar la consulta: " . $mysqli->error);
			}

			$fila = $usuario2->fetch_assoc();
			$idUsu = $fila['idUsuario']; 
		

			#Modificamos los datos del usuario
			$update = $mysqli->query("UPDATE usuarios SET NomUsuario='$usuario', Clave='$pass', Email='$correo', Sexo='$sexo', FNacimiento='$dia', Ciudad='$ciudad', 
			Pais='$pais' WHERE idUsuario='$idUsu'");


			if(!$update || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
			{
				die("Error: no se pudo realizar la consulta: " . $mysqli->error);
			}

			$_SESSION["usuario"] = $usuario;
			
			$host = $_SERVER['HTTP_HOST']; 
			$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
			$extra = 'P9/usuarioRegistrado.php?Update=cambioDatos'; 
			header("Location: http://$host$uri/$extra");
			exit;

			#Cerramos conexion con el SGBD
			$mysqli->close();
	?>

</body>
</html>
<?php 
	}
?>