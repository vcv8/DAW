
<?php
	session_start(); # Inicializamos la gestion de sesiones

	require_once("includes/conexionBD.inc"); # Comprobamos la conexion a la base de datos

	if(!isset($_SESSION["usuario"])){
		if(isset($_COOKIE["recordar"])){
			$host = $_SERVER['HTTP_HOST']; 
			$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
			$extra = 'P10/controlAcces.php?msg=crearAlbum.php'; 
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

				#Recogida de datos
				$nombre = $_GET['nombre'];
				$titulo = $_GET['titulo'];
				$descripcion = $_GET['descripcion'];
				$correo = $_GET['correo'];
				$calle = $_GET['calle'];
				$numero = $_GET['numero'];
				$cp = $_GET['cp'];
				$localidad = $_GET['localidad'];
				$pais = $_GET['pais'];
				$provincia = $_GET['provincia'];
				$telefono = $_GET['telefono'];
				$color = $_GET['color'];
				$fechaRecepcion = $_GET['fechaRecepcion'];
				$album = $_GET['album'];  	# Album Seleccionado
				$copias = $_GET['copias'];	# Nº de copias del album
				$resolucion = $_GET['resolucion']; # Resolucion del album
				$tipoImpresion = $_GET['cimpresion']; 	# Tipo de impresion del album 


				#Consulta idAlbum de los albumes
				$sentencia1 = "SELECT idAlbumes FROM albumes WHERE Titulo='$album'";
				$idAlbum = $mysqli->query($sentencia1);  

				if(!$idAlbum || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
				{
					die("Error: no se pudo realizar la consulta: " . $mysqli->error);
				}

				$fila = $idAlbum->fetch_assoc();

				$idAlbum = $fila['idAlbumes'];

				#Contamos el numero de fotos del album
				$sentencia2 = "SELECT COUNT(*) AS numfotos FROM fotos WHERE Album='$idAlbum'";
				$fotos = $mysqli->query($sentencia2);  
				

				if(!$fotos || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
				{
					die("Error: no se pudo realizar la consulta: " . $mysqli->error);
				}

				$numero_fotos = $fotos->fetch_assoc();

				$paginas = $numero_fotos['numfotos']+1; 	# Nº de paginas del album
				$fotos = $numero_fotos['numfotos']; 		# Nº de fotos del album
				$total = 0;
				$costePag = 0;
				$costeImpresion = 0;
				$costeResolucion = 0;

				# Calculamos el precio por pagina
				if ($paginas<5) {
				    $costePag = 0.10;

				} elseif ($paginas>=5 && $paginas<=10) {
				    $costePag = 0.08;

				} else { # Mas de 10 paginas
				    $costePag = 0.07;
				}

				# Si la impresion a color añadimos el coste
				if($tipoImpresion == "color")
				{
					$costeImpresion = 0.05;
				}

				if($resolucion >300)
				{
					$costeResolucion = 0.02;
				}

				#Calculo del precio final
				$costeFinalPag = $costePag * $paginas; # Coste total por numero de paginas

				$costeImpresion = $costeImpresion + $costeResolucion;
				$costeFinalFotos = $costeImpresion * $fotos;

				$total = ($costeFinalPag + $costeFinalFotos) * $copias;


				$fregistro = date('Y-m-d H:i:s'); #Almacenamos la fecha actual para el registro

				if($tipoImpresion=="color")
				{
					$tipoImpresion=true;
				}
				else
				{
					$tipoImpresion=false;
				}

				$sentencia="INSERT INTO solicitudes (Album, Nombre, Titulo, Descripcion, Email, Calle, Numero, CodPostal, Localidad, Pais, Provincia, Color, Copias, Resolucion, Fecha, IColor, FRegistro, Coste) VALUES ('$idAlbum', '$nombre', '$titulo', '$descripcion', '$correo', '$calle', '$numero', '$cp', '$localidad', '$pais', '$provincia', '$color', '$copias', '$resolucion', '$fechaRecepcion', '$tipoImpresion', '$fregistro', '$total')";

				$solicit = $mysqli->query($sentencia);  

				if(!$solicit || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
				{
					die("Error: no se pudo realizar la consulta: " . $mysqli->error);
				}else{
					$usuario = $_SESSION['usuario'];
					$idlast = $mysqli->query("SELECT IdSolicitud FROM solicitudes JOIN albumes ON Album=IdAlbumes JOIN usuarios ON Usuario=IdUsuario WHERE NomUsuario='$usuario' ORDER BY idSolicitud DESC LIMIT 1");
					$fidlast = $idlast->fetch_assoc();
					$pluspam = $fidlast['IdSolicitud'];
				}

				$host = $_SERVER['HTTP_HOST']; 
				$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
				$extra = 'P10/resSolicitud.php'; 
				$plus = '?sid='. $pluspam;
				header("Location: http://$host$uri/$extra$plus");
				exit;
			}
?>