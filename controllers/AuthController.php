<?php

namespace Controllers;

use Requests\RequestInterface;
use Controllers\ViewController;
use Models\DataRepositoryInterface;


class AuthController {
    protected $repository;
    protected $request;

    public function __construct(DataRepositoryInterface $repository, RequestInterface $request) {
        $this->repository = $repository;
        $this->request = $request;
    }

    public function login(){
        $controller = new ViewController;
        $data = $_POST;
        
        $user = $this->repository->getByUsername($data['username']);

        if (empty($user) || !password_verify($data['password'], $user[0]['password'])) {
            $_SESSION['invalid_login'] = "Wrong Password. Try Again!";
            $controller->redirect('/');
        }

        $_SESSION['user_id'] = $user[0]['id'];

        $controller->redirect('/dashboard');
    }

    public function register() {
        $controller = new ViewController;
        $data = $_POST;

        $existingUser = $this->repository->getByUsername($data['username']);
        if (!empty($existingUser)) {
            $_SESSION['invalid_register'] = "Username already taken. Please try again!";
            $controller->redirect('/');
        }

        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        $this->repository->create($data);

        $controller->redirect('/');
    }

    public function logout() {
        if (isset($_SESSION['user_id'])) {
            session_destroy();
        }
        header("Location: /");
        exit;
    }

}