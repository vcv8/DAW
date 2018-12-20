<?php
	session_start(); # Inicializamos la gestion de sesiones

	require_once("includes/conexionBD.inc"); # Contiene los datos de conexion al servidor
	
	if(!isset($_SESSION["usuario"])){
		if(isset($_COOKIE["recordar"])){
			$host = $_SERVER['HTTP_HOST']; 
			$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\');
			$extra = 'P11/controlAcces.php?msg=usuarioRegistrado.php'; 
			header("Location: http://$host$uri/$extra");
			exit;
		}

		$host = $_SERVER['HTTP_HOST']; 
		$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
		$extra = 'P11/login.php?Error1=accesoUsuarioNoRegistrado'; 
		header("Location: http://$host$uri/$extra");
		exit;	
	}
	else{
		require_once("includes/mBienvenidaIU.inc");
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0" /> <!-- Para que se pueda aplicar un diseño adaptable y la correcta visualizacion en dispo móviles -->


	<?php

		if(isset($_SESSION["usuario"]))
		{
			echo "<title>PRETI/" . $_SESSION["usuario"] . "</title>";
		}
		else
		{

	?>

		<title>PRETI/exportarDatos</title>

	<?php
	
		}
	?>

</head>
<body>

	<?php

		# Creamos una instancia de la clase DOMImplementation
		#$imp = new DOMImplementation;

		#$dtd = $imp->createDocumentType('graph', '', 'graph.dtd');
		#$dom = $imp->createDocument("", "", $dtd);

		#$dom->encoding = 'UTF-8'; 

		# Crear un elemento vacío
		#$element = $dom->createElement('graph');

		# Añadir el elemento
		#$dom->appendChild($element);

		# Creacion de documento con DOM
		$dom = new DomDocument("1.0", "UTF-8");

		$dom->formatOutput = true; #Hace el xml legible

		#Obtenemos los datos del usuario 
		$usuario = $_SESSION["usuario"];
		$sentencia1 = "SELECT * FROM usuarios u, paises p WHERE NomUsuario='$usuario' AND u.Pais=p.IdPais";
		$usuario = $mysqli->query($sentencia1);  

		if(!$usuario || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
		{
			die("Error: no se pudo realizar la consulta: " . $mysqli->error);
		}
		$fila = $usuario->fetch_assoc();

		$idUsuario =$fila['IdUsuario'];

		#Consulta de albumes
		$sentencia2 = "SELECT * FROM albumes WHERE Usuario='$idUsuario'";
		$albumUsu = $mysqli->query($sentencia2);  

		if(!$albumUsu || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
		{
			die("Error: no se pudo realizar la consulta: " . $mysqli->error);
		}
		#$fila2 = $albumUsu->fetch_assoc();

		#Creamos el nodo raiz
		$raiz = $dom->createElement('PRETI');
		$dom->appendChild($raiz);

		#Usuario
		$usu = $dom->createElement("Usuario");
		$idAtributo = $dom->createAttribute('IdUsuario');
		$idAtributo->value =$fila['IdUsuario'];

		$usu->appendChild($idAtributo);
		$raiz->appendChild($usu);

			#Datos
			$nombre = $dom->createElement("NomUsuario", $fila['NomUsuario']);
			$usu->appendChild($nombre);

			$Correo = $dom->createElement("Correo", $fila['Email']);
			$usu->appendChild($Correo);

			if($fila['Sexo']==0)
			{
				$fila['Sexo'] = "Hombre";
			}
			else
			{
				$fila['Sexo'] = "Mujer";
			}
			$Sexo = $dom->createElement("Sexo", $fila['Sexo']);
			$usu->appendChild($Sexo);

			$FNacimiento = $dom->createElement("FechaNac", $fila['FNacimiento']);
			$usu->appendChild($FNacimiento);

			$Ciudad = $dom->createElement("Ciudad", $fila['Ciudad']);
			$usu->appendChild($Ciudad);

			$Pais = $dom->createElement("Pais", $fila['NomPais']);
			$usu->appendChild($Pais);


			#Albumes
			$albumes = $dom->createElement("Albumes");
			$usu->appendChild($albumes);

			while($fila2 = $albumUsu->fetch_assoc()) #Bucle para recorrer todos los albumes que tenga el usuario
			{	
				$album = $dom->createElement("Album");
				$idAtributo = $dom->createAttribute('IdAlbum');
				$idAtributo->value =$fila2['IdAlbumes'];

				$album->appendChild($idAtributo);
				$albumes->appendChild($album);

					#Datos Albumes
					$tituloAlbum = $dom->createElement("Titulo", $fila2['Titulo']);
					$album->appendChild($tituloAlbum);

					$Descripcion = $dom->createElement("Descripcion", $fila2['Descripción']);
					$album->appendChild($Descripcion);

					$fotos = $dom->createElement("Fotos");
					$album->appendChild($fotos);

						#Consulta de fotos del album
						$idAlbum = $fila2['IdAlbumes'];
						$sentencia2 = "SELECT * FROM fotos WHERE Album='$idAlbum'";
						$fotosAlbum = $mysqli->query($sentencia2);  

						if(!$fotosAlbum || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
						{
							die("Error: no se pudo realizar la consulta: " . $mysqli->error);
						}

						while($fila3 = $fotosAlbum->fetch_assoc()) #Bucle para recorrer todas las fotos del album
						{
							$foto = $dom->createElement("Foto");
							$idAtributoFoto = $dom->createAttribute('IdFoto');
							$idAtributoFoto->value =$fila3['IdFoto'];

							$foto->appendChild($idAtributoFoto);
							$fotos->appendChild($foto);

								#Datos foto
								$tituloFoto = $dom->createElement("Titulo", $fila3['Titulo']);
								$fotos->appendChild($tituloFoto);

								$DescripcionFoto = $dom->createElement("Descripcion", $fila3['Descripcion']);
								$fotos->appendChild($DescripcionFoto);

								if($fila3['Fecha']!=NULL)
								{
									$fechaFoto = $dom->createElement("Fecha", $fila3['Fecha']);
									$fotos->appendChild($fechaFoto);
								}

								if($fila3['Pais']!=NULL)
								{
									$PaisFoto = $dom->createElement("Pais", $fila3['Pais']);
									$fotos->appendChild($PaisFoto);
								}

						}

						$solicitudes = $dom->createElement("Solicitudes");
						$album->appendChild($solicitudes);

						#Consulta de solicitudes album
						$idAlbum2 = $fila2['IdAlbumes'];
						$sentencia3 = "SELECT * FROM solicitudes WHERE Album='$idAlbum2'";
						$solicitudesAlbum = $mysqli->query($sentencia3);  

						if(!$solicitudesAlbum || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
						{
							die("Error: no se pudo realizar la consulta: " . $mysqli->error);
						}

						while($fila4 = $solicitudesAlbum->fetch_assoc()) #Bucle para recorrer todas las fotos del album
						{
							$solicitud = $dom->createElement("Solicitud");
							$idAtributoSolicitud = $dom->createAttribute('IdSolicitud');
							$idAtributoSolicitud->value =$fila4['IdSolicitud'];

							$solicitud->appendChild($idAtributoSolicitud);
							$solicitudes->appendChild($solicitud);

								#Datos Solicitud
								$nombreSol = $dom->createElement("Nombre", $fila4['Nombre']);
								$solicitud->appendChild($nombreSol);

								$tituloSol = $dom->createElement("Titulo", $fila4['Titulo']);
								$solicitud->appendChild($tituloSol);

								if($fila4['Descripcion']!=NULL)
								{
									$descripcionSol = $dom->createElement("Descripcion", $fila4['Descripcion']);
									$solicitud->appendChild($descripcionSol);
								}

								$emailSol = $dom->createElement("Email", $fila4['Email']);
								$solicitud->appendChild($emailSol);

								$calleSol = $dom->createElement("Calle", $fila4['Calle']);
								$solicitud->appendChild($calleSol);

								$codigoSol = $dom->createElement("CodPostal", $fila4['CodPostal']);
								$solicitud->appendChild($codigoSol);

								$LocalidadSol = $dom->createElement("Localidad", $fila4['Localidad']);
								$solicitud->appendChild($LocalidadSol);

								$PaisSol = $dom->createElement("Pais", $fila4['Pais']);
								$solicitud->appendChild($PaisSol);

								$ProvinciaSol = $dom->createElement("Provincia", $fila4['Provincia']);
								$solicitud->appendChild($ProvinciaSol);

								$ColorSol = $dom->createElement("Color", $fila4['Color']);
								$solicitud->appendChild($ColorSol);

								$CopiasSol = $dom->createElement("Copias", $fila4['Copias']);
								$solicitud->appendChild($CopiasSol);

								$ResolucionSol = $dom->createElement("Provincia", $fila4['Provincia']);
								$solicitud->appendChild($ResolucionSol);

								$FechaSol = $dom->createElement("Fecha", $fila4['Fecha']);
								$solicitud->appendChild($FechaSol);

								if($fila4['IColor']==1)
								{
									$fila4['IColor'] = "Si";
								}
								else
								{
									$fila4['IColor'] = "No";
								}

								$IColorSol = $dom->createElement("IColor", $fila4['IColor']);
								$solicitud->appendChild($IColorSol);

								$CosteSol = $dom->createElement("Coste", $fila4['Coste']);
								$solicitud->appendChild($CosteSol);

						}




			}






		$dom->save('./recursos/datosUsuario.xml'); #Guardamos el fichero

		# Cerramos la sesion con la BD y liberamos la memoria
		$usuario ->free();
		$mysqli->close();

	?>

</body>
</html>
<?php 
	}
?>