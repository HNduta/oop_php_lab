<?php
class User {
    private $conn;
    private $table_name = "users";

    public $id;;
    public $name;
    public $email;
    public $password;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (firstname, lastname, email, password) VALUES (:firstname, :lastname, :email, :password)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':firstname', $this->firstname);
        $stmt->bindParam(':lastname', $this->lastname);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', password_hash($this->password, PASSWORD_BCRYPT));

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    public function readByEmail() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':email', $this->email);
        
        $stmt->execute();
        return $stmt;
    }
    
    public function verifyEmail() {
        $query = "UPDATE " . $this->table_name . " SET is_verified = 1 WHERE verification_token = :verification_token";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':verification_token', $this->verification_token);
        
        return $stmt->execute();
    }
    
}
