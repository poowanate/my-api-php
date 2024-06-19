<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT');
$part = str_replace("\api\auth","",__DIR__);
require_once($part. "/controllers/auth/AuthControllers.php");
$authcontroller = new AuthController();


$params =array();


$params["phone"] = isset($_POST["phone"]) && !empty($_POST["phone"]) ? $_POST["phone"] : "";

$data = json_encode($params);
$data = json_decode($data);
// print_r($data); check input
// exit();


$authcontroller->phone = $data->phone;


 if($data ->phone == ""){
    http_response_code(200);
    echo json_encode(
        $arr = array(   
            "response"=> array(),
            "code"=>204,
            "status"=>"error",
            "message"=>"You didn't input your phone . Please try agian"
        )
        );
}
else{
    
    if(!empty($authcontroller->Auth()) && $authcontroller->Auth()){
     
        http_response_code(200);
        echo json_encode(
            $arr = array(   
                "response" => $authcontroller->Auth(),
                "code"=>200,
                "status"=>"success",
                "message"=>"You was authorization successfully "
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
                "message"=>"You wasn't authorization successfully. Please try again"
            )
            );
    }
}


?>