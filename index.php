<?php
    require_once "config/config.php";
    require_once "core/routes.php";

    require_once "config/Conexion.php";
    require_once "controllers/ProductoController.php";
    
    if(isset($_GET['controlador']))
    {
        $controlador = cargarControlador($_GET['controlador']);

        if(isset($_GET['accion'])){

            if(isset($_GET['idProveedor'])){
                cargarAccion($controlador, $_GET['accion'], $_GET['idProveedor']);
            }else{
                if(isset($_GET['idProducto'])){
                    cargarAccion($controlador, $_GET['accion'], $_GET['idProducto']);
                }else{
                    cargarAccion($controlador, $_GET['accion']);
                }
            }
        }else{
            cargarAccion($controlador, ACCION_PRINCIPAL);
        }
    }else{
        $controlador = cargarControlador(CONTROLADOR_PRINCIPAL);
        cargarAccion($controlador, ACCION_PRINCIPAL);
    }



?>