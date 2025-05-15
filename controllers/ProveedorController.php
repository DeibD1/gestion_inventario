<?php

class ProveedorController {
    private $proveedor;


    public function __construct() {
        session_start();

        if (!isset($_SESSION['rol'])) {
            header("Location: index.php?controlador=User&accion=login");
            exit();
        }

        $rolesPermitidos = ['admin', 'bodega'];
        if (!in_array($_SESSION['rol'], $rolesPermitidos)) {
            require_once "views/users/accesoDenegado.php";
            exit();
        }

        require_once "models/Proveedor.php";
        $this->proveedor = new Proveedor();
    }

    public function index() {
        $data['titulo'] = "Listado de Proveedores";
        $data['proveedores'] = $this->proveedor->listarProveedores();
        require_once "views/proveedor/index.php";
    }

    public function insert() {
        $data['titulo'] = "Registrar un Proveedor";
        require_once "views/proveedor/insert.php";
    }

    public function store() {
        $nombre = $_POST['nombre'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $email = $_POST['email'];

        $this->proveedor->insert($nombre, $telefono, $direccion, $email);

        header("Location: index.php?controlador=Proveedor&accion=index");
        exit();
    }

    public function edit($idProveedor) {
        $data['titulo'] = "Actualizar Proveedor";
        $data['proveedor'] = $this->proveedor->getProveedor($idProveedor);

        require_once "views/proveedor/edit.php";
    }

    public function update() {
        $idProveedor = $_POST['id_proveedor'];
        $nombre = $_POST['nombre'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $email = $_POST['email'];

        $this->proveedor->update($idProveedor, $nombre, $telefono, $direccion, $email);
        
        header("Location: index.php?controlador=Proveedor&accion=index");
        exit();
    }

    public function delete($idProveedor) {
        $this->proveedor->delete($idProveedor);
        header("Location: index.php?controlador=Proveedor&accion=index");
        exit();
    }
}
?>
