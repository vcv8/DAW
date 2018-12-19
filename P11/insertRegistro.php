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
			$origen="registro";
			require_once("includes/validacionDatosUsuario.inc"); #Se realiza la validacion de los campos introducidos por el usuario

			$date = date('Y-m-d H:i:s'); #Almacenamos la fecha actual para el registro

			#Insertamos un nuevo usuario
			$sentencia="INSERT INTO usuarios (NomUsuario, Clave, Email, Sexo, FNacimiento, Ciudad, Pais, Foto, FRegistro, Estilo) VALUES ('$usuario', '$pass', '$correo', $sexo, '$dia', '$ciudad', '$pais', '$newName', '$date', '1')";

			if(!mysqli_query($mysqli, $sentencia))
			{
				die("Error: no se pudo realizar la inserccion: " . $mysqli->error);
			}

			#Una vez creado el usuario lo direccionamos al login para que inicie sesion
			$host = $_SERVER['HTTP_HOST']; 
			$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
			$extra = 'P11/login.php?Nuevo=nuevoUsuario'; 
			header("Location: http://$host$uri/$extra");
			exit;

			#Cerramos conexion con el SGBD
			$mysqli->close();
	?>

</body>
</html>