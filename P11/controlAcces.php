<?php
	session_start(); # Inicializamos la gestion de sesiones

	require_once("includes/conexionBD.inc"); # Comprobamos la conexion a la base de datos

	$redir = '0';

	if(isset($_COOKIE['recordar'])){ #Aqui validara por cookie de recuerdame
		list($usuario, $pass) = explode(',', $_COOKIE['recordar']);
		$rec = false;
	}else{
		if($_GET){	#Aqui es para validar la contraseña para ciertas acciones
			if(isset($_GET['baja'])){
				if($_GET['baja']==1 || $_GET['baja']==2){
					$usuario = $_SESSION['usuario'];
					$pass = $_POST['Contraseña'];
					$rec = false;
				}
			}else{ #Aqui sera un login normal
				$usuario = $_POST['usuario'];
				$pass = $_POST['contraseña'];
				$rec = $_POST['recuerdame'];
			}
		}
	}

	# Control de Usuario accediendo a la Base de datos
	$tpass = $mysqli->query("SELECT Clave , Estilo FROM usuarios WHERE NomUsuario='$usuario'");
	$outpass = $tpass->fetch_assoc();

	if($outpass){
		if($pass == $outpass['Clave']){
			$redir = '1';

			# Controlamos el estilo que tenia el usuario guardado
			$IdEstilo = $outpass['Estilo'];
			$sentencia1 = "SELECT Nombre FROM estilos WHERE IdEstilo=$IdEstilo";
			$estilo = $mysqli->query($sentencia1);

			if(!$estilo || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
			{
				die("Error: no se pudo realizar la consulta: " . $mysqli->error);
			}

			$fila = $estilo->fetch_assoc();

			$cookie_name = "estilo";
			$cookie_value = $fila['Nombre']; # Almacenamos el nombre del estilo que tiene almacenado el usuario
			setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
		}
	}

	if($redir=='0'){  # No es ninguno de los usuarios registrados
		if(isset($_GET['baja'])){
			if($_GET['baja']==1){
				/* Redirecciona a NO borrar usuario */ 
				$host = $_SERVER['HTTP_HOST']; 
				$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
				$extra = 'P11/baja.php?err=1'; 
				header("Location: http://$host$uri/$extra");
				exit;
			}else if($_GET['baja']==2){

			}
		}else{
			/* Redirecciona a login con error */ 
			$host = $_SERVER['HTTP_HOST']; 
			$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
			$extra = 'P11/login.php?Error1=loginError'; 
			header("Location: http://$host$uri/$extra");
			exit; 
		}
	}else{ # Usuario registrado
		if($_GET && isset($_GET['baja'])){
			if($_GET['baja']==1){
				/* Redirecciona a borrar usuario confirmado */ 
				$host = $_SERVER['HTTP_HOST']; 
				$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
				$extra = 'P11/dropUsuario.php'; 
				header("Location: http://$host$uri/$extra");
				exit;
			}else if($_GET['baja']==2){

			}
		}else{
			if ($rec) {
				if (isset($_COOKIE["recordar"])) {
					setcookie("recordar", "", time() - 3600);
				}
				$current_visit = date("c");
				$c_value = "$usuario,$pass";
				$caduca = time() + (90 * 24 * 60 * 60); #Caduca en 90 dias
				setcookie("recordar", $c_value, $caduca); 
			}

			$_SESSION["usuario"] = $usuario; # Almacenamos el nombre de usuario en una variable global
				
			# Cerramos la sesion con la BD y liberamos la memoria
			$estilo ->free();
			$tpass ->free();
			$mysqli->close();
			

			# Redireccionamos
			if(isset($_GET["log"])){
				$extra = 'P11/usuarioRegistrado.php';
			}else{
				$destino = $_GET['msg']; # Controlamos la variable de URL que nos marca la pagina a la que redireccionar

				$extra = "P11/$destino";
			}

			$host = $_SERVER['HTTP_HOST']; 
			$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\');  
			header("Location: http://$host$uri/$extra");
			exit;
		} 
	}
?>