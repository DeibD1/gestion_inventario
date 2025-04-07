<?php 

class Producto{

    private $db;
    private $productos;

    public function __construct(){
        $this->db = Conexion::conectar();
        $this->productos = [];
    }

    public function listarProductos(){
        $sql = "SELECT prod.*, prov.nombre as proveedor 
        FROM producto prod INNER JOIN proveedor prov ON prod.id_proveedor = prov.id ORDER by prod.cantidad;";
        $resultado = $this->db->query($sql);

        if(!$resultado){
            echo "Lo sentimos, este sitio esta experimentando problemas";
            exit;
        }  

        while($row = $resultado->fetch_assoc()){
            $this->productos[] = $row;
        }
        return $this->productos;
    }

    public function insert ($nombre, $descripcion, $cantidad, $precio_neto, $precio_venta, $fecha_ingreso ,$proveedor){
        $sql = "INSERT INTO producto(nombre, descripcion, cantidad, precio_neto, precio_venta, fecha_ingreso, id_proveedor) 
        VALUES ('$nombre','$descripcion',$cantidad,$precio_neto,$precio_venta,'$fecha_ingreso',$proveedor)";
        $this->db->query($sql);
    }

    public function update($id_producto, $nombre, $descripcion, $cantidad, $precio_neto, $precio_venta, $fecha_ingreso ,$proveedor){
        $sql = "UPDATE `producto` 
        SET nombre='$nombre', descripcion='$descripcion', cantidad=$cantidad, precio_neto=$precio_neto, 
        precio_venta=$precio_venta, fecha_ingreso='$fecha_ingreso', id_proveedor=$proveedor
        WHERE id=$id_producto";

        $this->db->query($sql);
    }

    public function getProducto($idProducto){
        $sql = "SELECT * FROM producto 
        WHERE id=$idProducto";

        $resultado = $this->db->query($sql);
        $row = $resultado->fetch_assoc();
        return $row;
    }   

    public function delete($idProducto){
        $sql = "DELETE FROM producto WHERE id=$idProducto";
        $this->db->query($sql);
    }

    public function listarProductosVenta(){
        $sql = "SELECT id, nombre, cantidad, precio_venta FROM producto ORDER BY nombre;";
        $resultado = $this->db->query($sql);

        if(!$resultado){
            echo "Lo sentimos, este sitio esta experimentando problemas";
            exit;
        }  

        while($row = $resultado->fetch_assoc()){
            $this->productos[] = $row;
        }
        return $this->productos;
    }

    public function updateCantidad($id_producto, $cantidad){
        $stmt = $this->db->prepare("UPDATE producto SET cantidad = cantidad - ? WHERE id = ?");
        $stmt->bind_param("ii", $cantidad, $id_producto);
        $stmt->execute();
    }

}

?>