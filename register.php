<?php
class Database {
    private $host = "localhost";
    private $db_name = "oop_php_lab";
    private $username = "root";
    private $password = " ";  
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}

    class User {
    private $conn;
    private $table_name = "users";

    public $name;
    public $email;
    public $password;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Validate input data
    public function validateData() {
        if (empty($this->name) || empty($this->email) || empty($this->password)) {
            return false;
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;
    }

    // Register user
    public function register() {
        if (!$this->validateData()) {
            return "Invalid input!";
        }

        $hashed_password = password_hash($this->password, PASSWORD_BCRYPT);

        $query = "INSERT INTO " . $this->table_name . " (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $hashed_password);

        if ($stmt->execute()) {
            return "User successfully registered!";
        } else {
            return "Error registering user.";
        }
    }

    
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
}

?>
   