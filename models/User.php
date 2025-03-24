<?php
class User {
    private $db;
    
    public function __construct() {
        $this->db = Conexion::conectar();
    }

    public function register($name, $email, $hashed_password) {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->close();
            return false;
        }
        $stmt->close();

        $sql = "INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $hashed_password);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    public function login($email, $password) {
        $sql = "SELECT id, full_name, email, password FROM users WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            $stored_password = $user["password"];

            if (password_verify($password, $stored_password)) {
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION["id"] = $user["id"];
                $_SESSION["fullname"] = $user["full_name"];
                return true;
            }
        }

        return false;
    }
}
?>
