<?php
	$dia = date('d');
	$mes = date('F');
	$anyo = date('Y');
	$hora = date('h');
	$min = date('i');
	$sec = date('s');
	$pm = date('A');
	setcookie("lasttime" . $_SESSION["usuario"], "Bienvenido " . $_SESSION['usuario'] . ", no te veíamos desde el día $dia de $mes de $anyo a las $hora:$min:$sec $pm.", time() + (100 * 24 * 60 * 60));

	if (!isset($_COOKIE['firsttime']))
	{
	    setcookie("firsttime", "no");

	    if(isset($_COOKIE['lasttime' . $_SESSION["usuario"]])){
	    	$saludo = '<p id="errorMSG">' . $_COOKIE['lasttime' . $_SESSION["usuario"]] . '</p>';
	    }
	}
?>