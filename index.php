<?php
require_once 'init.php';

use Models\DBORM;
use Routes\Router;
use Models\Database;
use Requests\Request;
use Routes\RouteMatcher;
use Models\UserRepository;
use Models\StudentRepository;
use Controllers\AuthController;
use Controllers\UserController;
use Controllers\ViewController;
use Controllers\StudentController;

$dbname = 'php_rest';

// Initialize the database connection
$db = new Database('localhost', 'root', 'root', $dbname);

// Initialize the request object
$request = new Request();

// ------------------------------------------------------------------------------------
// Initialize the DBORM instance
$dborm = new DBORM('mysql:host=localhost;dbname='. $dbname, 'root', 'root');

// Initialize the student repository
$studentRepository = new StudentRepository($dborm);

// Initialize the student controller
$studentController = new StudentController($studentRepository, $request);
// ------------------------------------------------------------------------------------

// Initialize the user repository
$userRepository = new UserRepository($db);

// Initialize the user controller with dependencies
$controller = new UserController($userRepository, $request);

// ------------------------------------------------------------------------------------

//View Controller
$viewController = new ViewController();

//------------------------------------------------------------------------------------

// Initialize the Auth controller with dependencies
$authController = new AuthController($userRepository, $request);

//-------------------------------------------------------------------------------------
// Load routes
$routes = include __DIR__ . '/routes/routes.php';

// Initialize the router
$router = new Router($request, new RouteMatcher());

// Register routes
foreach ($routes as $route) {
    $router->addRoute($route['method'], $route['path'], $route['handler']);
}

// Dispatch the request
$response = $router->dispatch();

if (strpos($request->getPath(), '/api') === 0) {
    http_response_code($response->getStatusCode());
    header('Content-Type: application/json');
    echo $response->getBody();
}
else {
    $viewController->error();
}


