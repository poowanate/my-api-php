
<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
// header('Access-Control-Allow-Origin:*');
// header('Access-Control-Allow-Headers', '*');

// header('Content-Type: application/json; charset=utf-8');
// header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT');

if (isset($_SERVER['HTTP_ORIGIN'])) {
    // You can decide which origin you want to allow
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400'); // Cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        // May also be using PUT, PATCH, HEAD etc
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}

$part = str_replace("\api\post","",__DIR__);
require_once($part. "/controllers/Post/Postcontroller.php");

$postcontroller = new PostController();
$params =array();




$params["user_id"] = isset($_POST["user_id"]) && !empty($_POST["user_id"]) ? $_POST["user_id"] : "";
$params["title"] = isset($_POST["title"]) && !empty($_POST["title"]) ? $_POST["title"] : "";
$params["body"] = isset($_POST["body"]) && !empty($_POST["body"]) ? $_POST["body"] : "";
$params["testselect"] = isset($_POST["testselect"]) && !empty($_POST["testselect"]) ? $_POST["testselect"] : "";


$data = json_encode($params);
$data = json_decode($data);
// print_r($data); check input
// exit();

$postcontroller->user_id = $data->user_id;
$postcontroller->title = $data->title;
$postcontroller->body = $data->body;
$postcontroller->testselect = $data->testselect;


if ($data ->user_id == ""){
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
    
    if($postcontroller->insertPost()){
     
        http_response_code(200);
        echo json_encode(
            $arr = array(   
            
                "code"=>200,
                "status"=>"success",
                "message"=>"You was create successfully "
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
                "message"=>"You wasn't create successfully. Please try again"
            )
            );
    }
}


?>