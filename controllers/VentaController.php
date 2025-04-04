<?php 

class VentaController{
    private $venta;
    private $productos;

    public function __construct(){
        require_once "models/Producto.php";
        $this->productos = new Producto();
        $this->venta = [];
    }

    public function index(){
        $data['titulo'] = "Listado de Ventas";
        require_once "views/venta/index.php";
    }

    public function insert(){   
        $data['titulo'] = "Registro de Ventas";
        require_once "views/venta/insert.php";
    }


}


?>