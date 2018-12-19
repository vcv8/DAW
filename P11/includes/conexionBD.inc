<?php
	require_once("datosBD.inc"); # Contiene los datos de conexion al servidor

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
?>