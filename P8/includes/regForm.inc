<section class="Inicio-Registro"> <!--Formulario de Registro -->
	<fieldset class="marcoInicioRegistro">
		<h2><?php if($site == 'reg'){ echo 'Registro'; } 
				else{ echo 'Modificar datos personales'; } ?>			
		</h2>
		<form action="resRegistro.php" method="POST">
			<?php
				if($site == 'mod'){
					echo "<p>Usuario actual: <b>$pam[0]</b></p>";
				}
			?>
			<p><input class="boxesForm" type="text" name="Usuario" placeholder="Usuario" autocomplete="on" required></p>
			<?php
				if($site == 'mod'){
					echo "<p>Contraseña actual: <b>$pam[1]</b></p>";	
				}
			?>
			<p><input class="boxesForm" type="password" name="Contraseña" placeholder="Contraseña" required></p>
			<p><input class="boxesForm" type="password" name="Contraseña2" placeholder="Repetir Contraseña" required></p>
			<?php
				if($site == 'mod'){
					echo "<p>Correo actual: <b>$pam[2]</b></p>";	
				}
			?>
			<p><input class="boxesForm" type="email" name="Correo" placeholder="Correo" required></p>
			<?php
				if($site == 'mod'){
					if($userData['Sexo']==1)
						echo "<p>Sexo actual: <b>Mujer</b></p>";
					else
						echo "<p>Sexo actual: <b>Hombre</b></p>";
				}
			?>
			<p><input class="boxesForm" type="text" name="Sexo" placeholder="Sexo"></p>
			<?php
				if($site == 'mod'){
					echo "<p>F.Nacimiento actual: <b>$pam[3]</b></p>";	
				}
			?>
			<p>
				<select required class="mes" name="Mes">
						<option disabled selected value selected="selected" >  Mes de Nacimiento  </option>
					  	<option value="1">Enero</option>
					  	<option value="2">Febrero</option>
					  	<option value="3">Marzo</option>
				</select>
				<input class="diaMes" type="number" name="Dia" placeholder="Día" max="31" min="1"> <input class="diaMes"  type="number" name="Año" placeholder="Año" max="2000" min="1918">
		    </p>
		    <?php
				if($site == 'mod'){
					echo "<p>Ciudad actual: <b>$pam[4]</b></p>";	
				}
			?>
			<p><input class="boxesForm" type="text" name="Ciudad" placeholder="Ciudad" required=""></p>
			<?php
				if($site == 'mod'){
					echo "<p>País actual: <b>$pam[5]</b></p>";	
				}

				#Obtenemos los paises disponibles
				$sentencia1 = "SELECT NomPais FROM paises";
				$pais = $mysqli->query($sentencia1);  
				if(!$pais || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
				{
					die("Error: no se pudo realizar la consulta: " . $mysqli->error);
				}
			?>
			<select class="boxesForm" name="pais" required>
				<option disabled selected value> - Selección del Pais - </option>
					<?php 
						while($fila1 = $pais->fetch_assoc())  # Obtenemos el resultado fila a fila en forma de array asociativo
						{

					?>
				<option value="<?php echo $fila1['NomPais'] ?>"><?php echo $fila1['NomPais'] ?></option>
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