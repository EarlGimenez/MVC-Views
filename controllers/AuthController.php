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

    public function login() {
        $controller = new ViewController;
        $data = $_POST;

        if ($data === null) {
            $_SESSION['message'] = 'No data received.';
            $_SESSION['message_type'] = 'error';
            $controller->redirect('/');
            exit();
        }
        
        $user = $this->repository->getByUsername($data['username']);

        if (empty($user) || !password_verify($data['password'], $user[0]['password'])) {
            $_SESSION['message'] = "Wrong Password. Try Again!";
            $_SESSION['message_type'] = 'error';
            $controller->redirect('/');
            return;
        }

        $_SESSION['user_id'] = $user[0]['id'];

        $controller->redirect('/dashboard');
    }

    public function register() {
        $controller = new ViewController;
        $data = $_POST;
        if ($data === null) {
            $_SESSION['message'] = 'No data received.';
            $_SESSION['message_type'] = 'error';
            $controller->redirect('/');
            exit();
        }

        if($data['confirmpassword']!==$data['password'] || empty($data['confirmpassword']) || empty($data['password'])) {
            $_SESSION['message'] = "Passwords do not match. Please try again!";
            $_SESSION['message_type'] = 'error';
            $controller->redirect('/');
            return;
        }

        $existingUser = $this->repository->getByUsername($data['username']);
        if (!empty($existingUser)) {
            $_SESSION['message'] = "Username already taken. Please try again!";
            $_SESSION['message_type'] = 'error';
            $controller->redirect('/');
            return;
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