
<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT');
$part = str_replace("\api\post","",__DIR__);
require_once($part. "/controllers/Post/Postcontroller.php");

$postcontroller = new PostController();

$params =array();

$params["user_id"] = isset($_POST["user_id"]) && !empty($_POST["user_id"]) ? $_POST["user_id"] : "";
$params["title"] = isset($_POST["title"]) && !empty($_POST["title"]) ? $_POST["title"] : "";
$params["body"] = isset($_POST["body"]) && !empty($_POST["body"]) ? $_POST["body"] : "";
$params["testselect"] = isset($_POST["testselect"]) && !empty($_POST["testselect"]) ? $_POST["testselect"] : "";
$params["id"] = isset($id) && !empty($id) ? $id : "";

$data = json_encode($params);
$data = json_decode($data);
// print_r($data); check input
// exit();

$postcontroller->user_id = $data->user_id;
$postcontroller->title = $data->title;
$postcontroller->body = $data->body;
$postcontroller->testselect = $data->testselect;

$postcontroller->id = $data->id;

if ($data ->id == ""){
    http_response_code(200);
    echo json_encode(
        $arr = array(   
            "response"=> array(),
            "code"=>204,
            "status"=>"error",
            "message"=>"not found this ID"
        )
        );
}

else if ($data ->user_id == ""){
    http_response_code(200);
    echo json_encode(
        $arr = array(   
            "response"=> array(),
            "code"=>204,
            "status"=>"error",
            "message"=>"You didn't input your user_id . Please try agian"
        )
        );
}
else if($data ->title == ""){
    http_response_code(200);
    echo json_encode(
        $arr = array(   
            "response"=> array(),
            "code"=>204,
            "status"=>"error",
            "message"=>"You didn't input your title . Please try agian"
        )
        );
}

else if($data ->body == ""){
    http_response_code(200);
    echo json_encode(
        $arr = array(   
            "response"=> array(),
            "code"=>204,
            "status"=>"error",
            "message"=>"You didn't input your body . Please try again"
        )
        );
}
else if($data ->testselect == ""){
    http_response_code(200);
    echo json_encode(
        $arr = array(   
            "response"=> array(),
            "code"=>204,
            "status"=>"error",
            "message"=>"You didn't input your testselect . Please try again"
        )
        );
}else{
    
    if($postcontroller->updatePost()){
     
        http_response_code(200);
        echo json_encode(
            $arr = array(   
            
                "code"=>200,
                "status"=>"success",
                "message"=>"You was update successfully "
            )
            );
    }
    else{
        http_response_code(200);
        echo json_encode(
            $arr = array(   
                "response"=> array(),
                "code"=>204,
                "status"=>"error",
                "message"=>"You wasn't update successfully. Please try again"
            )
            );
    }
}


?>