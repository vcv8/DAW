<?php
	session_start(); # Inicializamos la gestion de sesiones
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>PRETI</title>
</head>
<body>
	<?php 
		$regUser = array('manolo100' => 'holasoymanolo', 'cristian100' => 'holasoycristian' , 'pedro100' => 'holasoypedro' , 'knekro100' => 'holasoyknekro');
		$redir = '0';

		$usuario = $_POST['usuario'];
		$pass = $_POST['contraseña'];

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

			$_SESSION["usuario"] = $_POST["usuario"]; # Almacenamos el nombre de usuario en una variable global

			$cookie_name = "estilo";
			$cookie_value = "accesibility";
			setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");

			$host = $_SERVER['HTTP_HOST']; 
			$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
			$extra = 'P7/usuarioRegistrado.php?Saludo=firstLogin'; 
			header("Location: http://$host$uri/$extra");
			exit; 
		}
	?>
</body>
</html>