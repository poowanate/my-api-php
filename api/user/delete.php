<?php 
if(!defined('BASEPATH')) exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT');
$part = str_replace("\api\user","",__DIR__);
require_once($part. "/controllers/User/Usercontroller.php");
$usercontroller = new UserController();

$param = array();
$param["id"] = isset($id) && !empty($id) ? $id : "" ;

$data = json_encode($param);
$data = json_decode($data);


$usercontroller->id = $data->id;


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
else{
    if($usercontroller->deleteUser()){
     
        http_response_code(200);
        echo json_encode(
            $arr = array(   
            
                "code"=>200,
                "status"=>"success",
                "message"=>"You was delete successfully "
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
                "message"=>"You wasn't delete successfully. Please try again"
            )
            );
    }
}
?>