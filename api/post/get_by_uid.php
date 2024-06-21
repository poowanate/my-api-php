
<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT');
$part = str_replace("\api\post","",__DIR__);
require_once($part. "/controllers/Post/Postcontroller.php");

$postcontroller = new PostController();

$param = array();
$param["user_id"] = isset($uid) && !empty($uid) ? $uid : "";

$data = json_encode($param);
$data = json_decode($data);

$postcontroller->user_id = $data->user_id;

$stmt = $postcontroller->getPostbyuserID();

function alertError(){
    http_response_code(400);
    echo json_encode(
        array(
            "response" => array(),
            "count" => 0,
            "code" => 400,
            "status" => "error",
            "message" => "No record found.",
        )
    );
}

if ($data ->user_id == ""){
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
else{

    if($stmt){
        $resultCount = $stmt->rowCount();
        
        if($resultCount>0){
            http_response_code(200);
            $arr = array();
            $arr["response"] = array();
            $arr["count"]= $resultCount;
            $arr["code"]= 200;
            $arr["status"]="success";
            $arr["message"]=$resultCount." records";
    
            
    
    
            while($row =  $stmt->fetch(PDO::FETCH_ASSOC)){
                $r = $row;
                array_push($arr["response"],$r);
            }
            
            echo json_encode($arr, JSON_UNESCAPED_UNICODE);
        }
        else{
            alertError();
        }
    }
    else{
        alertError();
    }
}





?>