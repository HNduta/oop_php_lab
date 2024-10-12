<?php 
// Define the Database class to handle database connections.
class Database {


    private $host = "localhost";       
    private $db_name = "oop_php_lab";  
    private $username = "root";        
    private $password = " ";           
    
    // Public property to hold the database connection.
    public $conn;

    // Method to establish a connection to the database using PDO 
    public function getConnection() {
        // Initialize the connection variable as null.
        $this->conn = null;

        // Try to establish a connection to the MySQL database using the provided credentials.
        try {
            // Create a new PDO connection string using the host, database name, username, and password.
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            // Set the PDO error mode to Exception to handle errors properly.
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } 
        // Catch any PDO exception (e.g., failed connection) and display an error message.
        catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        // Return the connection object (either the established connection or null if failed).
        return $this->conn;
    }
}
?>
