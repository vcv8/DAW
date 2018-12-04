<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0" /> <!-- Para que se pueda aplicar un diseño adaptable y la correcta visualizacion en dispo móviles -->
	<title>Control de Insert</title>

	<?php
		require_once("includes/estilos.inc");  # Contiene todos los enlaces con el css necesario para las paginas
		require_once("includes/conexionBD.inc"); # Contiene los datos de conexion al servidor
	?>

</head>
<body>

	<?php
			#Recogemos los datos introducidos para el nuevo usuario
			$usuario = $_POST['Usuario'];
			$usuario = rtrim($usuario); # Elimina los espacios en blanco
			$pass = $_POST['Contraseña'];
			$pass = rtrim($pass);
			$pass2 = $_POST['Contraseña2'];
			$pass2 = rtrim($pass2);
			$correo = $_POST['Correo'];
			$sexo = $_POST['Sexo'];
			$ciudad = $_POST['Ciudad'];
			$pais = $_POST['País'];
			$dia = $_POST['fNacimiento'];

			#Validaciones de datos introducidos
			if(!filter_var($correo, FILTER_VALIDATE_EMAIL)) #Correo incorrecto
			{
				/* Redirecciona a una página diferente que se encuentra en el directorio actual */ 
				$host = $_SERVER['HTTP_HOST']; 
				$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
				$extra = 'P9/registro.php?Error1=registroEmailErr'; 
				header("Location: http://$host$uri/$extra");
				exit;
			}


			#Insertamos un nuevo usuario
			$sentencia="INSERT INTO usuarios (NomUsuario, Clave, Email, Sexo, FNacimiento, Ciudad, Pais, Foto, FRegistro, Estilo) VALUES ('$usuario', '$pass', '$correo', '1', '$dia', '$ciudad', '1', 'fotoPerfil.png', '2018-11-20 17:23:00', '1')";

			if(!mysqli_query($mysqli, $sentencia))
			{
				die("Error: no se pudo realizar la inserccion: " . $mysqli->error);
			}

			echo 'Se ha realizado la inserccion de un nuevo usuario';

			#Cerramos conexion con el SGBD
			$mysqli->close();
	?>

</body>
</html>