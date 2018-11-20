<?php
	session_start(); # Inicializamos la gestion de sesiones

	require_once("includes/conexionBD.inc"); # Comprobamos la conexion a la base de datos
	
	if(!isset($_SESSION["usuario"])){  # Si el usuario no ha iniciado sesion no puede acceder al detalle de foto
		if(isset($_COOKIE["recordar"])){
			$host = $_SERVER['HTTP_HOST']; 
			$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
			$f_id = $_GET['id_foto'];
			$extra = "P8/controlAcces.php?msg=detalleFoto.php?id_foto=$f_id"; 
			header("Location: http://$host$uri/$extra");
			exit;
		}

		$host = $_SERVER['HTTP_HOST']; 
		$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
		$extra = 'P8/login.php?Error1=accesoUsuarioNoRegistrado'; 
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
	<title>PRETI/detalleFoto</title>

	<?php
		require_once("includes/estilos.inc");  # Contiene todos los enlaces con el css necesario para las paginas
	?>

</head>
<body>

	<?php
		require_once("includes/cabecera3.inc");  # Cabecera de la pagina con el logo, login y registro
	?>

	<section id="detalle">
		<article>
		<?php
			if(!isset($_GET['id_foto'])){
				echo '<p id="errorMSG">¡<span>ERROR</span>! La ID de la foto introducida es errónea.</p>';
			}else{
				if (!is_numeric($_GET['id_foto'])) {
					echo '<p id="errorMSG">¡<span>ERROR</span>! La ID de la foto introducida es errónea.</p>';
				}else
				{
					$id = $_GET['id_foto'];

					$sentencia = "SELECT * FROM fotos WHERE IdFoto=$id";
					$foto = $mysqli->query($sentencia);  # Devuelve un objeto con la foto que tenga esa id

					if(!$foto || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
					{
						die("Error: no se pudo realizar la consulta: " . $mysqli->error);
					}

					$fila = $foto->fetch_assoc();



					if($id%'2'=='0'){ # En funcion de si es par o no, se almacena un array o otro
						$res = array('gat2.jpg', 'Vichyssoise', '20/10/2018','Francia', 'Animales', '@VictorCV8');
					}else{
						$res = array('paisaje.png', 'Amanecer', '19/09/2018','España', 'Paisajes', '@Roxo95');
					}
		?>
			<figure>
				<div>
					<img src="<?php echo $fila['Fichero'];?>" alt="Foto con mas detalle" class="imagen2">
				</div>
				<figcaption>
					<h2><?php echo $fila['Titulo'];?></h2>
					<p class="info">Tomada el <?php echo $fila['Fecha'];?></p>
					<p class="info">en 
						<?php
							if($fila['Pais'] == 1)
							{
								echo "España";
							}
						 ?>
						
					</p>
					<div>
						<p class="albuminfo">Pertenece al álbum <a href="" title="Acceso al album de Fotos">
						<?php 
							if($fila['Album'] == 1)
							{
								echo "Paisajes";
							}
						?>
						</a>.
						</p>
						<p>Por <a href="usuarioRegistrado.php" title="Acceso al usuario Roxo95"><?php echo $res[5]?></a></p>
					</div>
				</figcaption>
			</figure>
		<?php
				}
			}
		?>
		</article>
	</section>

	<?php
		require_once("includes/pie.inc");  # Pie de la pagina con el copyright
	?>
	
</body>
</html>
<?php 
	}
?>