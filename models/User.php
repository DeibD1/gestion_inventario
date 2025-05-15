<?php
class User {
    private $db;
    
    public function __construct() {
        $this->db = Conexion::conectar();
    }

    public function register($name, $email, $hashed_password, $rol) {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->close();
            return false;
        }
        $stmt->close();

        $sql = "INSERT INTO users (full_name, email, password, rol) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ssss", $name, $email, $hashed_password, $rol);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    public function login($email, $password) {
        $sql = "SELECT id, full_name, email, password, rol FROM users WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            $stored_password = $user["password"];

            if (password_verify($password, $stored_password)) {
                return $user; // Devuelve los datos completos del usuario
            }
        }

        return false;
    }
}
?>
