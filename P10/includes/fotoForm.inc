<?php
	if($sitio == "perfil"){
        $directorio = "./recursos/perfiles/";
    }else if($sitio == "foto"){
        $directorio = "./recursos/";
    }

    if($_FILES['foto']['error']==4) #Ningun fichero subido
	{
		$newName = "EjemploPerfil.png"; #Ponemos la foto por defecto
	}
	else
	{
		require_once("includes/checkName.inc");
	}

	#Comprobamos que no haya ningun error con el fichero subido
	if($_FILES['foto']['error']>0)
	{
		if(($_FILES['foto']['error']==1) || ($_FILES['foto']['error']==2)) #Fichero mayor que el tam maximo
		{
			$extra2 ="registroFotoTamErr"; 
			require_once("redireccion.inc");
		}
		echo 'Error: ' . $_FILES['foto']['error'] . "Nombre: " . $fotoPerfil;
	}
	else
	{	
		echo "Entro aqui ostia3";
		#echo $_FILES['foto']['type'];
		#Comprobamos el tipo del archivo 
		if(($_FILES["foto"]["type"]=="image/png") || ($_FILES["foto"]["type"]=="image/jpeg") || ($_FILES["foto"]["type"]=="image/jpg"))
		{
			if(isset($origen) && $origen=="modificar" && $fotoPerfil!="EjemploPerfil.png")
			{
				unlink( "./recursos/perfiles/" .$fotoPerfil);
			}
			move_uploaded_file($_FILES["foto"]["tmp_name"], $directorio . $newName);
			$fotoPerfil = $newName; #Nombre de la nueva foto de perfil
		}
		else
		{
			$extra2 ="registroFotoTipoErr"; 
			require_once("redireccion.inc");
		}
	}
?>