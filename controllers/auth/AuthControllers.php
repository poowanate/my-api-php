<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
$part_include = str_replace("\auth","",__DIR__);

require_once($part_include."/Controllers.php");

$part = str_replace("controllers\auth","",__DIR__);

require_once($part."vendor/autoload.php");


use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthController extends Controller{
        private $key;
        private $db;
        private $result;

        public function __construct(){

            parent::__construct();                                      
            $this->db =$this->connectDB();
            $this->key =$this->jwtKEY();
            $part = str_replace("\controllers\auth","",__DIR__);
            require_once($part."/model/UserModel.php");
            require_once($part."/model/LoginModel.php");
        }

        /**
     * @OA\Post(
     *      path="/PHP-API/api/v1/auth/{phone}", tags={"Authorization"}, description="get Token",
     *      summary="Create a token",
     *      description="Endpoint to create a new resource",
        *  *      @OA\Parameter(
 *          name="phone",
 *          in="path",
 *          required=true,
 *          description="ID of the user to update",
 *          @OA\Schema(
 *              type="integer",
 *              format="int64"
 *          )
 *      ),
   
 *      @OA\Response(
 *          response=201,
 *          description="User created successfully",
 *      ),
 *      @OA\Response(
 *          response=400,
 *          description="Bad request",
 *      ),
 *      @OA\Response(
 *          response=500,
 *          description="Internal server error",
 *      ),
     * )
     */

        public function Auth()
        {
             $this->result = null;
        try{
            $userModel = new UserModel($this->db);
            $userModel->phone =$this->phone;
          
            $stmt = $userModel->get_by_phone();
            if($stmt){
                $countRow = $stmt->rowCount();
                if($countRow > 0){
                    $time = time();
                    $exp = $time +60 *60;
                    $payload = [
                        'iss' => 'http://localhost/PHP-API/',
                        'aud' => 'http://localhost/PHP-API/',
                        'iat' => $time,
                        'exp' => $exp
                    ];
                    $jwt = JWT::encode($payload, $this->key, 'HS256');
                    $this->result  = array(
                        'token' => $jwt,
                        'expires' => $exp
                    );
                }
                else{
                    $this->result = false;
                }
                
            }else{
                $this->result = false;
            }
         
           
           

        }catch(PDOException $e){
            $this->result = false;

        }

        return $this->result;
        }
      
        public function register()
        {
           
                $this->result =null;
                try{
                    $userModel = new UserModel($this->db);
                    $userModel->firstname = $this->first_name;
                    $userModel->lastname = $this->last_name;
                    $userModel->email = $this->email;
                    $userModel->gender = $this->gender;
                    $userModel->ip_address=$this->ip_address;
                    $userModel->phone=$this->phone;
                    $stmt = $userModel->get_by_phone();
                    if($stmt){
                        $countRow = $stmt->rowCount();
                        if($countRow == 0){
                            $this->result=$userModel->insert();
                        }
                        else{
                            $this->result = false;
                        }
                        
                    }else{
                        $this->result = false;
                    }
                 
                   
        
                }catch(PDOExecption $e){
                    $this->result=false;
                }
                return $this->result;
            
        }

             /**
     * @OA\Post(
     *      path="/PHP-API/api/v1/auth/register", tags={"Authorization"}, description="Register User",
     *      summary="Register a new user",
     *      description="Endpoint to create a new resource",
    *      @OA\RequestBody(
 *           @OA\MediaType(
 *                      mediaType="multipart/form-data",
 *                      @OA\Schema(
 *              required={"Username", "Password", "First_name","Last_name","Email"},
 *              @OA\Property(property="Username", type="string"),
 *              @OA\Property(property="Password", type="string"),
 *              @OA\Property(property="First_name", type="string"),
 *              @OA\Property(property="Last_name", type="string"),
 *              @OA\Property(property="Email", type="string"),
 *              @OA\Property(property="User_level", type="string"),
 * 
 * )  
 *          ),
 *      ),
 *      @OA\Response(
 *          response=201,
 *          description="User created successfully",
 *      ),
 *      @OA\Response(
 *          response=400,
 *          description="Bad request",
 *      ),
 *      @OA\Response(
 *          response=500,
 *          description="Internal server error",
 *      ),
     * )
     */
      
        public function register_id()
        {
           
                $this->result =null;
                try{
                    $loginModel = new LoginModel($this->db);
                    $loginModel->Username = $this->Username;
                    $loginModel->Password = $this->Password;
                    $loginModel->First_name = $this->First_name;
                    $loginModel->Last_name = $this->Last_name;
                    $loginModel->Email=$this->Email;
                    $loginModel->User_level=$this->User_level;
                    $stmt = $loginModel->get_by_user();
                    if($stmt){
                        $countRow = $stmt->rowCount();
                        if($countRow == 0){
                            $this->result=$loginModel->insert();
                        }
                        else{
                            http_response_code(200);
                            echo json_encode(
                                $arr = array(   
                                
                                    "code"=>409,
                                    "status"=>"error",
                                    "message"=>"Fail your username Duplicate  "
                                )
                                );
                                exit();
                        }
                        
                    }else{
                        $this->result = false;
                    }
                 
                   
        
                }catch(PDOExecption $e){
                    $this->result=false;
                }
                return $this->result;
            
        }

}