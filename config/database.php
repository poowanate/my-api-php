
<?php 
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Database
{
    private $host;
    private $databaseName;
    private $username;
    private $password;
    private $port;

    public $conn;

    public function __construct($host,$databaseName,$username,$password,$port){
        $this ->host = $host;
        $this->port = $port;
        $this ->databaseName = $databaseName;
        $this ->username = $username;
        $this ->password = $password;
       
    }
 
    public function connection(){
        
        $this->conn = null;
        try{
$this->conn= new PDO(
    "mysql:host=". $this->host.";
    port=".$this->port.";
    dbname=".$this->databaseName,
    $this->username,
    $this->password
    , 
    array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
      )
);
// $this->conn->exec("SET NAMES 'utf8'"); 
$this->conn->exec("set names utf8mb4");

        }catch(PDOException $e){
echo "Database could not be connection" .$e->getmessage();
        }
    
        return $this->conn;
    }
    
}

?>