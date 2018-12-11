<?php 
	session_start(); # Inicializamos la gestion de sesiones

	require_once("includes/conexionBD.inc"); # Comprobamos la conexion a la base de datos


	$usuario = $_SESSION['usuario'];

	$albumesen = $mysqli->query("SELECT a.IdAlbumes , a.Titulo FROM albumes a JOIN usuarios u ON a.Usuario=u.IdUsuario WHERE NomUsuario='$usuario'");
	$falbumesen = $albumesen->fetch_assoc();

	if($falbumesen){
		do{
			$album = $falbumesen['IdAlbumes'];

			$fotosen = $mysqli->query("DELETE FROM fotos WHERE Album=$album");
			
			$solicitudesen = $mysqli->query("DELETE FROM solicitudes WHERE Album=$album");

			$delalbum = $mysqli->query("DELETE FROM albumes WHERE IdAlbumes=$album");
		}while($falbumesen = $albumesen->fetch_assoc());
	}

	$delusuario = $mysqli->query("DELETE FROM usuarios WHERE NomUsuario='$usuario'");
			
	# Cerramos la sesion con la BD y liberamos la memoria
	$mysqli->close();

	/* Redirecciona a borrar usuario confirmado */ 
	$host = $_SERVER['HTTP_HOST']; 
	$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
	$extra = 'P10/cierreSesion.php'; 
	header("Location: http://$host$uri/$extra");
	exit;

?>