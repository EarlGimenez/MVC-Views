<?php

namespace Routes;

class RouteMatcher {
    public function match($routes, $requestMethod, $requestPath) {
        if ($requestPath === '') {
            $requestPath = '/';
        }
        if ($requestPath !== '/' && substr($requestPath, -1) === '/') {
            $requestPath = rtrim($requestPath, '/');
        } 
        foreach ($routes as $route) {
            $routePath = $route['path'];
            if ($routePath === '' || $routePath === '/') {
                $routePath = '/';
            } else {
                $routePath = rtrim($routePath, '/');
            }
  
            $pattern = preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $routePath);
            $pattern = "@^" . $pattern . "/?$@D";
  
            // error_log("Matching request path: '$requestPath' against pattern: '$pattern'");
  
            if ($route['method'] === $requestMethod && preg_match($pattern, $requestPath, $matches)) {
                $matched = [
                    'handler' => $route['handler'],
                    'params' => array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY),
                    'middleware' => $route['middleware'] ?? [] 
                ];

                return $matched;
            }
        }
  
        return null;
    }
}
