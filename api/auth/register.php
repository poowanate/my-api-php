<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT');
$part = str_replace("\api\auth","",__DIR__);
require_once($part. "/controllers/auth/AuthControllers.php");
$authcontroller = new AuthController();

$params =array();



$params["Username"] = isset($_POST["Username"]) && !empty($_POST["Username"]) ? $_POST["Username"] : "";
$params["Password"] = isset($_POST["Password"]) && !empty($_POST["Password"]) ? $_POST["Password"] : "";
$params["First_name"] = isset($_POST["First_name"]) && !empty($_POST["First_name"]) ? $_POST["First_name"] : "";
$params["Last_name"] = isset($_POST["Last_name"]) && !empty($_POST["Last_name"]) ? $_POST["Last_name"] : "";
$params["Email"] = isset($_POST["Email"]) && !empty($_POST["Email"]) ? $_POST["Email"] : "";
$params["User_level"] = isset($_POST["User_level"]) && !empty($_POST["User_level"]) ? $_POST["User_level"] : "";

$data = json_encode($params);
$data = json_decode($data);
// print_r($data); check input
// exit();

$authcontroller->first_name = $data->first_name;
$authcontroller->last_name = $data->last_name;
$authcontroller->email = $data->email;
$authcontroller->gender = $data->gender;
$authcontroller->ip_address = $data->ip_address;
$authcontroller->phone = $data->phone;

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
    
    if($authcontroller->register()){
     
        http_response_code(200);
        echo json_encode(
            $arr = array(   
            
                "code"=>200,
                "status"=>"success",
                "message"=>"You was register successfully "
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
                "message"=>"You wasn't register successfully. Please try again"
            )
            );
    }
}


?>