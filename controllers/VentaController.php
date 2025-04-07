<?php 

class VentaController{
    private $venta;
    private $producto;

    public function __construct(){
        require_once "models/Producto.php";
        $this->producto = new Producto();
        require_once "models/Venta.php";
        $this->venta = new Venta();
    }

    public function index(){
        $data['titulo'] = "Listado de Ventas";
        $ventas = $this->venta->listarVenta();
    
        $ventasFormateadas = [];
        foreach ($ventas as $venta) {
            $venta['total'] = '$' . number_format($venta['total'], 0, ',', '.');
            $ventasFormateadas[] = $venta;
        }
    
        $data['ventas'] = $ventasFormateadas;
        require_once "views/venta/index.php";
    }

    public function insert(){   
        $data['productos'] = $this->producto->listarProductosVenta();
        $data['nombre_productos'] = array_map(fn($p) => $p['nombre'], $data['productos']);
        $data['titulo'] = "Registro de Ventas";
        require_once "views/venta/insert.php";
    }

    public function store(){
        $fecha = $_POST['fecha'];
        $productos = $_POST['productos'];
        $total_venta = $_POST['totalVenta'];

        $idVenta = $this->venta->insert($fecha, $total_venta);

        foreach ($productos as $producto) {
            $idProducto = $producto['id'];
            $cantidadVenta = $producto['cantidad'];
            $precioUnitario = $producto['precio'];
            $totalDetalle = $cantidadVenta * $precioUnitario;
    
            $this->venta->insertDetalleVenta($idVenta, $idProducto, $cantidadVenta, $totalDetalle);
            $this->producto->updateCantidad($idProducto, $cantidadVenta);
        }

        header("Location: index.php?controlador=Venta&accion=index");
        exit();
    }
}


?>