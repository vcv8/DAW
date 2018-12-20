<?php 

	define("dbServer", "localhost"); 
	define("dbUser", "usuNormal"); 
	define("dbPassword", "12345678"); 
	define("dbDatabase", "pibd");

	#Conexion a la base de datos
	$mysqli = new mysqli(dbServer, dbUser, dbPassword, dbDatabase);
	if($mysqli->connect_errno)
	{
		die("Error: No se pudo conectar " . $mysqli->connect_error);
	}
	#Comprobamos si existe la base de datos
	if(!mysqli_select_db ($mysqli, "pibd"))
		die("Error: No existe la base de datos");

	$esChars = $mysqli->query("SET CHARACTER SET 'utf8'");

	header('Content-Type: text/xml; charset=utf-8', true); //set document header content type to be XML


	//Canal FEED (RSS/ATOM) con las ultimas cinco fotos publicadas
	 	
	$xml = new DOMDocument("1.0", "UTF-8");

	$rss = $xml->createElement("rss");
	$rss_node = $xml->appendChild($rss);
	$rss_node->setAttribute("version","2.0");

	$channel = $xml->createElement('channel');
	$channel_node = $rss_node->appendChild($channel);

	$channel_node->appendChild($xml->createElement('title' , 'PRETI Ultimas fotos RSS'));
	$channel_node->appendChild($xml->createElement('link' , 'http://localhost/P11/index.php'));
	$channel_node->appendChild($xml->createElement('description' , 'Ultimas 5 fotos subidas a la pagina'));

	$date_f = date("D, d M Y H:i:s T", time());
	$build_date = gmdate(DATE_RFC2822, strtotime($date_f));
	$channel_node->appendChild($xml->createElement("lastBuildDate", $build_date));
	$channel_node->appendChild($xml->createElement("generator", "PHP DOMDocument"));

	
	##
	# CONULTA DE FOTOS
	##

	$sentencia1 = "SELECT * FROM fotos ORDER BY FRegistro DESC LIMIT 5";
	$fotos = $mysqli->query($sentencia1);
	
	if(!$fotos || $mysqli->errno)
	{
		die("Error: no se pudo realizar la consulta: " . $mysqli->error);
	}

	while($fila = $fotos->fetch_assoc())
	{

		$image = $xml->createElement('image');
		$image_node = $channel_node->appendChild($image);


		$titulo = $fila['Titulo'];
		list($nada , $ruta) = explode(".", $fila['Fichero']);
		$url = 'http://localhost/P11' . $ruta;// . '.' . $formato;
		$fecha = $fila['FRegistro'];

		$image_node->appendChild($xml->createElement('title' , $titulo));
		$image_node->appendChild($xml->createElement('description' , $fila['Descripcion']));
		$image_node->appendChild($xml->createElement('url' , $url));
		$image_node->appendChild($xml->createElement('link' , 'http://localhost/P11/index.php'));
		$image_node->appendChild($xml->createElement('pubDate' , $fecha));
				
	}

	##
	# GUARDAMOS ARCHIVO XML
	##

	echo $xml->saveXML();
	//$xml->saveXML('./recursos/feed/rss.xml');
	//$dom->save('./recursos/datosUsuario.xml'); #Guardamos el fichero

?>