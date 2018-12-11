<?php
	session_start(); # Inicializamos la gestion de sesiones

	require_once("includes/conexionBD.inc"); # Comprobamos la conexion a la base de datos

	if($_GET){
		if(isset($_GET['estilo'])){
			$usuario = $_SESSION['usuario'];
			$eNuevo = $_GET['estilo'];
			$resUp = $mysqli->query("UPDATE usuarios SET Estilo=$eNuevo WHERE NomUsuario='$usuario'");
			if(!$resUp || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
			{
				die("Error: no se pudo realizar la consulta: " . $mysqli->error);
			}

			if($resUp){
				$estilo = $mysqli->query("SELECT Nombre FROM estilos WHERE IdEstilo=$eNuevo");
				$festilo = $estilo->fetch_assoc();

				$cookie_name = "estilo";
				$cookie_value = $festilo['Nombre']; # Almacenamos el nombre del estilo que tiene almacenado el usuario
				setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");

				#Redireccionamos de vuelta a la pagina de cambio de estilo con el estilo nuevo puesto y un mensaje
				$host = $_SERVER['HTTP_HOST']; 
				$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
				$extra = 'P10/configurarEstilo.php?enuevo='. $eNuevo; 
				header("Location: http://$host$uri/$extra");
				exit;	
			}
		}
	}

	$mysqli->close();
?>