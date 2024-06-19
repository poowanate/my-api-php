<?php 
if(!defined('BASEPATH')) exit('No direct script access allowed');
$part_include = str_replace("\User","",__DIR__);

require_once($part_include."/Controllers.php");
$part = str_replace("controllers\User","",__DIR__);

require_once($part."vendor/autoload.php");

use Firebase\JWT\JWT;
use Firebase\JWT\Key;




 class UserController extends Controller
 {
    private $key;
    private $db;
    private $result;

    public function __construct(){
        parent::__construct();
        $this->db =$this->connectDB();
        $this->key =$this->jwtKEY();
        $part = str_replace("\controllers\User","",__DIR__);

        require_once($part."/model/UserModel.php");

    }

    /**
 * @OA\Get(
 *     path="/PHP-API/api/v1/user", tags={"User"}, description="Select User ALL",
 *     summary="Search all user",
 *     @OA\Response(response="200", description="Success"),
 *     @OA\Response(response="400", description="Bad request"),
 *     security={{"bearerAuth": {}}}
 * )
 */

    public function getUserAll()
    {
        $header = apache_request_headers();
        $this->result = null;
        if(isset($header["Authorization"])){
            $token = str_replace('Bearer ','', $header["Authorization"]);
            try{
                 $token =JWT::decode($token, new Key($this->key, 'HS256'));
                $userModel = new UserModel($this->db);
                $this->result = $userModel->getAll();
    
            }catch(PDOException $e){
                $this->result = false;
    
            }
        }else{
            $this->result = false;
        }
        

        return $this->result;
    }
    /**
 * @OA\Get(
 *     path="/PHP-API/api/v1/user/{id}", tags={"User"}, description="Select User by id",
 *     summary="Find user by id",
 * @OA\Parameter(
     *          name="id",
     *  required=true, 
     *          in="path",
     *                
     *          @OA\Schema(
     *              type="integer"
     *          ),
     *     ),
 *     @OA\Response(response="200", description="Success"),
 *     @OA\Response(response="400", description="Bad request"),
 * security={{"bearerAuth": {}}}
 * )
 */
    public function getUserbyID()
    {
        $header = apache_request_headers();
        $this->result = null;
        if(isset($header["Authorization"])){
            $token = str_replace('Bearer ','', $header["Authorization"]);
        try{
            $userModel = new UserModel($this->db);
            $userModel->id = $this->id;
            $this->result = $userModel->getbyID();

        }catch(PDOException $e){
            $this->result = false;

        }}
        else{
            $this->result = false;
        }

        return $this->result;
    }

/**
     * @OA\Post(
     *      path="/PHP-API/api/v1/user/create", tags={"User"}, description="Select User by id",
     *      summary="Create a new user",
     *      description="Endpoint to create a new resource",
    *      @OA\RequestBody(
 *           @OA\MediaType(
 *                      mediaType="multipart/form-data",
 *                      @OA\Schema(
 *              required={"first_name", "last_name", "email","gender","phone"},
 *              @OA\Property(property="first_name", type="string"),
 *              @OA\Property(property="last_name", type="string"),
 *              @OA\Property(property="email", type="string"),
 *              @OA\Property(property="gender", type="string"),
 *              @OA\Property(property="phone", type="string"),
 *              @OA\Property(property="ip_address", type="string"),
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
 * security={{"bearerAuth": {}}}
     * )
     */
    public function insertUser()
    {
        $header = apache_request_headers();
        $this->result = null;
        if(isset($header["Authorization"])){
            $token = str_replace('Bearer ','', $header["Authorization"]);
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
    }
    else{
        $this->result=false;
    }
        return $this->result;
    }
/**
     * @OA\Post(
     *      path="/PHP-API/api/v1/user/{id}/update", tags={"User"}, 
     *      summary="Update a user by ID",
     *      description="Endpoint to update a user by ID using multipart/form-data",
     *  *      @OA\Parameter(
 *          name="id",
 *          in="path",
 *          required=true,
 *          description="ID of the user to update",
 *          @OA\Schema(
 *              type="integer",
 *              format="int64"
 *          )
 *      ),
    *      @OA\RequestBody(
 *           @OA\MediaType(
 *                      mediaType="multipart/form-data",
 *                      @OA\Schema(
 *              required={"first_name", "last_name", "email","gender","phone"},
 *              @OA\Property(property="first_name", type="string"),
 *              @OA\Property(property="last_name", type="string"),
 *              @OA\Property(property="email", type="string"),
 *              @OA\Property(property="gender", type="string"),
 *               @OA\Property(property="phone", type="string"),
 *              @OA\Property(property="ip_address", type="string"),
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
 * security={{"bearerAuth": {}}}
     * )
     */
    public function updateUser()
    {
        $header = apache_request_headers();
        $this->result = null;
        if(isset($header["Authorization"])){
            $token = str_replace('Bearer ','', $header["Authorization"]);
        try{
            $userModel = new UserModel($this->db);
            $userModel->firstname = $this->first_name;
            $userModel->lastname = $this->last_name;
            $userModel->email = $this->email;
            $userModel->gender = $this->gender;
            $userModel->phone=$this->phone;
            
            $userModel->ip_address=$this->ip_address;
            $userModel->id=$this->id;
            $stmt = $userModel->get_by_phone();
            if($stmt){
                $countRow = $stmt->rowCount();
                if($countRow == 0){
                    $this->result=$userModel->update();
                }
                else{
                    $user = array();
                    while($row =  $stmt->fetch(PDO::FETCH_ASSOC)){
                        $r = $row;
                        array_push($user,$r);
                    }
                    // print_r($user[0]); debug check
                    // exit();
                if($this->id == $user[0]["id"]){
                        $this->result=$userModel->update();
                }
                else{
                        $this->result = false;
                }
                }
                
            }else{
                $this->result = false;
            }
            

        }catch(PDOExecption $e){
            $this->result=false;
        }
    }
    else{
        $this->result=false;
    }
        return $this->result;
    }

    /**
     * @OA\Post(
     *      path="/PHP-API/api/v1/user/{id}/delete", tags={"User"}, 
     *      summary="Delete a user by ID",

     *  *      @OA\Parameter(
 *          name="id",
 *          in="path",
 *          required=true,
 *          description="ID of the user to delete",
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
 * security={{"bearerAuth": {}}}
     * )
     */
    public function deleteUser(){

        $header = apache_request_headers();
        $this->result = null;
        if(isset($header["Authorization"])){
            $token = str_replace('Bearer ','', $header["Authorization"]);
        try{
            $userModel = new UserModel($this->db);
            $userModel->id = $this->id;
            $this->result = $userModel->delete();
        }catch(PDOExecption $e){
            $this->result=false;
        }
    }
        else{
            $this->result=false;
        }
        return $this->result;
    }
}
?>