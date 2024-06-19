<?php 

if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @OA\Info(title="My First API", version="0.1")
  * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     description ="ENTER TOKEN",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT")
 */

class Controller
{
    private $db;
    private $key;

    public function __construct()
    {
        $part = str_replace("controllers","",__DIR__);
        require_once($part."vendor/autoload.php");
        

        $dotenv = Dotenv\Dotenv::createImmutable($part);
        $dotenv->load();

   
        require_once($part."config/database.php");

         $database = new Database($_ENV["HOST"],$_ENV["DATABASENAME"],$_ENV["USERNAME"],$_ENV["PASSWORD"],$_ENV["PORT"]);

         $this->db=$database->connection();
         $this->key=$_ENV["JWTKEY"];
    }
public function connectDB(){
    return $this->db;
}
public function jwtKEY(){
    return $this->key;
}


}




?>