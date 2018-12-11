<?php
	session_start(); # Inicializamos la gestion de sesiones

	require_once("includes/conexionBD.inc"); # Comprobamos la conexion a la base de datos
	
	if(!isset($_SESSION["usuario"])){  # Si el usuario no ha iniciado sesion no puede acceder al detalle de foto
		if(isset($_COOKIE["recordar"])){
			$host = $_SERVER['HTTP_HOST']; 
			$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
			$extra = "P10/controlAcces.php?msg=resRegistro.php"; 
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
?>
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
		require_once("includes/cabecera1.inc");  # Cabecera de la pagina con el logo, login y registro
	?>

	<?php
		if($_POST){
			if(!isset($_POST['Usuario'])||!isset($_POST['Contraseña'])||!isset($_POST['Contraseña2'])||!isset($_POST['Correo'])||!isset($_POST['Sexo'])||!isset($_POST['Ciudad'])||!isset($_POST['País'])||!isset($_POST['fNacimiento'])){
				
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
	<p>Fecha de Nacimiento: <b><?php echo str_replace('-', '/', date('d/m/Y', strtotime($dia))); ?></b></p>
	<p>Ciudad: <b><?php echo $ciudad?></b></p>
	<p>País: <b><?php echo $pais?></b></p>

	<?php
		require_once("includes/pie.inc");  # Pie de la pagina con el copyright
	?>

</body>
</html>
<?php
			}else{
				echo '<p id="errorMSG"><span>ERROR</span>! Alguno de los parámetros no ha sido introducido. <a href="registro.php">Registrarse</a>.</p>';
			}
		}else{
			echo '<p id="errorMSG"><span>ERROR</span>! Alguno de los parámetros no ha sido introducido. <a href="registro.php">Registrarse</a>.</p>';
		}
	}
?>