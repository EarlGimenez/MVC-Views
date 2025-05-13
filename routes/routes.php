<?php

namespace Routes;

use Controllers\ViewController;

return [
    // View Routes
    ['method' => 'GET', 'path' => '/', 'handler' => function () use ($viewController) {
        // $viewController = new ViewController();
        return $viewController->homepage();
    }],
    ['method' => 'GET', 'path' => '/services', 'handler' => function ()  use ($viewController) {
        return $viewController->services();
    }],
    ['method' => 'GET', 'path' => '/about', 'handler' => function ()  use ($viewController) {
        return $viewController->about();
    }],
    ['method' => 'GET', 'path' => '/error', 'handler' => function ()  use ($viewController) {
        return $viewController->error();
    }],
    ['method' => 'GET', 'path' => '/dashboard', 'handler' => function ()  use ($viewController) {
        return $viewController->dashboard();
    }],

    //AUTH ROUTES
    ['method' => 'POST', 'path' => '/register', 'handler' => function () use ($authController) {
        return $authController->register();
    }],
    ['method' => 'POST', 'path' => '/login', 'handler' => function () use ($authController) {
        return $authController->login();
    }],
    ['method' => 'POST', 'path' => '/logout', 'handler' => function () use ($authController) {
        return $authController->logout();
    }],

    // JWT Routes
    ['method' => 'POST', 'path' => '/api/register', 'handler' => function () use ($controller) {
        return $controller->register();
    }],
    ['method' => 'POST', 'path' => '/api/login', 'handler' => function () use ($controller) {
        return $controller->login();
    }],
        
    // User routes deprecated by JWT Routes
    ['method' => 'GET', 'path' => '/api/users', 'handler' => function () use ($controller) {
        return $controller->getAll();
    }],
    ['method' => 'GET', 'path' => '/api/users/{id}', 'handler' => function ($id) use ($controller) {
        return $controller->getById($id);
    }],
    ['method' => 'POST', 'path' => '/api/users', 'handler' => function () use ($controller) {
        return $controller->create();
    }],
    ['method' => 'PUT', 'path' => '/api/users/{id}', 'handler' => function ($id) use ($controller) {
        return $controller->update($id);
    }],
    ['method' => 'DELETE', 'path' => '/api/users/{id}', 'handler' => function ($id) use ($controller) {
        return $controller->delete($id);
    }],

    // Student routes
    ['method' => 'GET', 'path' => '/api/students', 'handler' => function () use ($studentController) {
        return $studentController->getAll();
    }],
    ['method' => 'GET', 'path' => '/api/students/{id}', 'handler' => function ($id) use ($studentController) {
        return $studentController->getById($id);
    }],
    ['method' => 'POST', 'path' => '/api/students', 'handler' => function () use ($studentController) {
        return $studentController->create();
    }],
    ['method' => 'PUT', 'path' => '/api/students/{id}', 'handler' => function ($id) use ($studentController) {
        return $studentController->update($id);
    }],
    ['method' => 'DELETE', 'path' => '/api/students/{id}', 'handler' => function ($id) use ($studentController) {
        return $studentController->delete($id);
    }],
];
