<?php

class Conexion{

    public static function conectar(){
        
        //Cadena de conexion
        $conexion = new mysqli("localhost", "root", "", "gestion_inventario");

        if(!$conexion){
            die("Conexion fallida: ". mysqli_connect_error());
        }
        return $conexion;
    } 

}
?>