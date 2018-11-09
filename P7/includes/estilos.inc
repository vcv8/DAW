
<?php
	
	if(isset($_SESSION["usuario"]) && isset($_COOKIE["estilo"]) && ($_COOKIE["estilo"]=="noche")) # Aplicar el estilo seleccionado por el usuario
	{
		echo '<link rel="stylesheet" type="text/css" href="estilos/estilo1.css">';
		echo '<link rel="stylesheet" type="text/css" href="estilos/base.css" />';
		echo '<link rel="stylesheet" type="text/css" href="recursos/fontello-848afb9a/css/fontello.css" />';
		echo '<link rel="stylesheet" type="text/css" href="estilos/colors2.css" />';
	}
	else
	{
		if(isset($_SESSION["usuario"]) && isset($_COOKIE["estilo"]) && ($_COOKIE["estilo"]=="accesibilidad"))
		{
			echo '<link rel="stylesheet" type="text/css" href="estilos/estilo1.css">';
			echo '<link rel="stylesheet" type="text/css" href="estilos/base.css" />';
			echo '<link rel="stylesheet" type="text/css" href="recursos/fontello-848afb9a/css/fontello.css" />';
			echo '<link rel="stylesheet" type="text/css" href="estilos/accesibility.css" />';
			echo '<link rel="stylesheet" type="text/css" href="estilos/colors3.css" />';
		}
		else
		{
	

	
		
?>

<link rel="stylesheet" type="text/css" href="estilos/estilo1.css">
<link rel="stylesheet" type="text/css" href="estilos/base.css" />  
<link rel="stylesheet" type="text/css" href="estilos/colors.css" />
<link rel="stylesheet" type="text/css" href="recursos/fontello-848afb9a/css/fontello.css">

<?php
		}
	}
?>

<!-- Estilos Alternativos -->
<link rel="alternate stylesheet" type="text/css" title="Accesibilidad" href="estilos/accesibility.css" />
<link rel="alternate stylesheet" type="text/css" title="Accesibilidad" href="estilos/colors3.css" />
<link rel="alternate stylesheet" type="text/css" title="Modo sin responsive" href="estilos/estilo2.css" />

<!-- Para definir las propiedades que queremos que siempre se apliquen independientemente del tam de pantalla-->
<!-- Estilos que se aplican en función del tam de la pantalla -->
<!-- Indicamos el medio (pantallas) y la anchura mínima requerida para que se active este css --> 
<link rel="stylesheet" type="text/css" href="estilos/great.css" media="screen and (min-width: 981px)" />  <!-- Pantallas Grandes -->
<link rel="stylesheet" type="text/css" href="estilos/medium.css" media="screen and (min-width: 481px) and (max-width: 980px)" /> <!-- Pantallas Medianas -->
<link rel="stylesheet" type="text/css" href="estilos/mini.css" media="screen and (max-width: 480px)" /> <!-- Pantallas Pequeñas (Móviles) -->
	
<!-- Estilo Impresión -->
<link rel="stylesheet" type="text/css" href="estilos/print.css" media="print" />