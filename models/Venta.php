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
        $sql = "DELETE FROM venta WHERE id=$idVenta";
        $this->db->query($sql);
    }

}