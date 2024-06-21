<?php 

class PostModel
{
    private $conn;
    private $table = "posts";

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
    public function getbyuserID(){
        try{
            $query = "SELECT * FROM ". $this->table ." WHERE user_id = :user_id ORDER BY user_id asc";
           
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam('user_id', $this->user_id, PDO::PARAM_STR);
        
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
            $query = "INSERT INTO ". $this->table ."(user_id, title, body, testselect) VALUES (:user_id, :title, :body, :testselect)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam('user_id', $this->user_id);
            $stmt->bindParam('title',$this->title,PDO::PARAM_STR);
            $stmt->bindParam('body',$this->body,PDO::PARAM_STR);
            $stmt->bindParam('testselect',$this->testselect,PDO::PARAM_STR);
    
           
          
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
            $query ="UPDATE ".$this->table ." SET  title= :title , body= :body , testselect= :testselect  WHERE id = :id";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam('id', $this->id);
            $stmt->bindParam('title',$this->title,PDO::PARAM_STR);
            $stmt->bindParam('body',$this->body,PDO::PARAM_STR);
            $stmt->bindParam('testselect',$this->testselect,PDO::PARAM_STR);

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
   
  
}

?>