<?php 

class  Venta{

    private $db;
    private $ventas;

    public function __construct(){
        $this->db = Conexion::conectar();
        $this->ventas = [];
    }

    public function listarVentas(){
        $sql = "SELECT * FROM venta ORDER BY fecha DESC";
        $resultado = $this->db->query($sql);

        if(!$resultado){
            echo "Lo sentimos, este sitio esta experimentando problemas";
            exit;
        }  

        while($row = $resultado->fetch_assoc()){
            $this->ventas[] = $row;
        }
        return $this->ventas;
    }

    public function insert ($fecha, $total){
        $stmt = $this->db->prepare("INSERT INTO venta(fecha, total, activo) VALUES (?, ?, 1)");
        $stmt->bind_param("si", $fecha, $total);
        $stmt->execute();
        return $this->db->insert_id;
    }

    public function insertDetalleVenta ($idVenta, $idProducto, $cantidadVenta, $totalVenta){
        $stmt = $this->db->prepare("INSERT INTO detalle_venta(id_venta, id_producto, cantidad_vendida, total) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $idVenta, $idProducto, $cantidadVenta, $totalVenta);
        $stmt->execute();
    }

    public function listarVenta($idVenta){
        $sql = "SELECT * FROM venta WHERE id = $idVenta;";
        $resultado = $this->db->query($sql);
        $row = $resultado->fetch_assoc();
        return $row;
    }

    public function listarProductosVenta($idVenta){
        $sql = "SELECT p.id, p.nombre, (dv.total / dv.cantidad_vendida) AS precio_venta, dv.cantidad_vendida 
        FROM venta v INNER JOIN detalle_venta dv ON (v.id = dv.id_venta)
        INNER JOIN producto p ON (dv.id_producto = p.id) WHERE v.id = $idVenta";
        $resultado = $this->db->query($sql);

        if(!$resultado){
            echo "Lo sentimos, este sitio esta experimentando problemas";
            exit;
        }  

        $this->ventas = [];
        while($row = $resultado->fetch_assoc()){
            $this->ventas[] = $row;
        }
        return $this->ventas;
    }

    public function delete($idVenta){
        $sql = "UPDATE venta SET activo=0 WHERE id=$idVenta";
        $this->db->query($sql);
    }

    public function listarVentasFiltradas($totalMin = null, $totalMax = null, $fechaInicio = null, $fechaFin = null, $estadoVenta = null) {
        $sql = "SELECT * FROM venta WHERE 1=1";
        $params = [];

        if (!is_null($totalMin)) {
            $sql .= " AND total >= ?";
            $params[] = $totalMin;
        }

        if (!is_null($totalMax)) {
            $sql .= " AND total <= ?";
            $params[] = $totalMax;
        }

        if (!is_null($fechaInicio)) {
            $sql .= " AND fecha >= ?";
            $params[] = $fechaInicio;
        }

        if (!is_null($fechaFin)) {
            $sql .= " AND fecha <= ?";
            $params[] = $fechaFin;
        }

        if (!is_null($estadoVenta)) {
            $sql .= " AND activo = ?";
            $params[] = $estadoVenta;
        }

        $sql .= " ORDER BY fecha DESC";

        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            echo "Lo sentimos, este sitio está experimentando problemas.";
            exit;
        }

        if (!empty($params)) {
            $types = str_repeat('s', count($params)); 
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $resultado = $stmt->get_result();

        $ventas = [];

        while ($row = $resultado->fetch_assoc()) {
            $ventas[] = $row;
        }

        return $ventas;
    }

    public function listarVentasPorEstadoYFechas($estadoVenta, $fechaInicio, $fechaFin) {
        $sql = "SELECT * FROM venta WHERE 1=1";
        $params = [];
        $types = "";

        if (!is_null($estadoVenta) && $estadoVenta !== '') {
            $sql .= " AND activo = ?";
            $types .= "i";
            $params[] = $estadoVenta;
        }

        if (!is_null($fechaInicio) && $fechaInicio !== '') {
            $sql .= " AND fecha >= ?";
            $types .= "s";
            $params[] = $fechaInicio;
        }

        if (!is_null($fechaFin) && $fechaFin !== '') {
            $sql .= " AND fecha <= ?";
            $types .= "s";
            $params[] = $fechaFin;
        }

        $sql .= " ORDER BY fecha DESC";
        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            die("Error al preparar la consulta: " . $this->db->error);
        }

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $ventas = [];
        while ($row = $result->fetch_assoc()) {
            $ventas[] = $row;
        }

        return $ventas;
    }


}