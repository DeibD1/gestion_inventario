<?php 
    require_once './lib/dompdf/autoload.inc.php';
    use Dompdf\Dompdf;

class VentaController{
    private $venta;
    private $producto;

    public function __construct(){
        session_start();

        if (!isset($_SESSION['rol'])) {
            header("Location: index.php?controlador=User&accion=login");
            exit();
        }

        $rolesPermitidos = ['admin', 'cajero'];
        if (!in_array($_SESSION['rol'], $rolesPermitidos)) {
            require_once "views/users/accesoDenegado.php";
            exit();
        }

        require_once "models/Producto.php";
        $this->producto = new Producto();

        require_once "models/Venta.php";
        $this->venta = new Venta();
    }

    public function index(){
        $data['titulo'] = "Listado de Ventas";
        $ventas = $this->venta->listarVentas();
    
        $ventasFormateadas = [];
        foreach ($ventas as $venta) {
            $venta['total'] = '$' . number_format($venta['total'], 0, ',', '.');
            $ventasFormateadas[] = $venta;
        }
    
        $data['ventas'] = $ventasFormateadas;

        $data['idVenta'] = isset($_GET['idVenta']) ? $_GET['idVenta'] : null;

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

        header("Location: index.php?controlador=Venta&accion=index&idVenta=$idVenta");
        exit();
    }

    public function verInformacionVenta($idVenta){
        $data['titulo'] = "Listado de Ventas";
        $ventas = $this->venta->listarVentas();
        $ventasFormateadas = [];
        foreach ($ventas as $venta) {
            $venta['total'] = '$' . number_format($venta['total'], 0, ',', '.');
            $ventasFormateadas[] = $venta;
        }
        $data['ventas'] = $ventasFormateadas;

        $ventaSeleccionada = $this->venta->listarVenta($idVenta);
        $data['productosVendidos'] = $this->venta->listarProductosVenta($idVenta);
        $data['infoVenta'] = true;

        require_once "views/venta/index.php";
    }

    public function generarReportePDF() {
        $estado = $_POST['estadoVenta'] ?? null;
        $fechaInicio = $_POST['fechaInicio'] ?? null;  
        $fechaFin = $_POST['fechaFin'] ?? null;   

        date_default_timezone_set('America/Bogota'); 

        if ($fechaInicio) {
            $fechaInicio = date('Y-m-d', strtotime(str_replace('/', '-', $fechaInicio)));
        }

        if ($fechaFin) {
            $fechaFin = date('Y-m-d', strtotime(str_replace('/', '-', $fechaFin)));
        }

        $ventas = $this->venta->listarVentasPorEstadoYFechas($estado, $fechaInicio, $fechaFin);
        
        $parametrosDebug = [
            'estado' => $estado,
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin
        ];

        $nombreEmpresa = "Empresa Importante del Sector";
        $NIT = "2342343453";
        $direccion = "Barrio Picaleña #45-34";
        $telefono = "3452345324";
        $fechaGeneracion = date('Y-m-d H:i:s');

        $ventasFormateadas = [];
        foreach ($ventas as $venta) {
            $venta['total'] = '$' . number_format($venta['total'], 0, ',', '.');
            $venta['estado'] = $venta['activo'] == 1 ? 'Activa' : 'Cancelada';
            $ventasFormateadas[] = $venta;
        }

        $filtros = [
            'estado' => $estado,
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
            'debug' => $parametrosDebug
        ];

        $ventasReporte = $ventasFormateadas;
        extract(compact('nombreEmpresa', 'NIT', 'direccion', 'telefono', 'fechaGeneracion', 'ventasReporte', 'filtros', 'parametrosDebug'));

        ob_start();
        include "views/venta/reporte.php";
        $html = ob_get_clean();

        $dompdf = new Dompdf();
        $options = $dompdf->getOptions();
        $options->set(['isRemoteEnabled' => true]);
        $dompdf->setOptions($options);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('letter', 'portrait');
        $dompdf->render();

        $nombreArchivo = "reporte_ventas";
        if ($fechaInicio && $fechaFin) {
            $nombreArchivo .= "_" . str_replace(['-', '/'], '_', $fechaInicio) . "_a_" . str_replace(['-', '/'], '_', $fechaFin);
        }
        if ($estado) {
            $nombreArchivo .= "_" . strtolower($estado);
        }
        $nombreArchivo .= ".pdf";

        $dompdf->stream($nombreArchivo, ["Attachment" => true]);
    }



    public function filtrarVentas(){

        $totalMin = isset($_POST['totalMin']) && trim($_POST['totalMin']) !== '' ? $_POST['totalMin'] : null;
        $totalMax = isset($_POST['totalMax']) && trim($_POST['totalMax']) !== '' ? $_POST['totalMax'] : null;
        $fechaInicio = isset($_POST['fechaInicio']) && trim($_POST['fechaInicio']) !== '' ? $_POST['fechaInicio'] : null;
        $fechaFin = isset($_POST['fechaFin']) && trim($_POST['fechaFin']) !== '' ? $_POST['fechaFin'] : null;
        $estadoVenta = isset($_POST['estadoVenta']) && $_POST['estadoVenta'] !== '' ? $_POST['estadoVenta'] : null;


        $data['titulo'] = "Listado de Ventas";
        $ventas = $this->venta->listarVentasFiltradas($totalMin, $totalMax, $fechaInicio, $fechaFin, $estadoVenta);
        $ventasFormateadas = [];
        foreach ($ventas as $venta) {
            $venta['total'] = '$' . number_format($venta['total'], 0, ',', '.');
            $ventasFormateadas[] = $venta;
        }
        $data['ventas'] = $ventasFormateadas;

        $data['filtros'] = [
            'totalMin' => $totalMin,
            'totalMax' => $totalMax,
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
            'estadoVenta' => $estadoVenta
        ];

        extract($data);

        require_once "views/venta/index.php";
    }

    public function generarFactura($idVenta) {
        $data['nombreEmpresa'] = "Empresa Importante del Sector";
        $data['NIT'] = "2342343453";
        $data['direccion'] = "Barrio Picaleña #45-34";
        $data['telefono'] = "3452345324";

        $ventaSeleccionada = $this->venta->listarVenta($idVenta);
        $ventaSeleccionada['total'] = rtrim(rtrim($ventaSeleccionada['total'], '0'), '.');

        $productosVendidos = $this->venta->listarProductosVenta($idVenta);

        foreach ($productosVendidos as &$producto) {
            $producto['precio_venta'] = rtrim(rtrim($producto['precio_venta'], '0'), '.');
        }
        unset($producto); 

        ob_start();
        include "views/venta/factura.php";
        $html = ob_get_clean();

        $dompdf = new Dompdf();

        $options = $dompdf->getOptions();
        $options->set(['isRemoteEnabled' => true]);
        $dompdf->setOptions($options);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('letter');
        $dompdf->render();

        $dompdf->stream("factura_venta_$idVenta.pdf", ["Attachment" => true]);
    }

    public function delete($idVenta){
        $this->venta->delete($idVenta);
        header("Location: index.php?controlador=Venta&accion=index");
        exit();
    }

    public function reporteVentas(){
    $data['titulo'] = "Generar Reporte de Ventas";
    
    if (isset($_POST['generarReporte'])) {
        $estado = isset($_POST['estado']) ? $_POST['estado'] : '';
        $fechaInicio = isset($_POST['fechaInicio']) ? $_POST['fechaInicio'] : '';
        $fechaFin = isset($_POST['fechaFin']) ? $_POST['fechaFin'] : '';
        
        header("Location: index.php?controlador=Venta&accion=generarReportePDF" . 
               "&estado=" . urlencode($estado) . 
               "&fechaInicio=" . urlencode($fechaInicio) . 
               "&fechaFin=" . urlencode($fechaFin));
        exit();
    }
    
    $ventas = $this->venta->listarVentas();
    $ventasFormateadas = [];
    foreach ($ventas as $venta) {
        $venta['total'] = '$' . number_format($venta['total'], 0, ',', '.');
        $ventasFormateadas[] = $venta;
    }
    
    $data['ventas'] = $ventasFormateadas;
    
    require_once "views/venta/reporteVentas.php";
}

}
?>