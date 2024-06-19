<?php 

class LoginModel
{
    private $conn;
    private $table = "t_user";

    public function __construct($db)
    {
    $this->conn = $db;
   
    }

    public function insert(){

        try{
            $query = "INSERT INTO ". $this->table ."(Username, Password, First_name, Last_name, Email	, User_level) VALUES (:Username, :Password, :First_name, :Last_name, :Email, :User_level)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam('Username', $this->Username, PDO::PARAM_STR);
            $stmt->bindParam('Password',$this->Password,PDO::PARAM_STR);
            $stmt->bindParam('First_name',$this->First_name,PDO::PARAM_STR);
            $stmt->bindParam('Last_name',$this->Last_name,PDO::PARAM_STR);
            $stmt->bindParam('Email',$this->Email,PDO::PARAM_STR);
            $stmt->bindParam('User_level',$this->User_level,PDO::PARAM_STR);
           
          
            if($stmt->execute()){
                if($stmt->rowCount()){
                    return true;
                }
                return false;
            }else{
                return false;
            }


        }catch(PDOExeption $e){
            return false;
        }
    }

    public function get_by_user()   
    {
        try{
            $query = "SELECT * FROM ". $this->table ." WHERE Username = :Username limit 1";
           
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam('Username', $this->Username, PDO::PARAM_STR);
        
            if($stmt->execute()){
               
                return $stmt;
            }else{
                return false;
            }
        }
        catch(PDOExeption $e){
            return false;

        }
    }

}

    ?>