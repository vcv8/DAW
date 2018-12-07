
<?php
	session_start(); # Inicializamos la gestion de sesiones

	require_once("includes/conexionBD.inc"); # Comprobamos la conexion a la base de datos

	if(!isset($_SESSION["usuario"])){
		if(isset($_COOKIE["recordar"])){
			$host = $_SERVER['HTTP_HOST']; 
			$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
			$extra = 'P9/controlAcces.php?msg=insertFoto.php'; 
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
		require_once("includes/mBienvenida.inc");

		if($_GET && isset($_GET['Titulo']) && isset($_GET['Descripcion']) && isset($_GET['tAlternativo']) && isset($_GET['album'])){

			#Recogida de datos
			$titulo = $_GET['Titulo'];
			$descripcion = $_GET['Descripcion'];
			if(!isset($_GET['Fecha']) || empty($_GET['Fecha'])){
				$fecha = 'NULL';
			}else{
				$fecha = "'". $_GET['Fecha'] ."'";
			}
			if(!isset($_GET['pais']) || empty($_GET['pais'])){
				$pais = 'NULL';
			}else{
				$pais = $_GET['pais'];
			}
			$alt = $_GET['tAlternativo'];
			$album = $_GET['album'];  	# Album Seleccionado

			$usuario = $_SESSION['usuario'];

			#Consulta idAlbum de los albumes
			$sentencia1 = "SELECT idAlbumes FROM albumes JOIN usuarios ON IdUsuario=Usuario WHERE NomUsuario='$usuario'";
			$idAlbum = $mysqli->query($sentencia1);  

			if(!$idAlbum || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
			{
				die("Error: no se pudo realizar la consulta: " . $mysqli->error);
			}

			$fila = $idAlbum->fetch_assoc();
			$aBien = 0;
			do{
				if($fila['idAlbumes']==$album){
					$aBien=1;
				}
			}while($fila = $idAlbum->fetch_assoc());

			if($aBien==1){
				$fregistro = date('Y-m-d H:i:s'); #Almacenamos la fecha actual para el registro
				$path = "recursos/paisaje.png";;

				$solicit = $mysqli->query("INSERT INTO fotos (Titulo, Descripcion, Fecha, Pais, Album, Fichero, FRegistro, Alternativo) VALUES ('$titulo', '$descripcion', $fecha , $pais, $album, '". $path ."', '$fregistro', '$alt')");  

				if(!$solicit || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
				{
					die("Error: no se pudo realizar la consulta: " . $mysqli->error);
				}else{
					$usuario = $_SESSION['usuario'];
					$idlast = $mysqli->query("SELECT IdFoto FROM fotos JOIN albumes ON Album=IdAlbumes JOIN usuarios ON Usuario=IdUsuario WHERE NomUsuario='$usuario' ORDER BY IdFoto DESC LIMIT 1");
					$fidlast = $idlast->fetch_assoc();
					$pluspam = $fidlast['IdFoto'];
				}

				$host = $_SERVER['HTTP_HOST']; 
				$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
				$extra = 'P9/resSubirFoto.php'; 
				$plus = '?sid='. $pluspam;
				header("Location: http://$host$uri/$extra$plus");
				exit;
			}
		}

	}
?>