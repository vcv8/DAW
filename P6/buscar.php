<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0" /> <!-- Para que se pueda aplicar un diseño adaptable y la correcta visualizacion en dispo móviles -->
	<title>PRETI</title>
	
	<?php
		require_once("includes/estilos.inc");  # Contiene todos los enlaces con el css necesario para las paginas
	?>

</head>
<body>
	
	<?php
		require_once("includes/cabecera.inc");  # Cabecera de la pagina con el logo, login y registro
	?>

	<section id="busquedaAvanzada">
		<fieldset class="marcoBusqueda">
			<h2>Búsqueda Avanzada</h2>
			<form action="resBuscar.html">
				<p><label><b>Título </b></label><input class="boxesAlbum" type="text" name="titulo" placeholder=" Amanecer..."></p>
				<p><label><b>País </b></label><input class="boxesAlbum" type="text" name="pais" placeholder=" España..."></p>
				<p><label><b>Fecha entre </b></label> <input class="boxesAlbum" type="date" name="fechaInicial"> <b> y </b> <input class="boxesAlbum" type="date" name="fechaFinal"></p>
				<p><input id="buscarFotos" type="submit" value="Buscar Fotos"></p>
			</form>
		</fieldset>
	</section>

	<?php
		require_once("includes/pie.inc");  # Pie de la pagina con el copyright
	?>
	
</body>
</html>