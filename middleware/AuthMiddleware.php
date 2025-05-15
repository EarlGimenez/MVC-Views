<?php

namespace Middleware;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Responses\Response;

class AuthMiddleware {
    private $secretKey = "the_secret_lies_in_the_sauce"; // <---------------------------- remember to replace this

    public function handle($request) {
        $headers = getallheaders();
        $token = null;
        $errors = [];
    
        // 1. Try Authorization header first
        if (isset($headers['Authorization']) && preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches)) {
            try {
                $token = $matches[1];
                $decoded = JWT::decode($token, new Key($this->secretKey, 'HS256'));
                return null; // Valid header token
            } catch (Exception $e) {
                $errors[] = "Header token error: " . $e->getMessage();
            }
        }
    
        // 2. Try token from cookie
        if (isset($_COOKIE['token'])) {
            try {
                $token = $_COOKIE['token'];
                $decoded = JWT::decode($token, new Key($this->secretKey, 'HS256'));
                return null; 
            } catch (Exception $e) {
                $errors[] = "Cookie token error: " . $e->getMessage();
            }
        }
    
        // 3. If all fail, return error(s)
        $errorMessage = !empty($errors) ? implode(' | ', $errors) : 'Authorization token is required';
        return new Response(401, json_encode(['error' => $errorMessage]));
    }
    
    
}
