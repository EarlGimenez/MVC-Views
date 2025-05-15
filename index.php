<?php
require_once 'init.php';

session_start();

use Models\DBORM;
use Models\Database;
use Models\UserRepository;
use Models\StudentRepository;

use Requests\Request;
use Routes\Router;
use Routes\RouteMatcher;

use Controllers\AuthController;
use Controllers\UserController;
use Controllers\ViewController;
use Controllers\StudentController;
use Controllers\StudentViewController;
use Responses\Response;

// ---------------------- Configuration ----------------------

$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = 'root';
$dbName = 'php_rest';

// ---------------------- Dependencies ----------------------

// Core
$request = new Request();
$database = new Database($dbHost, $dbUser, $dbPass, $dbName);
$dborm = new DBORM("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);

// Repositories
$userRepository = new UserRepository($database);
$studentRepository = new StudentRepository($dborm);

// Controllers
$viewController = new ViewController();
$authController = new AuthController($userRepository, $request);
$userController = new UserController($userRepository, $request);
$studentController = new StudentController($studentRepository, $request);
$studentViewController = new StudentViewController($studentRepository, $viewController);


// ---------------------- Routing ----------------------

$routes = include __DIR__ . '/routes/routes.php';
$router = new Router($request, new RouteMatcher());
foreach ($routes as $route) {
    $router->addRoute($route['method'], $route['path'], $route['handler'], $route['middleware']);
}

// ---------------------- Dispatch ----------------------

$response = $router->dispatch();

if (str_starts_with($request->getPath(), '/api') && $response instanceof Response) {
    http_response_code($response->getStatusCode());
    header('Content-Type: application/json');
    echo $response->getBody();
}
else {
    $header = $response->getHeaders();
    if ($header) $viewController->redirect($header['Location']);
    else {
        http_response_code($response->getStatusCode());
        $viewController->error();
    }
}

