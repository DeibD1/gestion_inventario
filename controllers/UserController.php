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

            $rol = isset($_POST["rol"]) ? $_POST["rol"] : "cliente"; 

            $roles_permitidos = ["admin", "bodega", "cajero", "cliente"];
            if (!in_array($rol, $roles_permitidos)) {
                session_start();
                $_SESSION['error'] = 'rol_invalido';
                header("Location: index.php?controlador=User&accion=register");
                exit();
            }

            if (!$this->users->register($name, $email, $password, $rol)) {
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

            $usuario = $this->users->login($email, $password);

            if ($usuario) {
                $_SESSION["id"] = $usuario["id"];
                $_SESSION["fullname"] = $usuario["full_name"];
                $_SESSION["email"] = $usuario["email"];
                $_SESSION["rol"] = $usuario["rol"];

                switch ($usuario["rol"]) {
                    case "admin":
                        header("Location: index.php?controlador=Producto&accion=index");
                        break;
                    case "bodega":
                        header("Location: index.php?controlador=Producto&accion=index");
                        break;
                    case "cajero":
                        header("Location: index.php?controlador=Venta&accion=index");
                        break;
                    default:
                        $_SESSION["error"] = "Rol no válido.";
                        header("Location: index.php?controlador=User&accion=login");
                        break;
                }

                exit();
            } else {
                $_SESSION["error"] = "Usuario o contraseña incorrecto";
                header("Location: index.php?controlador=User&accion=login");
                exit();
            }
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: index.php?controlador=User&accion=login");
        exit();
    }
}
?>
