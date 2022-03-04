<?php

require "../bootstrap.php";

use App\Controllers\AuthController;
use App\Core\Router;
use App\Controllers\ContactosController;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$requestMethod = $_SERVER["REQUEST_METHOD"];

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $request);

$userId = null;
if (isset($uri[2])) {
    $userId = (int) $uri[2];
}

if ($request == '/contactos/login') {
    $auth = new AuthController($requestMethod);

    if (!$auth->loginFromRequest()) {
        exit(http_response_code(401));
    };
}

$input = (array) json_decode(file_get_contents('php://input'), TRUE);

if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
    $autHeader =  $_SERVER['HTTP_AUTHORIZATION'];
    $arr = explode(" ", $autHeader);
    $jwt = $arr[1];

    if ($jwt) {
        try {
            $decoded = (JWT::decode($jwt, new Key(KEY, 'HS256')));
        } catch (Exception $e) {
            echo json_encode(array(
                "message" => "Access denied.",
                "error" => $e->getMessage()
            ));
            exit(http_response_code(401));
        }
    }
} else {
    echo json_encode(array("message" => "Access denied."));
    exit(http_response_code(401));
}

$router = new Router();
$router->add(array(
    'name' => 'home',
    'path' => '/^\/contactos(\/[0-9]+)?$/',
    'action' => ContactosController::class
));

$router->add(array(
    'name' => 'home',
    'path' => '/^\/contactos(\/[0-9]+)?$/',
    'action' => ContactosController::class
));

$route = $router->matchs($request);
if ($route) {
    $controllerName = $route['action'];
    $controller = new $controllerName($requestMethod, $userId);
    $response = $controller->processRequest();
    header($response['status_code_header']);
    echo $response['body'];
} else {
    echo "no ruta";
    $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
    $response['body'] = null;
    echo json_encode($response);
}
