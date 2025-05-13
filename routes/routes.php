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
    ['method' => 'GET', 'path' => '/about-us', 'handler' => function ()  use ($viewController) {
        return $viewController->about();
    }],
    ['method' => 'GET', 'path' => '/error', 'handler' => function ()  use ($viewController) {
        return $viewController->error();
    }],
    ['method' => 'GET', 'path' => '/dashboard', 'handler' => function ()  use ($viewController) {
        return $viewController->dashboard();
    }],

    // STUDENT CRUD ROUTES

    ['method' => 'GET', 'path' => '/students', 'handler' => function () use ($studentViewController) {
        // cast to int to avoid any surprises
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        return $studentViewController->index($page);
    }],

    ['method' => 'GET', 'path' => '/students/create', 'handler' => fn() => $studentViewController->create()],
    
    ['method' => 'POST', 'path' => '/students', 'handler' => fn() => $studentViewController->store()],
    
    ['method' => 'GET', 'path' => '/students/{id}', 'handler' => fn($id) => $studentViewController->show($id)],
    
    ['method' => 'GET', 'path' => '/students/{id}/edit', 'handler' => fn($id) => $studentViewController->edit($id)],
    
    ['method' => 'POST', 'path' => '/students/{id}/update', 'handler' => fn($id) => $studentViewController->update($id)],
    
    ['method' => 'POST', 'path' => '/students/{id}/delete', 'handler' => fn($id) => $studentViewController->delete($id)],


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
    ['method' => 'POST', 'path' => '/api/register', 'handler' => function () use ($userController) {
        return $userController->register();
    }],
    ['method' => 'POST', 'path' => '/api/login', 'handler' => function () use ($userController) {
        return $userController->login();
    }],
        
    // User routes deprecated by JWT Routes
    ['method' => 'GET', 'path' => '/api/users', 'handler' => function () use ($userController) {
        return $userController->getAll();
    }],
    ['method' => 'GET', 'path' => '/api/users/{id}', 'handler' => function ($id) use ($userController) {
        return $userController->getById($id);
    }],
    ['method' => 'POST', 'path' => '/api/users', 'handler' => function () use ($userController) {
        return $userController->create();
    }],
    ['method' => 'PUT', 'path' => '/api/users/{id}', 'handler' => function ($id) use ($userController) {
        return $userController->update($id);
    }],
    ['method' => 'DELETE', 'path' => '/api/users/{id}', 'handler' => function ($id) use ($userController) {
        return $userController->delete($id);
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
