<?php

namespace Routes;

use Middleware\AuthMiddleware;
use Middleware\GuestMiddleware;
use Middleware\WebAuthMiddleware;

return [

    // PUBLIC ROUTES
    [
        'method' => 'GET', 
        'path' => '/', 
        'handler' => function () use ($viewController) { return $viewController->homepage(); },
        'middleware' => [GuestMiddleware::class]

    ],
    [
        'method' => 'GET', 
        'path' => '/services', 
        'handler' => function ()  use ($viewController) { return $viewController->services(); },
        'middleware' => [GuestMiddleware::class]
    ],
    [
        'method' => 'GET', 
        'path' => '/about-us', 
        'handler' => function ()  use ($viewController) { return $viewController->about(); },
        'middleware' => [GuestMiddleware::class]
    ],
    [
        'method' => 'GET', 
        'path' => '/error', 
        'handler' => function ()  use ($viewController) { return $viewController->error(); },
        'middleware' => [GuestMiddleware::class]
    ],
    [
        'method' => 'POST', 
        'path' => '/register', 
        'handler' => function () use ($authController) { return $authController->register(); },
        'middleware' => [GuestMiddleware::class]
    ],
    [
        'method' => 'POST', 
        'path' => '/login', 
        'handler' => function () use ($authController) { return $authController->login(); }, 
        'middleware' => [GuestMiddleware::class]
    ],


    // PROTECTED ROUTES
    [
        'method' => 'GET', 
        'path' => '/dashboard', 
        'handler' => function ()  use ($viewController) { return $viewController->dashboard(); },
        'middleware' => [WebAuthMiddleware::class]
    ],

    // ---------------- STUDENT CRUD ROUTES
    [
        'method' => 'GET', 
        'path' => '/students', 
        'handler' => function () use ($studentViewController) { 
            $page = isset($_GET['page']) ? (int) $_GET['page'] : 1; 
            return $studentViewController->index($page); 
        },
        'middleware' => [WebAuthMiddleware::class]],
    [
        'method' => 'GET', 
        'path' => '/students/create', 
        'handler' => fn() => $studentViewController->create(),
        'middleware' => [WebAuthMiddleware::class]
    ],
    [
        'method' => 'POST', 
        'path' => '/students', 
        'handler' => fn() => $studentViewController->store(),
        'middleware' => [WebAuthMiddleware::class]
    ],
    [
        'method' => 'GET', 
        'path' => '/students/{id}', 
        'handler' => fn($id) => $studentViewController->show($id),
        'middleware' => [WebAuthMiddleware::class]
    ],
    [
        'method' => 'GET', 
        'path' => '/students/{id}/edit', 
        'handler' => fn($id) => $studentViewController->edit($id),
        'middleware' => [WebAuthMiddleware::class]
    ],    
    [
        'method' => 'POST', 
        'path' => '/students/{id}/update', 
        'handler' => fn($id) => $studentViewController->update($id),
        'middleware' => [WebAuthMiddleware::class]
    ],
    [
        'method' => 'POST', 
        'path' => '/students/{id}/delete', 
        'handler' => fn($id) => $studentViewController->delete($id),
        'middleware' => [WebAuthMiddleware::class]
    ],
    [
        'method' => 'POST', 
        'path' => '/logout', 
        'handler' => function () use ($authController) { return $authController->logout(); },
        'middleware' => [WebAuthMiddleware::class]
    ],


    // JWT Routes
    [
        'method' => 'POST', 
        'path' => '/api/register', 
        'handler' => function () use ($userController) { return $userController->register(); },
        'middleware' => []
    ],
    [
        'method' => 'POST', 
        'path' => '/api/login', 
        'handler' => function () use ($userController) { return $userController->login(); },
        'middleware' => []
    ],
        
    // // User routes deprecated by JWT Routes
    // ['method' => 'GET', 'path' => '/api/users', 'handler' => function () use ($userController) {
    //     return $userController->getAll();
    // }],
    // ['method' => 'GET', 'path' => '/api/users/{id}', 'handler' => function ($id) use ($userController) {
    //     return $userController->getById($id);
    // }],
    // ['method' => 'POST', 'path' => '/api/users', 'handler' => function () use ($userController) {
    //     return $userController->create();
    // }],
    // ['method' => 'PUT', 'path' => '/api/users/{id}', 'handler' => function ($id) use ($userController) {
    //     return $userController->update($id);
    // }],
    // ['method' => 'DELETE', 'path' => '/api/users/{id}', 'handler' => function ($id) use ($userController) {
    //     return $userController->delete($id);
    // }],

    // Student routes
    [
        'method' => 'GET', 
        'path' => '/api/students', 
        'handler' => function () use ($studentController) { return $studentController->getAll(); },
        'middleware' => [AuthMiddleware::class]
    ],
    [
        'method' => 'GET', 
        'path' => '/api/students/{id}', 
        'handler' => function ($id) use ($studentController) { return $studentController->getById($id); },
        'middleware' => [AuthMiddleware::class]
    ],
    [
        'method' => 'POST', 
        'path' => '/api/students', 
        'handler' => function () use ($studentController) { return $studentController->create(); },
        'middleware' => [AuthMiddleware::class]
    ],
    [
        'method' => 'PUT', 
        'path' => '/api/students/{id}', 
        'handler' => function ($id) use ($studentController) { return $studentController->update($id); },
        'middleware' => [AuthMiddleware::class]
    ],
    [
        'method' => 'DELETE', 
        'path' => '/api/students/{id}', 
        'handler' => function ($id) use ($studentController) { return $studentController->delete($id); },
        'middleware' => [AuthMiddleware::class]
    ],
];
