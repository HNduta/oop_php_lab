<?php 
// Define the Database class to handle database connections.
class Database {

    // Define private properties for database connection details.
    private $host = "localhost";       // The hostname of the database server (usually localhost for local development).
    private $db_name = "oop_php_lab";  // The name of the database.
    private $username = "root";        // The database username (default is 'root' in local development).
    private $password = " ";           // The database password (empty by default for XAMPP/MAMP, but it should be filled).
    
    // Public property to hold the database connection.
    public $conn;

    // Method to establish a connection to the database using PDO (PHP Data Objects).
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
