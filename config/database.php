<?php // Mahimo kita hin database connetion class

class Database
{
    //since local pamanla
    private $host = "localhost";
    private $dbName = "ecommerce_db";
    private $dbUsername = "root";
    private $dbPassword = "";

    public function __construct()
    {
        //check if running on docker or locally
        if (getenv('APP_ENV') === 'docker') 
        {
            $this->host = "db"; 
            $this->dbUsername = "admin";
            $this->dbPassword = "1010";
        } 
        else 
        {
            $this->host = "localhost"; 
            $this->dbUsername = "root";
            $this->dbPassword = "";
        }
    }

    //this functions returns an object 
    protected function connect()
    {
        try
        {
            $pdo = new PDO("mysql:host=". $this->host . ";dbname=" . $this->dbName, $this->dbUsername, $this->dbPassword);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $pdo;
        }
        catch(PDOException $e)
        {
            die("Connection Failed!". $e->getMessage());
        }
    }


}