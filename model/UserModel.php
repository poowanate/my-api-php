<?php 

class UserModel
{
    private $conn;
    private $table = "user";

    public function __construct($db)
    {
    $this->conn = $db;
   
    }

    public function getAll(){
  
        try{
            $query = "SELECT * FROM ". $this->table ." ORDER BY id asc";
            $stmt = $this->conn->prepare($query);
            
            $stmt-> execute();
            
            return $stmt;
            
        }
        catch(PDOExeption $e)
        {
            return false;
        }
    }
    public function getbyID(){
        try{
            $query = "SELECT * FROM ". $this->table ." WHERE id = :id ORDER BY id asc";
           
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam('id', $this->id, PDO::PARAM_STR);
        
            if($stmt->execute()){
               
                return $stmt;
            }else{
                return false;
            }
            
        }
        catch(PDOExeption $e)
        {
            return false;
        }
    }

    public function insert(){

        try{
            $query = "INSERT INTO ". $this->table ."(firstname, lastname, email, gender, ip_address, phone) VALUES (:firstname, :lastname, :email, :gender, :ip_address, :phone)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam('firstname', $this->firstname, PDO::PARAM_STR);
            $stmt->bindParam('lastname',$this->lastname,PDO::PARAM_STR);
            $stmt->bindParam('email',$this->email,PDO::PARAM_STR);
            $stmt->bindParam('gender',$this->gender,PDO::PARAM_STR);
            $stmt->bindParam('ip_address',$this->ip_address,PDO::PARAM_STR);
            $stmt->bindParam('phone',$this->phone,PDO::PARAM_STR);
           
          
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

    public function update()
    {
        try{
            $query ="UPDATE ".$this->table ." SET firstname= :firstname, lastname= :lastname , email= :email , gender= :gender , phone= :phone , ip_address= :ip_address WHERE id = :id";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam('firstname', $this->firstname, PDO::PARAM_STR);
            $stmt->bindParam('lastname',$this->lastname,PDO::PARAM_STR);
            $stmt->bindParam('email',$this->email,PDO::PARAM_STR);
            $stmt->bindParam('gender',$this->gender,PDO::PARAM_STR);
            $stmt->bindParam('ip_address',$this->ip_address,PDO::PARAM_STR);
            $stmt->bindParam('phone',$this->phone,PDO::PARAM_STR);
            $stmt->bindParam('id',$this->id,PDO::PARAM_STR);

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

    public function delete()
    {
        try{
        $query = "DELETE FROM ".$this->table ." WHERE id= :id";
       
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('id',$this->id,PDO::PARAM_STR);
      
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
    // เช็คเบอร์ซ้ำ
    public function get_by_phone()
    {
        try{
            $query = "SELECT * FROM ". $this->table ." WHERE phone = :phone limit 1";
           
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam('phone', $this->phone, PDO::PARAM_STR);
        
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