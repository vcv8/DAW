<?php 
    $newFile =  $_FILES['foto']['name'];

    $sitio = "perfil";

    if($sitio == "perfil"){
        $directorio = "recursos/";
    }else if($sitio == "foto"){
        $directorio = "recursos/perfiles/";
    }

    if($handle = opendir($directorio)){

        $num = 1;

        while (false !== ($fichero = readdir($handle))) {
            if(is_file($fichero) && $fichero==$newFile){
            	list($name, $format) = explode(".", $newFile);
                $name = $name. "$num";
                $newName = $name . "." . $format;
                $num++;
            }
        }

        closedir($handle);
    }

    echo $newName;
?>