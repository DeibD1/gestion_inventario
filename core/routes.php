<?php

function cargarControlador($controlador)
{
    $nombreControlador = ucwords($controlador) . "Controller";
    $archivoControlador = "controllers/$nombreControlador.php";
    
    if(!is_file($archivoControlador)) // Si no existe el archivo
    {
        // Cargue el controlador principal
        $archivoControlador = "controllers/" . CONTROLADOR_PRINCIPAL . "Controller.php";
    }

    require_once $archivoControlador;
    $control = new $nombreControlador;
    return $control;
}


function cargarAccion($controlador, $accion, $idProveedor=null)
{   
    
    if(isset($accion) && method_exists($controlador, $accion))
    {
        if($idProveedor == null){
            $controlador->$accion();
        }else{
            $controlador->$accion($idProveedor);
        }
    } else {
        $controlador->ACCION_PRINCIPAL;
    }
}

?>