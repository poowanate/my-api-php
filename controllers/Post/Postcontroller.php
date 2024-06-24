<?php 
if(!defined('BASEPATH')) exit('No direct script access allowed');
$part_include = str_replace("\Post","",__DIR__);

require_once($part_include."/Controllers.php");
$part = str_replace("controllers\Post","",__DIR__);

require_once($part."vendor/autoload.php");

use Firebase\JWT\JWT;
use Firebase\JWT\Key;




 class PostController extends Controller
 {
    private $key;
    private $db;
    private $result;

    public function __construct(){
        parent::__construct();
        $this->db =$this->connectDB();
        $this->key =$this->jwtKEY();
        $part = str_replace("\controllers\Post","",__DIR__);

        require_once($part."/model/PostModel.php");

    }

    /**
 * @OA\Get(
 *     path="/PHP-API/api/v1/post", tags={"Post"}, description="Select Post ALL",
 *     summary="Search all post",
 *     @OA\Response(response="200", description="Success"),
 *     @OA\Response(response="400", description="Bad request"),

 * )
 */

    public function getAllPost()
    {
        // $header = apache_request_headers();
        $this->result = null;
       
            try{
                //  $token =JWT::decode($token, new Key($this->key, 'HS256'));
                $postModel = new PostModel($this->db);
                $this->result = $postModel->getAll();
    
            }catch(PDOException $e){
                $this->result = false;
    
            }
        
        

        return $this->result;
    }
    /**
 * @OA\Get(
 *     path="/PHP-API/api/v1/post/{uid}", tags={"Post"}, description="Select post by user_id",
 *     summary="Find post by uid",
 * @OA\Parameter(
     *          name="uid",
     *  required=true, 
     *          in="path",
     *                
     *          @OA\Schema(
     *              type="integer"
     *          ),
     *     ),
 *     @OA\Response(response="200", description="Success"),
 *     @OA\Response(response="400", description="Bad request"),

 * )
 */
    public function getPostbyuserID()
    {
     
        $header = apache_request_headers();
        $this->result = null;
       
        try{
              $postModel = new PostModel($this->db);
            $postModel->user_id = $this->user_id;
            $this->result = $postModel->getbyuserID();

        }catch(PDOException $e){
            $this->result = false;

        }
       

        return $this->result;
    }

/**
     * @OA\Post(
     *      path="/PHP-API/api/v1/post/create", tags={"Post"}, description="Create a new Post ",
     *      summary="Create a new Post",
     *      description="Endpoint to create a new resource",
    *      @OA\RequestBody(
 *           @OA\MediaType(
 *                      mediaType="multipart/form-data",
 *                      @OA\Schema(
 *              required={"user_id", "title", "body","testselect"},
 *              @OA\Property(property="user_id", type="string"),
 *              @OA\Property(property="title", type="string"),
 *              @OA\Property(property="body", type="string"),
 *              @OA\Property(property="testselect", type="string"),
 *            
 *             
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


    public function insertPost()
    {
 
    $this->result = null;
    try{
     $postModel = new PostModel($this->db);
      $postModel->user_id = $this->user_id;
      $postModel->title = $this->title;
      $postModel->body = $this->body;
      $postModel->testselect = $this->testselect;
      $this->result=$postModel->insert();

  }catch(PDOExecption $e){
      $this->result=false;
  }

         return $this->result;
    }
/**
     * @OA\Post(
     *      path="/PHP-API/api/v1/post/{id}/update", tags={"Post"}, 
     *      summary="Update a post by userID",
     *      description="Endpoint to update a post by userID using multipart/form-data",
     *  *      @OA\Parameter(
 *          name="id",
 *          in="path",
 *          required=true,
 *          description="ID of the post to update",
 *          @OA\Schema(
 *              type="integer",
 *              format="int64"
 *          )
 *      ),
    *      @OA\RequestBody(
 *           @OA\MediaType(
 *                      mediaType="multipart/form-data",
 *                      @OA\Schema(
 *             required={"user_id", "title", "body","testselect"},
 *              @OA\Property(property="user_id", type="string"),
 *              @OA\Property(property="title", type="string"),
 *              @OA\Property(property="body", type="string"),
 *              @OA\Property(property="testselect", type="string"),
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

    public function updatePost()
    {
        $header = apache_request_headers();
        $this->result = null;
       
        try{
             
              $postModel = new PostModel($this->db);
              $postModel->user_id = $this->user_id;
              $postModel->title = $this->title;
              $postModel->body = $this->body;
              $postModel->testselect = $this->testselect;
              $postModel->id=$this->id;
           
              $this->result=$postModel->update();
             
           
         
            

        }catch(PDOExecption $e){
            $this->result=false;
        }
    
    
        return $this->result;
    }

    /**
     * @OA\Post(
     *      path="/PHP-API/api/v1/post/{id}/delete", tags={"Post"}, 
     *      summary="Delete a post by ID",

     *  *      @OA\Parameter(
 *          name="id",
 *          in="path",
 *          required=true,
 *          description="ID of the Post to delete",
 *          @OA\Schema(
 *              type="integer",
 *              format="int64"
 *          )
 *      ),
 *      @OA\Response(
 *          response=201,
 *          description="Post deleted successfully",
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
    public function deletePost(){

        $header = apache_request_headers();
        $this->result = null;
        
        try{
            $postModel = new PostModel($this->db);
            $postModel->id = $this->id;
            $this->result = $postModel->delete();
        }catch(PDOExecption $e){
            $this->result=false;
        }
   
        return $this->result;
    }
}
?>