<?php

    /*
    Class used to abstract database access.
    */
    class DBConnector {

        // private $servername = "tharchin";
        // private $port = 3307;
        // private $username = "webdev";
        // private $password = "opfYpOWDu4X4";
        // private $dbname = "test";
        // private $connection;

        private $servername = "localhost";
        private $port = 3306;
        private $username = "root";
        private $password = "";
        private $dbname = "logindb";
        private $connection;

        // Initialize connection to database
        function __construct() {
            $this->connect();
            $this->createDatabase();
        }

        // Connect to database using specified creentials
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

        // Create the tables if they do not exist
        function createDatabase() {
            $stmt = $this->connection->prepare("CREATE TABLE IF NOT EXISTS items(
                                    id INT AUTO_INCREMENT PRIMARY KEY,
                                    name VARCHAR(64) NOT NULL
                                 ) ");
            $stmt->execute();
        
            $stmt = $this->connection->prepare("CREATE TABLE IF NOT EXISTS users(
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(64) NOT NULL,
                password VARCHAR(64),
                group_id INT
             ) ");
            $stmt->execute();
        }

        // Add a new user to the db
        function registerUser($username, $password) {
            $stmt = $this->connection->prepare("INSERT INTO users (name, password) VALUES (?, ?)");
            $stmt->execute(array($username, sha1($password)));
        }

        // Query the database for a user
        function getUser($username) {
            $stmt = $this->connection->prepare("SELECT name FROM users WHERE name = ?");
            $stmt->execute(array($username));

            $result = $stmt->fetch();
            $result = $result[0];
            return $result;
        }

        // Get the password for a specific user
        function getPassword($username) {
            $stmt = $this->connection->prepare("SELECT password FROM users WHERE name = ?");
            $stmt->execute(array($username));
            
            $result = $stmt->fetch();
            $result = $result[0];
            $result;
            return $result;
        }


// -------------> OLD CODE FROM PREVIOUS TASK <------------------------

        // Add a new item
        function insertItem($name) {
            $stmt = $this->connection->prepare("INSERT INTO items (name) VALUES (?)");
            $stmt->execute(array($name));
        }

        // Delete an item
        function deleteItem($id) {
            $stmt = $this->connection->prepare("DELETE FROM items WHERE id = ?");
            $stmt->execute(array($id));
        }

        // Get all items stored in database
        function getItems() {
            $stmt = $this->connection->prepare("SELECT * FROM items");
            $stmt->execute();
            return $stmt->fetchAll();
        }

        // Destory db connection if  it wasnt closed
        function __destruct() {
            $this->connection = null;
        }
    }
?>