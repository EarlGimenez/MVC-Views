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

    public function addRoute($method, $path, $handler, $middleware = []) {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'handler' => $handler,
            'middleware' => $middleware
        ];
    }

    public function dispatch() {
            $match = $this->routeMatcher->match(
                $this->routes,
                $this->request->getMethod(),
                $this->request->getPath()
            );
            
            if ($match) {
                if (isset($match['middleware'])) {
                    foreach ($match['middleware'] as $middlewareClass) {
                        $middleware = new $middlewareClass();
                        $response = $middleware->handle($this->request);
                        if ($response instanceof Response) {
                            return $response; 
                        }
                    }
                }

                return call_user_func_array($match['handler'], array_values($match['params']));
            }
        
            return new Response(404, json_encode(['error' => 'Not Found']));
        }    
}