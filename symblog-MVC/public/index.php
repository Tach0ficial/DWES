<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../bootstrap.php';
require_once '../vendor/autoload.php';

use Dotenv\Dotenv;
use Aura\Router\RouterContainer;
use Laminas\Diactoros;
use Laminas\Diactoros\Response\RedirectResponse;
use Illuminate\Database\Capsule\Manager as Capsule;

$dotenv = Dotenv::createImmutable(__DIR__, "../.env");
$dotenv->load();

$capsule = new Capsule;
$capsule->addConnection([
    'driver' => 'mysql',
    'host' => $_ENV['DB_HOST'],
    'database' => $_ENV['DB_NAME'],
    'username' => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASS'],
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => ''
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

$request = \Laminas\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

$routerContainer = new RouterContainer();
$map = $routerContainer->getMap();
$map->get('home', '/', [
    'controller' => 'App\Controllers\IndexController',
    'action' => 'homeAction'
]);

$map->get('about', '/about', [
    'controller' => 'App\Controllers\PagesController',
    'action' => 'aboutAction'
]);


$map->get('contact', '/contact', [
    'controller' => 'App\Controllers\PagesController',
    'action' => 'contactAction'
]);

$map->post('contactSend', '/contact', [
    'controller' => 'App\Controllers\PagesController',
    'action' => 'contactActionSend'
]);

$map->get('showBlog', '/blog/{id}', [
    'controller' => 'App\Controllers\BlogController',
    'action' => 'showAction'
])->tokens(['id' => '\d+']);

$map->get(
    "addUser",
    "/addUser",
    ['controller' => 'App\Controllers\AddUserController', 'action' => 'addAction', 'auth' => true]
);
$map->post(
    "AddUserSave",
    "/addUser",
    ['controller' => 'App\Controllers\AddUserController', 'action' => 'addAction', 'auth' => true]
);

$map->get(
    "login",
    "/login",
    ['controller' => 'App\Controllers\AuthController', 'action' => 'getLogin']
);
$map->post(
    "postlogin",
    "/login",
    ['controller' => 'App\Controllers\AuthController', 'action' => 'postLogin', 'auth' => true]
);
$map->get(
    "admin",
    "/admin",
    ['controller' => 'App\Controllers\AdminController', 'action' => 'getIndex', 'auth' => true]
);



$matcher = $routerContainer->getMatcher();
$route = $matcher->match($request);

if (!$route) {
    echo 'No route';
} else {
    //Aprovachmos la posibilidad que nos da php de crear clases con el nombre almacenado en una variable
    $handlerData = $route->handler;
    $controllerName = $handlerData['controller'];
    $actionName = $handlerData['action'];

    $needsAuth = $handlerData['auth'] ?? false;
    $sessionUserId = $_SESSION['userId'] ?? null;
    if ($needsAuth && !$sessionUserId) {
        header('Location: /login');
    } else {
        $controller = new $controllerName;
        $response = $controller->$actionName($request);
        foreach ($response->getHeaders() as $name => $values) {
            foreach ($values as $value) {
                header(sprintf('%s: %s', $name, $value), false);
            }
        }
        http_response_code($response->getStatusCode());
        echo $response->getBody();
    }
}
