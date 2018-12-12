<?php 
	$newFile =  "hola.jpg";
	list($name, $format) = explode(".", $newFile);

	$sitio = "perfil";

	if($sitio == "perfil"){
		$directorio = "recursos/";
	}else if($sitio == "foto"){
		$directorio = "recursos/perfiles/";
	}

	if($handle = opendir($directorio)){
		
		$num = 1;

		while (false !== ($fichero = readdir($handle))) {
			if(is_file($fichero) && $fichero==$name){
				$name = $name. "$num";
				$num++;
			}
		}

		closedir($handle);
	}

	$newName = $name . $format;
?>