<?php
	if($sitio == "perfil"){
        $directorio = "./recursos/perfiles/";
    }else if($sitio == "foto"){
        $directorio = "./recursos/";
    }

	require_once("includes/checkName.inc");

	#Comprobamos que no haya ningun error con el fichero subido
	if($_FILES['foto']['error']>0)
	{
		echo 'Error: ' . $_FILES['foto']['error'];
	}
	else
	{	
		#echo $_FILES['foto']['type'];
		#Comprobamos el tipo del archivo 
		if(($_FILES["foto"]["type"]=="image/png") || ($_FILES["foto"]["type"]=="image/jpeg") || ($_FILES["foto"]["type"]=="image/jpg"))
		{
			move_uploaded_file($_FILES["foto"]["tmp_name"], $directorio . $newName);
			$fotoPerfil = $newName; #Nombre de la nueva foto de perfil
		}
		else
		{	
			if($sitio=="perfil"){
				$extra2 ="registroFotoTipoErr"; 
				require_once("redireccion.inc");
			}
		}
	}
?>