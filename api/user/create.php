<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT');
$part = str_replace("\api\user","",__DIR__);
require_once($part. "/controllers/User/Usercontroller.php");
$usercontroller = new UserController();

$params =array();

$params["first_name"] = isset($_POST["first_name"]) && !empty($_POST["first_name"]) ? $_POST["first_name"] : "";
$params["last_name"] = isset($_POST["last_name"]) && !empty($_POST["last_name"]) ? $_POST["last_name"] : "";
$params["email"] = isset($_POST["email"]) && !empty($_POST["email"]) ? $_POST["email"] : "";
$params["gender"] = isset($_POST["gender"]) && !empty($_POST["gender"]) ? $_POST["gender"] : "";
$params["ip_address"] = isset($_POST["ip_address"]) && !empty($_POST["ip_address"]) ? $_POST["ip_address"] : "";
$params["phone"] = isset($_POST["phone"]) && !empty($_POST["phone"]) ? $_POST["phone"] : "";

$data = json_encode($params);
$data = json_decode($data);
// print_r($data); check input
// exit();

$usercontroller->first_name = $data->first_name;
$usercontroller->last_name = $data->last_name;
$usercontroller->email = $data->email;
$usercontroller->gender = $data->gender;
$usercontroller->ip_address = $data->ip_address;
$usercontroller->phone = $data->phone;

if ($data ->first_name == ""){
    http_response_code(200);
    echo json_encode(
        $arr = array(   
            "response"=> array(),
            "code"=>204,
            "status"=>"error",
            "message"=>"You didn't input your firstname . Please try agian"
        )
        );
}
else if($data ->last_name == ""){
    http_response_code(200);
    echo json_encode(
        $arr = array(   
            "response"=> array(),
            "code"=>204,
            "status"=>"error",
            "message"=>"You didn't input your lastname . Please try agian"
        )
        );
}
else if($data ->phone == ""){
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
else if($data ->email == ""){
    http_response_code(200);
    echo json_encode(
        $arr = array(   
            "response"=> array(),
            "code"=>204,
            "status"=>"error",
            "message"=>"You didn't input your email . Please try again"
        )
        );
}
else if($data ->gender == ""){
    http_response_code(200);
    echo json_encode(
        $arr = array(   
            "response"=> array(),
            "code"=>204,
            "status"=>"error",
            "message"=>"You didn't input your gender . Please try again"
        )
        );
}else{
    
    if($usercontroller->insertUser()){
     
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