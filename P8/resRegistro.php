<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0" /> <!-- Para que se pueda aplicar un diseño adaptable y la correcta visualizacion en dispo móviles -->
	<title>PRETI</title>
	
	<?php
		require_once("includes/estilos.inc");  # Contiene todos los enlaces con el css necesario para las paginas
		require_once("includes/conexionBD.inc"); # Contiene los datos de conexion al servidor
	?>

</head>
<body>
	
	<?php
		require_once("includes/cabecera.inc");  # Cabecera de la pagina con el logo, login y registro
	?>

	<?php
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
		$dia = $_POST['Dia'];
		$mes = $_POST['Mes'];
		$anyo = $_POST['Año'];

		if($pass!=$pass2){ # Comprueba que las dos contraseñas coinciden
			echo '<p id="errorMSG"><span>ERROR</span>! Las contraseñas introducidas no coinciden. El usuario no ha sido registrado. <a href="registro.php">Registrarse</a>.</p>';
		}else if(empty($usuario) or empty($pass) or empty($pass2)){ # Comprueba si alguno de esos parametros son vacios o no
			echo '<p id="errorMSG"><span>ERROR</span>! Alguno de los parámetros no ha sido introducido. <a href="registro.php">Registrarse</a>.</p>';
		}else{
			echo '<p id="errorMSG">Tus datos de registro son los siguientes:</p>';
		}
	?>
	
	<p>Nombre de Usuario: <b><?php echo $usuario?></b></p>
	<p>Contraseña: <b><?php echo $pass?></b></p>
	<p>Contraseña repetida: <b><?php echo $pass2?></b></p>
	<p>Correo electrónico: <b><?php echo $correo?></b></p>
	<p>Sexo: <b><?php echo $sexo?></b></p>
	<p>Fecha de Nacimiento: <b><?php echo $dia?>/<?php echo $mes?>/<?php echo $anyo?></b></p>
	<p>Ciudad: <b><?php echo $ciudad?></b></p>
	<p>País: <b><?php echo $pais?></b></p>

	<?php
		require_once("includes/pie.inc");  # Pie de la pagina con el copyright
	?>

</body>
</html>