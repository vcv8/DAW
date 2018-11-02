<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0" /> <!-- Para que se pueda aplicar un diseño adaptable y la correcta visualizacion en dispo móviles -->
	<title>PRETI/solicitarAlbum</title>
	
	<?php
		require_once("includes/estilos.inc");  # Contiene todos los enlaces con el css necesario para las paginas
	?>
	
</head>
<body>
	
	<?php
		require_once("includes/cabecera.inc");  # Cabecera de la pagina con el logo, login y registro
	?>

	<section>
		<h2>Solicitud de Álbum</h2>
		<p>Mediante esta opción puedes solicitar la impresión y envío de uno de tus álbumes a color y resolución deseada.</p>
		<article id="tablaTarifas">
			<table class="display-great" title="Información con nuestras tarifas de impresión">
				<caption><b>Tarifas</b></caption>
				<tr>
					<th>Concepto</th>
					<td>&lt; 5 páginas</td>
					<td>entre 5 y 10 páginas</td>
					<td>> 11 páginas</td>
					<td>Blanco y negro</td>
					<td>Color</td>
					<td>Resolución > 300 dpi</td>
				</tr>
				<tr>
					<th>Tarifa</th>
					<td>0.10 € por pág.</td>
					<td>0.08 € por pág.</td>
					<td>0.07 € por pág.</td>
					<td>0 €</td>
					<td>0.05 € por foto</td>
					<td>0.02 € por foto</td>
				</tr>
			</table>
			
			<table class="menu display-medium display-mini" title="Información con nuestras tarifas de impresión">
				<caption><b>Tarifas</b></caption>
				<tr>
					<th>Concepto</th>
					<th>Tarifa</th>
				</tr>
				<tr>
					<td>&lt; 5 páginas</td>
					<td>0.10 € por pág.</td>
				</tr>
				<tr>
					<td>entre 5 y 10 páginas</td>
					<td>0.08 € por pág.</td>
				</tr>
				<tr>
					<td>> 11 páginas</td>
					<td>0.07 € por pág.</td>
				</tr>
				<tr>
					<td>Blanco y negro</td>
					<td>0 €</td>
				</tr>
				<tr>
					<td>Color</td>
					<td>0.05 € por foto</td>
				</tr>
				<tr>
					<td>Resolución > 300 dpi</td>
					<td>0.02 € por foto</td>
				</tr>
			</table>
		</article>
		<article id="SolicitudAlbum">
			<fieldset id="marcoSolicitudAlbum">
				<h3>Formulario de solicitud</h3>
				<p>Los parámetros marcados con (*) son obligatorios.</p>

				<form action="resSolicitud.php" method="GET">
					<p><label><b>Nombre (*)</b></label><input class="boxesAlbum" type="text" name="nombre" placeholder="Nombre y Apellidos..." maxlength="200" required></p>
					<p><label><b>Título (*)</b></label> <input class="boxesAlbum" type="text" name="titulo" placeholder="Título para el álbum..." maxlength="200" required></p>
					<p><label><b>Texto adicional</b> </label><input class="bigBoxes" type="text" name="descripcion" placeholder="Descripción, dedicatoria..." maxlength="4000"></p>
					<p><label><b>Correo electrónico (*)</b> </label><input class="boxesAlbum" type="email" name="correo" placeholder="alguien@algo.es" autocomplete="on" maxlength="200" required></p>
					<p><label><b>Dirección (*)</b> </label><input class="boxesAlbum" type="text" name="calle" placeholder="Calle..." required>
						<input class="direccion" type="number" name="numero" placeholder="Número" min="1">
						<input class="direccion" type="number" name="cp" placeholder="Código Postal" required></p>
						<p><select class="direccion" required>
							<option disabled selected value> - Localidad - </option>
							<option value="SanVicentdelRaspeig">San Vicent del Raspeig</option>
						</select>
						<select class="direccion" required>
							<option disabled selected value> - Provincia - </option>
							<option value="3">Alicante</option>
						</select>
						<select class="direccion" required>
							<option disabled selected value> - País - </option>
							<option value="Spain">España</option>
						</select>
					 </p>
					 <p><label><b>Teléfono de contacto (*)</b></label><input class="boxesAlbum" type="tel" name="telefono" placeholder="### ### ###" required></p>
					<p><label><b>Color de portada</b> </label><input type="color" name="color"></p>
					<p><label><b>Número de copias</b> </label><input class="numCopias" type="number" name="copias" value="1" min="1" required></p>
					<p><label><b>Resolución de impresión</b> </label><input class="valorRango" type="range" id="resslider" name="resolucion" min="150" max="900" step="150" value="150" onchange="document.getElementById('outresolucion').textContent=this.value">
						<output id="outresolucion">150</output> dpi
					</p>
					<p><label><b>Álbum (*)</b></label>
						<select class="direccion" name="album" required>
							<option disabled selected value> - mis álbumes - </option>
						  	<option value="paisajes">Paisajes</option>
						  	<option value="bodajm">Boda Jose María</option>
						  	<option value="viajeitalia">Viaje Italia</option>
						</select>
					 </p>
					 <p><label><b>Fecha de recepción aproximada </b></label><input class="direccion" type="date" name="fechaRecepcion"></p>
					<p class="menu display-great display-medium"><label><b>¿Impresión a color? (*)</b> </label><br><input type="radio" name="cimpresion" value="color" required>Color <input type="radio" name="cimpresion" value="blancoynegro" required>Blanco y Negro </p>
					<!--<p class="display-mini"><label><b>¿Impresión a color? (*)</b> </label>
						<select class="direccion" required>
							<option disabled selected value> - Tipo de Impresión - </option>
							<option value="blancoynegro">Blanco y Negro</option>
							<option value="color">Color</option>
						</select>
					</p> -->
					<p><input id="solicitarAlbum" type="submit" value="Solicitar" title="Solicitar impresión"></p>

				</form>	
			</fieldset>
		</article>
		
	</section>

	<?php
		require_once("includes/pie.inc");  # Pie de la pagina con el copyright
	?>

</body>
</html>