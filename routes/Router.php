<?php

namespace Routes;

use Responses\Response;
use Middleware\AuthMiddleware;
use Requests\RequestInterface;

class Router {
    private $request;
    private $routeMatcher;
    private $routes = [];

    public function __construct(RequestInterface $request, RouteMatcher $routeMatcher) {
        $this->request = $request;
        $this->routeMatcher = $routeMatcher;
    }

    public function addRoute($method, $path, $handler) {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'handler' => $handler
        ];
    }

    // JWT implementations -----------------------------------------------------------------------------------------------------------------------------------
    public function dispatch() {
        $match = $this->routeMatcher->match(
            $this->routes,
            $this->request->getMethod(),
            $this->request->getPath()
        );
    
        if ($match) {
            $path = $this->request->getPath();
            
            // Explicit public API routes
            $publicApiRoutes = ['/api/login', '/api/register'];
    
            // If the path starts with /api but is not in the public list, require auth
            if (str_starts_with($path, '/api') && !in_array($path, $publicApiRoutes)) {
                $authMiddleware = new AuthMiddleware();
                $authResponse = $authMiddleware->handle($this->request);
                if ($authResponse instanceof Response) {
                    return $authResponse;
                }
            }
    
            // Proceed normally for public API or non-API routes
            return call_user_func_array($match['handler'], array_values($match['params']));
        }
    
        return new Response(404, json_encode(['error' => 'Not Found']));
    }
    
}