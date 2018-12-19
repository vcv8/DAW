<?php

	#Recogemos los datos introducidos por el usuario
	$usuario = $_POST['Usuario'];
	$usuario = rtrim($usuario); # Elimina los espacios en blanco
	$pass = $_POST['Contraseña'];
	$pass = rtrim($pass);
	$pass2 = $_POST['Contraseña2'];
	$pass2 = rtrim($pass2);
	$correo = $_POST['Correo'];
	$sexo = $_POST['Sexo'];
	$ciudad = $_POST['Ciudad'];
	$pais = $_POST['País'];
	$dia = $_POST['fNacimiento'];
 
	#Validaciones de datos introducidos  (^->Empieza la cadena, $->Termina la cadena, +->Minimo un valor, {}->Repeticiones)
	#Usuario
	if(empty($usuario) || (!preg_match('/^[a-zA-Z0-9]{3,15}$/', $usuario)) ) #Usuario incorrecto
	{
		$extra2 ="registroUsuarioErr"; 
		require_once("redireccion.inc"); #Contiene los datos para redireccionar a otra pagina con el valor en redirecc	
	}
	else #Nombre de usuario duplicado
	{
		/*$sentencia1 = "SELECT nomUsuario FROM usuarios WHERE NomUsuario='$usuario'";
		$usuarioSent = $mysqli->query($sentencia1);  
		if(!$usuarioSent || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
		{
			die("Error: no se pudo realizar la consulta: " . $mysqli->error);
		}

		$fila = $usuarioSent->fetch_assoc();
		echo $fila['nomUsuario'];

		if($fila['nomUsuario']==$usuario)
		{
			$extra2 ="nombreDuplicError"; 
			require_once("redireccion.inc"); #Contiene los datos para redireccionar a otra pagina con el valor en redirecc
		}*/
	}

	#Contraseña. #Entre 6 y 15, minimo una mayus, una minusc y un numero. Se permite _
	if(empty($pass) || (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])[a-zA-Z0-9\_]{6,15}$/', $pass)) ) 
	{
		$extra2 ="registroContraErr"; 
		require_once("redireccion.inc");
	}

	#RepetirContraseña
	if($pass != $pass2)
	{	
		$extra2 ="registroContra2Err"; 
		require_once("redireccion.inc");
	}
			
	#Correo
	if(empty($correo) || !filter_var($correo, FILTER_VALIDATE_EMAIL)) 
	{
		/* Redirecciona a una página diferente que se encuentra en el directorio actual */ 
		$extra2 ="registroEmailErr"; 
		require_once("redireccion.inc");
	}

	#Sexo
	if($sexo=="Hombre")
	{
		$sexo=0;
	}
	else
	{
		if($sexo=="Mujer")
		{
			$sexo=1;
		}
		else
			{
				$extra2 ="registroSexoErr"; 
				require_once("redireccion.inc");
			}
	}

	#Pais
	if($pais!=null)
	{
		$sentencia = "SELECT idPais FROM paises WHERE Nompais='$pais'";
		$idPais = $mysqli->query($sentencia);  

		if(!$idPais || $mysqli->errno) # errno devuelve el codigo de error de la ultima funcion ejecutada
		{
			die("Error: no se pudo realizar la consulta: " . $mysqli->error);
		}

		$fila = $idPais->fetch_assoc();

		$pais = $fila['idPais'];
	}

	#Foto Perfil
	$sitio = "perfil";
	require_once("includes/fotoForm.inc");
	

	#$diaIngles = date_format($dia, "m/d/Y");
	#if(checkdate(month, day, year))

?>