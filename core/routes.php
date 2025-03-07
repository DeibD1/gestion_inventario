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

function cargarAccion($controlador, $accion, $id=null, $idAmenaza=null, $idSalvaguarda=null)
{   
    
    if(isset($accion) && method_exists($controlador, $accion))
    {
        if($id == null){
            $controlador->$accion();
        }else{
            if($idAmenaza == null){
                $controlador->$accion($id);
            }else{
                $controlador->$accion($id, $idAmenaza, $idSalvaguarda);
            }
            
        }
    } else {
        $controlador->ACCION_PRINCIPAL;
    }
}

?>