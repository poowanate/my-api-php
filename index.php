<?php
 define("BASEPATH",true);
use AltoRouter as Router;
require_once 'vendor/autoload.php';
$router = new Router();
$router->setBasePath('/PHP-API');

$router->map("GET", "/", function () {
    require_once(__DIR__.'/view/landing.php');
});

$router->map("POST", "/api/v1/auth", function () {
    require_once(__DIR__.'/api/auth/auth.php');
});
$router->map("POST", "/api/v1/auth/register", function () {
    require_once(__DIR__.'/api/auth/register.php');
});
$router->map("GET", "/api/v1/user", function () {
    require_once(__DIR__.'/api/user/getAll.php');
});
$router->map("GET", "/api/documentation", function () {
    require_once(__DIR__.'/documentation/index.php');
});
$router->map("POST", "/api/v1/user/create", function () {
    require_once(__DIR__.'/api/user/create.php');
});
$router->map("POST", "/api/v1/user/[i:id]/update", function ($id) {
    require_once(__DIR__.'/api/user/update.php');
});
$router->map("POST", "/api/v1/user/[i:id]/delete", function ($id) {
    require_once(__DIR__.'/api/user/delete.php');
});
$router->map("GET", "/api/v1/user/[i:id]", function ($id) {
    require_once(__DIR__.'/api/user/get_by_id.php');
});


$router->map("GET", "/api/v1/post", function () {
    require_once(__DIR__.'/api/post/getAll.php');
});
$router->map("GET", "/api/v1/post/[i:uid]", function ($uid) {
    require_once(__DIR__.'/api/post/get_by_uid.php');
});
$router->map("POST", "/api/v1/post/create", function () {
    require_once(__DIR__.'/api/post/create.php');
});
$router->map("POST", "/api/v1/post/[i:id]/update", function ($id) {
    require_once(__DIR__.'/api/post/update.php');
});
$router->map("POST", "/api/v1/post/[i:id]/delete", function ($id) {
    require_once(__DIR__.'/api/post/delete.php');
});

$match = $router->match();
if( is_array($match) && is_callable( $match['target'] ) ) {
call_user_func_array( $match['target'], $match['params'] );
} else {
     header("HTTP/1.0 404 Not Found");
     require '404.html';
}