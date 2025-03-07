<?php
    require_once "config/config.php";
    require_once "core/routes.php";

    require_once "config/Conexion.php";
    require_once "controllers/ProductoController.php";
    
    if(isset($_GET['controlador']))
    {
        $controlador = cargarControlador($_GET['controlador']);

        if(isset($_GET['accion'])){

            if(isset($_GET['id'])){
                
                
                if(isset($_GET['idAmenaza'])){
                    cargarAccion($controlador, $_GET['accion'], $_GET['id'], $_GET['idAmenaza'], $_GET['idSalvaguarda']);
                }else{
                    cargarAccion($controlador, $_GET['accion'], $_GET['id']);
                }

            }else {
                cargarAccion($controlador, $_GET['accion']);
            }
            
        }else{
            cargarAccion($controlador, ACCION_PRINCIPAL);
        }
    }else{
        $controlador = cargarControlador(CONTROLADOR_PRINCIPAL);
        cargarAccion($controlador, ACCION_PRINCIPAL);
    }
?>