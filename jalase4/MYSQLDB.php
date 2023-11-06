<?php 

class MySQLDB{
    private $host;
    private $port;
    private $dbName;
    private $username;
    private $password;
    private $connection;

    public function __construct($host = "localhost", $port ="3306", 
                                $dbName ="weeklyprogram", $username = "root", $password ="") {
        $this->host = $host;
        $this->port = $port;
        $this->dbName = $dbName;
        $this->username = $username;
        $this->password = $password;
        $this->connect();
    }

    private function connect() {
        
        $dsn = "mysql:host=$this->host;port=$this->port;dbname=$this->dbName;user=$this->username;password=$this->password";
        
        try {
            $this->connection = new PDO($dsn);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch (PDOException $e) {
            echo "Connection to database failed: " . $e->getMessage();
            die();
        }
    }

    public function execute($sql) {
        try {
            $result = $this->connection->exec($sql);
            return $result;
        } catch (PDOException $e) {
            echo "Query execution failed: " . $e->getMessage();
            return false;
        }
    }

    public function select($table, $columns = "*", $where = "") {
        $sql = "SELECT $columns FROM $table ";
        
        if (!empty($where)) {
            $sql .= "WHERE $where";
        }
        
        try {
            $stmt = $this->connection->query($sql);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo "Query execution failed: " . $e->getMessage();
            return false;
        }
    }

    public function insert($table, $data) {
        $columns = implode(", ", array_keys($data));
        $values = implode(", :", array_keys($data));
        $params = ":" . implode(", :", array_keys($data));

        $sql = "INSERT INTO $table ($columns) VALUES ($values)";

        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($data);
            return true;
        } catch (PDOException $e) {
            echo "Insertion failed: " . $e->getMessage();
            return false;
        }
    }

    public function createTable($table, $columns) {
        $sql = "CREATE TABLE $table ($columns)";
        
        try {
            $this->connection->exec($sql);
            echo "Table created successfully\n";
            return true;
        } catch (PDOException $e) {
            echo "Table creation failed: " . $e->getMessage();
            return false;
        }
    }
}
