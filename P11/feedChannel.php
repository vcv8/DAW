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

	$rss_node->setAttribute("xmlns:dc","http://purl.org/dc/elements/1.1/"); //xmlns:dc (info http://j.mp/1mHIl8e )
	$rss_node->setAttribute("xmlns:content","http://purl.org/rss/1.0/modules/content/"); //xmlns:content (info http://j.mp/1og3n2W)
	$rss_node->setAttribute("xmlns:atom","http://www.w3.org/2005/Atom");//xmlns:atom (http://j.mp/1tErCYX )

	$channel = $xml->createElement('channel');
	$channel_node = $rss_node->appendChild($channel);

	$channel_atom_link = $xml->createElement("atom:link");  
	$channel_atom_link->setAttribute("href","http://localhost:8086/P11/feedChannel.php"); //url of the feed
	$channel_atom_link->setAttribute("rel","self");
	$channel_atom_link->setAttribute("type","application/rss+xml");
	$channel_node->appendChild($channel_atom_link); 

	$channel_node->appendChild($xml->createElement('title' , 'PRETI Ultimas fotos RSS'));
	$channel_node->appendChild($xml->createElement('link' , 'http://localhost:8086/P11/index.php'));
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

	$cont = 0;
	while($fila = $fotos->fetch_assoc())
	{
		$titulo = $fila['Titulo'];
		list($nada , $ruta, $formato) = explode(".", $fila['Fichero']);
		$url = 'http://localhost:8086/P11' . $ruta . '.' . $formato;
		$fecha = $fila['FRegistro'];
		$linkdet = 'http://localhost:8086/P11/detalleFoto.php?id_foto=' . $fila['IdFoto'];

		if($cont==0){
			$image = $xml->createElement('image');
			$image_node = $channel_node->appendChild($image);

			$image_node->appendChild($xml->createElement('title' , 'PRETI Ultimas fotos RSS'));
			$image_node->appendChild($xml->createElement('description' , $fila['Descripcion']));
			$image_node->appendChild($xml->createElement('url' , $url));
			$image_node->appendChild($xml->createElement('link' , 'http://localhost:8086/P11/index.php'));
		}

		$item = $xml->createElement('item');
		$item_node = $channel_node->appendChild($item);

		$item_node->appendChild($xml->createElement('title' , $titulo));
		$item_node->appendChild($xml->createElement('description' , $fila['Descripcion']));
		$item_node->appendChild($xml->createElement('link' , $linkdet));
		$item_node->appendChild($xml->createElement('pubDate' , $fecha));

		$cont++;
				
	}

	##
	# GUARDAMOS ARCHIVO XML
	##

	$xml->save("./recursos/feed/rss.xml");
	echo $xml->saveXML();
	//$xml->saveXML('./recursos/feed/rss.xml');
	//$dom->save('./recursos/datosUsuario.xml'); #Guardamos el fichero

	##
	# REDIRRECCION
	##
	$pluspam = $_GET['sid'];

	/*$host = $_SERVER['HTTP_HOST']; 
	$uri  = rtrim(dirname($_SERVER[’PHP_SELF’]), '/\\'); 
	$extra = 'P11/resSubirFoto.php'; 
	$plus = '?sid='. $pluspam;
	header("Location: http://$host$uri/$extra$plus");
	exit;*/

?>