<?php

namespace Controllers;
use \Firebase\JWT\JWT;
use Responses\Response;
use Models\UserRepository;
use Controllers\ApiController;
use Requests\RequestInterface;

class UserController extends ApiController {
    public function __construct(UserRepository $userRepository, RequestInterface $request) {
        parent::__construct($userRepository, $request);
    }

    public function getAll(): Response {
        return new Response(200, json_encode($this->repository->getAll()));
    }

    public function getById($id): Response {
        $user = $this->repository->getById($id);
        if (empty($user)) {
            return new Response(404, json_encode(['error' => 'User not found']));
        }
        return new Response(200, json_encode($user[0]));
    }

    public function create(): Response {
        $data = $this->request->getBody();
        $this->repository->create($data);
        return new Response(201, json_encode(['message' => 'User created']));
    }

    public function update($id): Response {
        $data = $this->request->getBody();
        $this->repository->update($id, $data);
        return new Response(200, json_encode(['message' => 'User updated']));
    }

    public function delete($id): Response {
        $this->repository->delete($id);
        return new Response(204, '');
    }

    // JWT AUTH METHODS ---------------------------------------------------------------------
    public function register(): Response {
        $data = $this->request->getBody();

        $existingUser = $this->repository->getByUsername($data['username']);
        if (!empty($existingUser)) {
            return new Response(400, json_encode(['error' => 'Username already exists']));
        }

        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        $this->repository->create($data);

        return new Response(201, json_encode(['message' => 'User created successfully']));
    }

    public function login(): Response {
        $data = $this->request->getBody();

        $user = $this->repository->getByUsername($data['username']);
        if (empty($user) || !password_verify($data['password'], $user[0]['password'])) {
            return new Response(401, json_encode(['error' => 'Invalid username or password']));
        }

        $token = $this->generateJWT($user[0]['id'], $user[0]['username']);

        return new Response(200, json_encode(['token' => $token]));
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
}