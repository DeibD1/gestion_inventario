<?php 

class Proveedor{
    //Atributos
    private $db;
    private $proveedores;

    public function __construct(){
        $this->db = Conexion::conectar();
        $this->proveedores = [];
    }


    public function listarProveedores(){
        $sql = "SELECT * FROM proveedor ORDER BY id";
        $resultado = $this->db->query($sql);

        if(!$resultado){
            echo "Lo sentimos, este sitio esta experimentando problemas";
            exit;
        }  

        while($row = $resultado->fetch_assoc()){
            $this->proveedores[] = $row;
        }

        return $this->proveedores;
    }


    public function insert($nombre, $telefono, $direccion, $email){
        $sql = "INSERT INTO proveedor(nombre, telefono, direccion, email) 
        VALUES ('$nombre','$telefono','$direccion','$email')";

        $this->db->query($sql);
    }

    public function getProveedor($idProveedor){
        $sql = "SELECT * FROM proveedor 
        WHERE id=$idProveedor";

        $resultado = $this->db->query($sql);
        $row = $resultado->fetch_assoc();
        return $row;
    }   


    public function update($idProveedor, $nombre, $telefono, $direccion, $email){
        $sql = "UPDATE `proveedor` 
        SET nombre='$nombre', telefono='$telefono', direccion='$direccion', email='$email' 
        WHERE id=$idProveedor";

        $this->db->query($sql);
    }

    public function delete($idProveedor){
        $sql = "DELETE FROM proveedor WHERE id=$idProveedor";
        $this->db->query($sql);
    }
}
?>