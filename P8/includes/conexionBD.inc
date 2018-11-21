<?php
	require_once("datosBD.inc"); # Contiene los datos de conexion al servidor

	#Conexion a la base de datos
	$mysqli = new mysqli(dbServer, dbUser, dbPassword, dbDatabase);
	if($mysqli->connect_errno)
	{
		die("Error: No se pudo conectar " . $mysqli->connect_error);
	}else{
		$mysqli->query("SET character_set_client = 'utf8'");
	}
?>