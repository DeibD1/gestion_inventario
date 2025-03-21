<?php

class ProductoController{

    private $producto;

    public function __construct(){
        require_once "models/Producto.php";
        $this->producto = new Producto();
    }

    public function index(){

        $data['titulo'] = "Listado de Productos";
        $data['productos'] = $this->producto->listarProductos();
        require_once "views/producto/index.php";
    }

    public function delete($idProducto){
        $this->producto->delete($idProducto);
        header("Location: index.php?controlador=Producto&accion=index");
        exit();
    }

}

?>