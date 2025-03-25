<?php

class ProductoController{

    private $producto;
    private $proveedor;

    public function __construct(){
        require_once "models/Producto.php";
        $this->producto = new Producto();
        require_once "models/Proveedor.php";
        $this->proveedor = new Proveedor();
    }

    public function index(){
        $data['titulo'] = "Listado de Productos";
        $data['productos'] = $this->producto->listarProductos();
        require_once "views/producto/index.php";
    }
    

    public function insert(){   
        $data['titulo'] = "Registra un producto";
        $data['proveedores'] = $this->proveedor->seleccionarProveedores();
        require_once "views/producto/insert.php";
    }

    public function store(){

        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $cantidad = $_POST['cantidad'];
        $precio_neto = $_POST['precio_neto'];
        $precio_venta = $_POST['precio_venta'];
        $fecha_ingreso = $_POST['fecha_ingreso'];
        $proveedor = $_POST['proveedor'];

        $this->producto->insert($nombre, $descripcion, $cantidad, $precio_neto, $precio_venta, $fecha_ingreso ,$proveedor);
        
        header("Location: index.php?controlador=Producto&accion=index");
        exit();
    }

    public function edit($idProducto){
        $data['titulo'] = "Actualizar Producto";
        $data['producto'] = $this->producto->getProducto($idProducto);
        $data['proveedores'] = $this->proveedor->seleccionarProveedores();
        require_once "views/producto/edit.php";
    }

    public function update(){
        $id_producto = $_POST['id_producto'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $cantidad = $_POST['cantidad'];
        $precio_neto = $_POST['precio_neto'];
        $precio_venta = $_POST['precio_venta'];
        $fecha_ingreso = $_POST['fecha_ingreso'];
        $proveedor = $_POST['proveedor'];

        $this->producto->update($id_producto, $nombre, $descripcion, $cantidad, $precio_neto, $precio_venta, $fecha_ingreso ,$proveedor);
        
        header("Location: index.php?controlador=Producto&accion=index");
        exit();
    }

    public function delete($idProducto){
        $this->producto->delete($idProducto);
        header("Location: index.php?controlador=Producto&accion=index");
        exit();
    }

    public function reporte(){
        $data['titulo'] = "Listado de Productos";
        $data['productos'] = $this->producto->listarProductos();
        require_once "views/producto/reporte.php";
    }

}

?>