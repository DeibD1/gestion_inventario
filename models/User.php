<?php
class User {
    private $db;
    private $users;
    
    // Constructor: Conectar a la base de datos
    public function __construct() {
        $this->db = Conexion::conectar();
        $this->users = [];
    }

    // Método para registrar un usuario
    public function register($name, $email, $password) {
        $sql = "INSERT INTO users(full_name, email, password) 
        VALUES ('$name','$email','$password')";
        $this->db->query($sql);
    }

    // Método para iniciar sesión
    public function login($email, $password) {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
    
        if ($user && $user['password'] === $password) { 
            return $user; // Usuario autenticado
        }
        
        return false; // Usuario no encontrado o contraseña incorrecta
    }
    
}

?>
