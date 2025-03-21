<?php
class User {
    private $db;
    private $users;
    
    // Constructor: Conectar a la base de datos
    public function __construct() {
        $this->db = Conexion::conectar();
        $this->users = [];
    }

    public function register($name, $email, $password) {
        // Verificar si el correo ya existe
        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
    
        if ($stmt->num_rows > 0) {
            $stmt->close();
            return false; 
        }
    
        $stmt->close();
    
        // Insertar el nuevo usuario (⚠️ Contraseña sin encriptar)
        $sql = "INSERT INTO users(full_name, email, password) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $password);
        
        $result = $stmt->execute();
        $stmt->close();
        
        return $result;
    }
    

    public function login($email, $password) {
        $sql = "SELECT id, full_name, email, password FROM users WHERE email = ?";
        $stmt = $this->db->prepare($sql);
    
        if (!$stmt) {
            die("Error en prepare: " . $this->db->error);
        }
    
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();
    
        if (!$resultado) {
            die("Error en get_result: " . $this->db->error);
        }
    
        if ($resultado->num_rows === 1) {
            $user = $resultado->fetch_assoc();
            $stored_password = $user["password"];  // ⚠️ Contraseña en texto plano

            // Comparar contraseñas directamente (sin `password_verify()`)
            if ($password === $stored_password) {
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION["id"] = $user["id"];
                $_SESSION["fullname"] = $user["full_name"];
                return true;
            } else {
                return false; // ❌ Contraseña incorrecta
            }
        } else {
            return false; // ❌ Usuario no encontrado
        }
    }
}
?>
