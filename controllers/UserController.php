<?php

class UserController {
    private $users;
    public $ACCION_PRINCIPAL = "login"; // Define una acción por defecto

    public function __construct() {
        require_once "models/User.php";
        $this->users = new User();
    }

    // Verificar registro
    public function verificarRegistro() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST["fullname"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $this->users->register($name, $email, $password);        
            header("Location: index.php?controlador=User&accion=login");
            exit();
        }
    }

    // Cargar la vista de registro
    public function register() {
        require_once "views/users/registration.php";
    }

    // Cargar la vista de login
    public function login() {
        require_once "views/users/login.php";
    }

    // Verificar login
    public function verificarLogin() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST["email"];
            $password = $_POST["password"];

            $user = $this->users->login($email, $password);

            if ($user) {
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["user_name"] = $user["full_name"];
                header("Location: index.php?controlador=proveedor&accion=index");
                exit();
            } else {
                header("Location: index.php?controlador=User&accion=login");
            }
        }
    }
    

    // Cerrar sesión
    public function logout() {
        session_destroy();
        header("Location: index.php?controlador=User&accion=login");
        exit();
    }
}

?>