<?php

	session_start(); # Inicializamos la gestion de sesiones

	require_once("includes/conexionBD.inc"); # Comprobamos la conexion a la base de datos

	if(!isset($_SESSION["usuario"])){
		if(isset($_COOKIE["recordar"])){
			$host = $_SERVER['HTTP_HOST']; 
			$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
			$extra = 'P10/controlAcces.php?msg=crearAlbum.php'; 
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
		require_once("includes/mBienvenida.inc");

			#Recogida de datos
			$titulo = $_GET['tituloAlbum'];
			$descripcion = $_GET['descripcionAlbum'];

			#Obtenemos el usuario
			$usuario = $_SESSION["usuario"];

			$sentencia1 = "SELECT idUsuario FROM usuarios WHERE NomUsuario='$usuario'";
			$usuario = $mysqli->query($sentencia1);  

			if(!$usuario || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
			{
				die("Error: no se pudo realizar la consulta: " . $mysqli->error);
			}

			$fila = $usuario->fetch_assoc();
			$idUsu = $fila['idUsuario']; 

			#Insertamos el album
			$sentencia="INSERT INTO albumes (Titulo, Descripción, Usuario) VALUES ('$titulo', '$descripcion', '$idUsu')";
			$solicit = $mysqli->query($sentencia);  

			if(!$solicit || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
			{
				die("Error: no se pudo realizar la consulta: " . $mysqli->error);
			}

			$host = $_SERVER['HTTP_HOST']; 
			$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
			$extra = 'P10/resCrearAlbum.php'; 
			header("Location: http://$host$uri/$extra");
			exit;
		}
?>