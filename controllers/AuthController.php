<?php

namespace Controllers;

use \Firebase\JWT\JWT;
use Responses\Response;
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
            $controller->redirect('/error');
        }
        
        $controller->redirect('/dashboard');
    }

    public function register() {
        $controller = new ViewController;
        $data = $_POST;

        $existingUser = $this->repository->getByUsername($data['username']);
        if (!empty($existingUser)) {
            echo "User already exists";
            exit;
        }

        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        $this->repository->create($data);

        // return new Response(201, json_encode(['message' => 'User created successfully']));
        $controller->redirect('/homepage');
    }

    private function generateJWT($userId, $username) {
        $secretKey = "the_secret_lies_in_the_sauce";
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600;

        $payload = [
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'userId' => $userId,
            'username' => $username
        ];

        return JWT::encode($payload, $secretKey, 'HS256');
    }

    public function logout() {
        header("Location: /");
        exit;
    }

}