<?php

class UserController {
    private $users;
    public $ACCION_PRINCIPAL = "login"; 

    public function __construct() {
        require_once "models/User.php";
        $this->users = new User();
    }

    public function register() {
        require_once "views/users/registration.php";
    }
    
    public function login() {
        require_once "views/users/login.php";
    }

    public function verificarRegistro() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST["fullname"];
            $email = $_POST["email"];
            $password = password_hash($_POST["password"], PASSWORD_BCRYPT); 

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

    public function verificarLogin() {
        session_start(); 
    
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST["email"];
            $password = $_POST["password"];

            if ($this->users->login($email, $password)) {
                header("Location: index.php?controlador=proveedor&accion=index");
                exit();
            } else {
                $_SESSION["error"] = "Usuario o contraseña incorrecto";
                header("Location: index.php?controlador=User&accion=login");
                exit();
            }
        }
    }

    public function logout() {
        session_destroy();
        header("Location: index.php?controlador=User&accion=login");
        exit();
    }
}
?>
