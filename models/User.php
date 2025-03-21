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
    
        // Encriptar la contraseña antes de guardarla
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
        // Insertar el nuevo usuario
        $sql = "INSERT INTO users(full_name, email, password) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $hashed_password);
        
        $result = $stmt->execute();
        $stmt->close();
        
        return $result;
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
