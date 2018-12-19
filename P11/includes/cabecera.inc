<header id="header">
		<div class="headerItems">
			<!-- Logotipo -->
			<a href="index.php">
				<div><img src="recursos/pretilg.png" alt="Preti Logo" class="imagen"></div>
				<div class="display-medium display-great"><h1>Preti.</h1></div>
				<div class="display-great"><h2>Creativity & Beyond</h2></div>
			</a>

			<!-- Menu -->
			<span>
				<label for="ckburger" id="burger"></label>
			</span>

			<!-- Enlaces a Login/Registro -->
			<div>
				<a href="login.php"><span class="icon-user"></span><span>Login</span></a><a href="registro.php" id="aReg"><span class="icon-user-plus"></span><span>Registro</span></a>
			</div>
		</div>

		<input type="checkbox" id="ckburger" checked>
		<nav id="navbar">
			<ul>
				<li class="firstlast"><a href="index.php"><span class="icon-home"> Inicio</a></li><li><a href="buscar.php"><span class="icon-search"> Búsqueda Avanzada</a></li><li class="firstlast"><form action="resBuscar.php" method="get">
						<input type="search" id="brbar" name="brapida" placeholder='Buscar... '><input type="submit" id="brbutton" name="buscador" value="🔍" >
					</form>
				</li>
			</ul>
		</nav>
</header>