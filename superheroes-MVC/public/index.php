<?php

require('../vendor/autoload.php');
require('../bootstrap.php');

use App\Controllers\SuperheroesController;
use App\Controllers\CiudadanosController;
use App\Controllers\AuthController;
use App\Core\Router;

session_start();
if (!isset($_SESSION['perfil'])) {
    $_SESSION['perfil'] = 'invitado';
}

function clearData($data)
{
    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = stripslashes($data);

    return $data;
}

$router = new Router();

//HOME

$router->add(array(
    'name' => 'home',
    'path' => '/^\/$/',
    'action' => [SuperheroesController::class, 'homeAction']
));

//SUPERHEROES
if ($_SESSION['perfil'] == 'superheroeExperto') {
    $router->add(array(
        'name' => 'edit',
        'path' => '/^\/edit\/[0-9]+$/',
        'action' => [SuperheroesController::class, 'editAction']
    ));

    $router->add(array(
        'name' => 'add',
        'path' => '/^\/add$/',
        'action' => [SuperheroesController::class, 'addAction']
    ));

    $router->add(array(
        'name' => 'delete',
        'path' => '/^\/delete\/[0-9]+$/',
        'action' => [SuperheroesController::class, 'deleteAction']
    ));
}

if ($_SESSION['perfil'] == 'superheroeExperto' || $_SESSION['perfil'] == 'superheroe') {
    $router->add(array(
        'name' => 'newHabilidad',
        'path' => '/^\/newHabilidad$/',
        'action' => [SuperheroesController::class, 'newHabilidadAction']
    ));
    $router->add(array(
        'name' => 'peticiones',
        'path' => '/^\/peticiones$/',
        'action' => [SuperheroesController::class, 'showPeticionesAction']
    ));
    $router->add(array(
        'name' => 'realizarPeticion',
        'path' => '/^\/realizarPeticion\/[0-9]+$/',
        'action' => [SuperheroesController::class, 'realizarPeticionAction']
    ));
}

//AuthController
if ($_SESSION['perfil'] == 'invitado') {
    $router->add(array(
        'name' => 'login',
        'path' => '/^\/login$/',
        'action' => [AuthController::class, 'loginAction']
    ));
    $router->add(array(
        'name' => 'signup',
        'path' => '/^\/signup$/',
        'action' => [AuthController::class, 'signupAction']
    ));
}

if ($_SESSION['perfil'] != 'invitado') {
    $router->add(array(
        'name' => 'logout',
        'path' => '/^\/logout$/',
        'action' => [AuthController::class, 'logoutAction']
    ));
}

//PETICIONES
if ($_SESSION['perfil'] == 'ciudadano') {
    $router->add(array(
        'name' => 'peticion',
        'path' => '/^\/peticion\/[0-9]+$/',
        'action' => [CiudadanosController::class, 'peticionAction']
    ));
}



$request = $_SERVER['REQUEST_URI'];
$route = $router->matcher($_SERVER['REQUEST_URI']);
include("../Views/nav.php");

if ($route) {
    $controllerName = $route['action'][0];
    $actionName = $route['action'][1];
    $controller = new $controllerName;
    $controller->$actionName($request);
} else {
    include("../Views/error_view.php");
}
echo ("</body></html>");
