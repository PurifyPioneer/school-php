<?php
    class DBConnector {

        private $servername = "localhost";
        private $username = "xampp";
        private $password = "ppmax";
        private $connection;

//        function __construct() {
//        
//        }

        function connect() {
            try {
                $this->connection = new PDO("mysql:host=$this->servername;dbname=test", $this->username, $this->password);
               // set the PDO error mode to exception
               $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                  
              }
             catch(PDOException $e) {
                 echo "Connection failed: " . $e->getMessage();
             }
        }

        function close() {
            $this->connection = null;
        }

        function createDatabase() {
            $stmt = $this->connection->prepare("CREATE TABLE IF NOT EXISTS items(
                                    id INT AUTO_INCREMENT PRIMARY KEY,
                                    name VARCHAR(64) NOT NULL
                                 ) ");
            $stmt->execute();
        }

        function insertItem($name) {
            $stmt = $this->connection->prepare("INSERT INTO items (name) VALUES (?)");
            $stmt->execute(array($name));
        }

        function deleteItem($id) {
            $stmt = $this->connection->prepare("DELETE FROM items WHERE id = ?");
            $stmt->execute(array($id));
        }

        function getItems() {
            $stmt = $this->connection->prepare("SELECT * FROM items");
            $stmt->execute();
            return $stmt->fetchAll();
        }

        function __destruct() {
            $this->connection = null;
        }
    }
?>