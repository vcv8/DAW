<section class="Inicio-Registro"> <!--Formulario de Registro -->
	<fieldset class="marcoInicioRegistro">
		<h2><?php if($site == 'reg'){ echo 'Registro de usuario'; } 
				else{ echo 'Modificar datos personales'; } ?>			
		</h2>
		<form action="<?php if($site == 'reg'){ echo 'resRegistro.php'; } else{ echo 'resRegistro.php';} ?>" method="POST">
			<p>Usuario: </p>
			<p><input class="boxesForm" type="text" name="Usuario" placeholder="Usuario" autocomplete="on" <?php if($site == 'mod'){echo 'value="'. $pam[0] .'"';} ?> required></p>
			<p>Contraseña: </p>
			<p><input class="boxesForm" type="password" name="Contraseña" placeholder="Contraseña" <?php if($site == 'mod'){echo 'value="'. $pam[1] .'"';} ?> required></p>
			<p><input class="boxesForm" type="password" name="Contraseña2" placeholder="Repetir Contraseña" <?php if($site == 'mod'){echo 'value="'. $pam[1] .'"';} ?> required></p>
			<p>Correo actual: </p>
			<p><input class="boxesForm" type="email" name="Correo" placeholder="Correo" <?php if($site == 'mod'){echo 'value="'. $pam[2] .'"';} ?> required></p>
			<p>Sexo: </p>
			<p><input type="radio" id="s1" name="Sexo" value="Hombre" <?php if($site == 'mod'){ if(!$userData['Sexo']){ echo "checked"; } } ?> required>Hombre</p>
		    <p><input type="radio" id="s2" name="Sexo" value="Mujer" <?php if($site == 'mod'){ if($userData['Sexo']){ echo "checked"; } } ?> required>Mujer</p>
			<p>F.Nacimiento: </p>
			<p><input class="boxesForm" type="date" name="fNacimiento" <?php if($site == 'mod'){echo 'value="'. $pam[3] .'"';} ?> required></p>
		    <p>Ciudad: </p>
			<p><input class="boxesForm" type="text" name="Ciudad" placeholder="Ciudad" <?php if($site == 'mod'){echo 'value="'. $pam[4] .'"';} ?> required></p>
			<p>País: </p>
			<?php
				#Obtenemos los paises disponibles
				$sentencia1 = "SELECT NomPais FROM paises";
				$pais = $mysqli->query($sentencia1);  
				if(!$pais || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
				{
					die("Error: no se pudo realizar la consulta: " . $mysqli->error);
				}
			?>
			<select class="boxesForm" name="País" required>
					<?php 
						if($site == 'reg'){ echo '<option value disabled selected>- Selección de País -</option>'; }
						while($fila1 = $pais->fetch_assoc())  # Obtenemos el resultado fila a fila en forma de array asociativo
						{

					?>
				<option value="<?php echo $fila1['NomPais'] .'"'; if($site=='mod' and $fila1['NomPais']==$pam[5]){ echo "selected"; } ?> "><?php echo $fila1['NomPais'] ?></option>
					<?php 
						}

						# Cerramos la sesion con la BD y liberamos la memoria
						$pais ->free();
						$mysqli->close();
					?>
			</select>
			<p><Strong>Foto Perfil</Strong></p>
			<p><input type="file" name="pic" accept="image/*"></p>
			<p><input class="enlaceBoton" type="submit" 
				<?php if($site == 'reg'){ echo 'value="Registrarse"'; } 
				else{ echo 'value="Modificar"'; } ?>
			</p>
		</form>
		
		<?php
			if($site == 'reg'){
				echo $pam;	
			}
		?>
	</fieldset>
</section>