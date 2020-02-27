<?php
    class DBConnector {

        private $servername = "tharchin";
        private $port = 3307;
        private $username = "webdev";
        private $password = "opfYpOWDu4X4";
        private $dbname = "test";
        private $connection;

        function __construct() {
            $this->connect();
            $this->createDatabase();
        }

        function connect() {
            try {
                $this->connection = new PDO("mysql:host=$this->servername;port=$this->port;dbname=$this->dbname", $this->username, $this->password);
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
        
            $stmt = $this->connection->prepare("CREATE TABLE IF NOT EXISTS users(
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(64) NOT NULL,
                group_id INT
             ) ");
            $stmt->execute();
        }

        function getUser($username) {
            $stmt = $this->connection->prepare("SELECT name FROM users WHERE name = ?");
            $stmt->execute(array($username));
            return $stmt->fetch();
        }

        function getPassword($username) {
            $stmt = $this->connection->prepare("SELECT password FROM users WHERE name = ?");
            $stmt->execute(array($username));
            error_log( print_r( $stmt->fetchAll(), true ) );

            return $stmt->fetch();
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