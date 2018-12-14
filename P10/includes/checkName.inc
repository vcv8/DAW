<?php 
    $newName =  $_FILES['foto']['name'];

    if($sitio == "perfil"){
        $directorio = "./recursos/perfiles/";
    }else if($sitio == "foto"){
        $directorio = "./recursos/";
    }

    list($name, $format) = explode(".", $newName);
    $num = 1;
    $nameTemp = $newName;

    do{
        $change = 0;

        if(file_exists($directorio . $nameTemp)){
            $nameTemp = $name . "$num" . "." . $format;
            $num++;
            $change = 1;
        }

    }while($change == 1);

    $newName=$nameTemp;
?>