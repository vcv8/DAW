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
		require_once("includes/cabecera2.inc");  # Cabecera de la pagina con solo logo
	?>

	<section class="Inicio-Registro"> <!--Formulario de Registro -->
		<fieldset class="marcoInicioRegistro">
			<h2>Registro</h2>
			<form action="resRegistro.php" method="POST">
				<p><input class="boxesForm" type="text" name="Usuario" placeholder="Usuario" autocomplete="on" required></p>
				<p><input class="boxesForm" type="password" name="Contraseña" placeholder="Contraseña" required></p>
				<p><input class="boxesForm" type="password" name="Contraseña2" placeholder="Repetir Contraseña" required></p>
				<p><input class="boxesForm" type="email" name="Correo" placeholder="Correo" required></p>
				<p><input class="boxesForm" type="text" name="Sexo" placeholder="Sexo"></p>
				<!--<p><input type="date" name="Fecha Nacimiento" min="1918-01-01" max="2000-01-01" required></p>-->
				<p>
					<select required class="mes" name="Mes">
							<option disabled selected value selected="selected" >  Mes de Nacimiento  </option>
						  	<option value="1">Enero</option>
						  	<option value="2">Febrero</option>
						  	<option value="3">Marzo</option>
					</select>
					<input class="diaMes" type="number" name="Dia" placeholder="Día" max="31" min="1"> <input class="diaMes"  type="number" name="Año" placeholder="Año" max="2000" min="1918">
			    </p>
				<p><input class="boxesForm" type="text" name="Ciudad" placeholder="Ciudad" required=""></p>
				<p><input class="boxesForm" type="text" name="País" placeholder="País" required=""></p>
				<p><Strong>Foto Perfil</Strong></p>
				<p><input type="file" name="pic" accept="image/*"></p>
				<p><input class="enlaceBoton" type="submit" value="Registrarse"></p>
			</form>

			<p>¿Ya tienes cuenta? <a href="login.php" class="swaplink">Iniciar Sesión</a> </p>
		</fieldset>
	</section>

	<?php
		require_once("includes/pie.inc");  # Pie de la pagina con el copyright
	?>

</body>
</html>