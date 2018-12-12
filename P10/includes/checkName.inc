<?php 
    $newName =  $_FILES['foto']['name'];

    $sitio = "perfil";

    if($sitio == "perfil"){
        $directorio = "recursos/perfiles/";
    }else if($sitio == "foto"){
        $directorio = "recursos/";
    }

    echo $directorio;
    if($handle = opendir($directorio)){
        $num = 1;

        while (false !== ($fichero = readdir($handle))) {
            if(is_file($fichero) && $fichero==$newName){
                list($name, $format) = explode(".", $newName);
                $name = $name. "$num";
                $newName = $name . "." . $format;
                $num++;
            }
        }

        closedir($handle);
    }
?>