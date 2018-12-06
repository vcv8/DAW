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
 
			#Validaciones de datos introducidos  (^->Empieza la cadena, $->Termina la cadena, +->Minimo un valor, {}->Repeticiones)
			#Usuario
			if(empty($usuario) || (!preg_match('/^[a-zA-Z0-9]{3,15}$/', $usuario)) ) #Usuario incorrecto
			{
				$extra ='P9/registro.php?Error1=registroUsuarioErr'; 
				require_once("includes/redireccion.inc"); #Contiene los datos para redireccionar a otra pagina con el valor en redirecc
				
			}

			#Contraseña. #Entre 6 y 15, minimo una mayus, una minusc y un numero. Se permite _
			if(empty($pass) || (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])[a-zA-Z0-9\_]{6,15}$/', $pass)) ) 
			{
				$extra ='P9/registro.php?Error1=registroContraErr'; 
				require_once("includes/redireccion.inc");
			}

			#RepetirContraseña
			if($pass != $pass2)
			{
				$extra ='P9/registro.php?Error1=registroContra2Err'; 
				require_once("includes/redireccion.inc");
			}
			
			#Correo
			if(!filter_var($correo, FILTER_VALIDATE_EMAIL)) 
			{
				/* Redirecciona a una página diferente que se encuentra en el directorio actual */ 
				$extra = 'P9/registro.php?Error1=registroEmailErr'; 
				require_once("includes/redireccion.inc");
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