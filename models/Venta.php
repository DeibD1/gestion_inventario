<?php 

class  Venta{

    private $db;
    private $ventas;

    public function __construct(){
        $this->db = Conexion::conectar();
        $this->ventas = [];
    }

    public function listarVenta(){
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
        $stmt = $this->db->prepare("INSERT INTO venta(fecha, total) VALUES (?, ?)");
        $stmt->bind_param("si", $fecha, $total);
        $stmt->execute();
        return $this->db->insert_id;
    }

    public function insertDetalleVenta ($idVenta, $idProducto, $cantidadVenta, $totalVenta){
        $stmt = $this->db->prepare("INSERT INTO detalle_venta(id_venta, id_producto, cantidad_vendida, total) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $idVenta, $idProducto, $cantidadVenta, $totalVenta);
        $stmt->execute();
    }

}