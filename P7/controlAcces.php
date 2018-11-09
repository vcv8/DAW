<?php
	session_start(); # Inicializamos la gestion de sesiones

	$regUser = array('manolo100' => 'holasoymanolo', 'cristian100' => 'holasoycristian' , 'pedro100' => 'holasoypedro' , 'knekro100' => 'holasoyknekro');
	$redir = '0';

	if(isset($_COOKIE['recordar'])){
		list($usuario, $pass) = explode(',', $_COOKIE['recordar']);
		$rec = false;
	}else{
		$usuario = $_POST['usuario'];
		$pass = $_POST['contraseña'];
		$rec = $_POST['recuerdame'];
	}

	foreach ($regUser as $email => $clave) {
		if($email==$usuario and $clave==$pass){
			$redir = '1';
		}
	}

	if($redir=='0'){  # No es ninguno de los usuarios registrados
		/* Redirecciona a una página diferente que se encuentra en el directorio actual */ 
		$host = $_SERVER['HTTP_HOST']; 
		$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
		$extra = 'P7/login.php?Error1=loginError'; 
		header("Location: http://$host$uri/$extra");
		exit; 
	}else{ # Usuario registrado
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
		
		# Controlamos el estilo que tenia el usuario guardado
		$cookie_name = "estilo";
		$cookie_value = "accesibility";
		setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");

		# Redireccionamos
		if($_GET["log"]){
			$extra = 'P7/usuarioRegistrado.php?Saludo=firstLogin';
		}else{
			$destino = $_GET['msg']; # Controlamos la variable de URL que nos marca la pagina a la que redireccionar

			$extra = "P7/$destino";
		}

		$host = $_SERVER['HTTP_HOST']; 
		$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\');  
		header("Location: http://$host$uri/$extra");
		exit; 
	}
?>