<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>PRETI</title>
</head>
<body>
	<?php 
		$regUser = array('manolo100@gmail.com' => 'holasoymanolo', 'cristian100@gmail.com' => 'holasoycristian' , 'pedro100@gmail.com' => 'holasoypedro' , 'knekro100@gmail.com' => 'holasoyknekro');
		$redir = '0';

		$correo = $_POST['correo'];
		$pass = $_POST['contraseña'];

		foreach ($regUser as $email => $clave) {
			if($email==$correo and $clave==$pass){
				$redir = '1';
			}
		}

		if($redir=='0'){
			/* Redirecciona a una página diferente que se encuentra en el directorio actual */ 
			$host = $_SERVER['HTTP_HOST']; 
			$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
			$extra = 'P6/index.php?loginError'; 
			header("Location: http://$host$uri/$extra");
			exit; 
		}else{
			$host = $_SERVER['HTTP_HOST']; 
			$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
			$extra = 'P6/usuarioRegistrado.php'; 
			header("Location: http://$host$uri/$extra");
			exit; 
		}
	?>
</body>
</html>