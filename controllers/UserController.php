<?php

class UserController {
    private $users;
    public $ACCION_PRINCIPAL = "login"; // Define una acción por defecto

    public function __construct() {
        require_once "models/User.php";
        $this->users = new User();
    }

    public function verificarRegistro() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["fullname"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        
        if (!$this->users->register($name, $email, $password)) {
            session_start();
            $_SESSION['error'] = 'email_existente';
            header("Location: index.php?controlador=User&accion=register");
            exit();
}

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
        session_start(); // Asegurar que la sesión está activa
    
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
                $_SESSION["error"] = "Usuario o contraseña incorrecto";
                header("Location: index.php?controlador=User&accion=login");
                exit(); // Detiene la ejecución para ver si el mensaje aparece
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