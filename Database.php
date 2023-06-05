<?php
// Database.php
require_once 'db_config.php';

class Database {
    private $connection;

    public function __construct() {
        try {
            $this->connection = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_DATABASE, DB_USERNAME, DB_PASSWORD);
            // set the PDO error mode to exception
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->connection;
    }
}
?>