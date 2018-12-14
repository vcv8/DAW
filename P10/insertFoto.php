
<?php
	session_start(); # Inicializamos la gestion de sesiones

	require_once("includes/conexionBD.inc"); # Comprobamos la conexion a la base de datos

	if(!isset($_SESSION["usuario"])){
		if(isset($_COOKIE["recordar"])){
			$host = $_SERVER['HTTP_HOST']; 
			$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
			$extra = 'P10/controlAcces.php?msg=insertFoto.php'; 
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

		if($_POST && isset($_POST['Titulo']) && isset($_POST['Descripcion']) && isset($_POST['tAlternativo']) && isset($_POST['album'])){
			if($_FILES['foto']['error'] == 0){
				if(($_FILES["foto"]["type"]=="image/png") || ($_FILES["foto"]["type"]=="image/jpeg") || ($_FILES["foto"]["type"]=="image/jpg"))
				{

					#Recogida de datos
					$titulo = $_POST['Titulo'];
					$descripcion = $_POST['Descripcion'];
					if(!isset($_POST['Fecha']) || empty($_POST['Fecha'])){
						$fecha = 'NULL';
					}else{
						$fecha = "'". $_POST['Fecha'] ."'";
					}
					if(!isset($_POST['pais']) || empty($_POST['pais'])){
						$pais = 'NULL';
					}else{
						$pais = $_POST['pais'];
					}
					$alt = $_POST['tAlternativo'];
					$album = $_POST['album'];  	# Album Seleccionado

					/*echo $_FILES['foto']['name'];*/

					$sitio = "foto";
					require_once("includes/fotoForm.inc");

					$path = "./recursos/" . $newName;

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
						$extra = 'P10/resSubirFoto.php'; 
						$plus = '?sid='. $pluspam;
						header("Location: http://$host$uri/$extra$plus");
						exit;
					}else{
						//REDIRECCION A SUBIR FOTO CON ERROR No se puede subor foto a un álbum ajeno.
						$host = $_SERVER['HTTP_HOST']; 
						$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 

						$extra ="P10/subirFoto.php?fotoErr=10";

						header("Location: http://$host$uri/$extra");
						exit;
					}
				}else{
					//REDIRECCION A SUBIR FOTO CON ERROR No se han itroducido todos los parámetros especificados.
					$host = $_SERVER['HTTP_HOST']; 
					$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
					$fotoerr = $_FILES['foto']['error'];
					$extra ="P10/subirFoto.php?fotoErr=12";

					header("Location: http://$host$uri/$extra");
					exit;
				}
			}else{
				//REDIRECCION A SUBIR FOTO CON ERROR No se han itroducido todos los parámetros especificados.
				$host = $_SERVER['HTTP_HOST']; 
				$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
				$fotoerr = $_FILES['foto']['error'];
				$extra ="P10/subirFoto.php?fotoErr=" . $fotoerr;

				header("Location: http://$host$uri/$extra");
				exit;
			}
		}else{
			//REDIRECCION A SUBIR FOTO CON ERROR No se han itroducido todos los parámetros especificados.
			$host = $_SERVER['HTTP_HOST']; 
			$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 

			$extra ="P10/subirFoto.php?fotoErr=11";

			header("Location: http://$host$uri/$extra");
			exit;
		}

	}
?>