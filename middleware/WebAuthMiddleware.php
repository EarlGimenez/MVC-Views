<?php

namespace Middleware;

use Responses\Response;

class WebAuthMiddleware {
    public function handle($request) {
        if (!isset($_SESSION['user_id'])) {
            return new Response(302, '', ['Location' => '/']);
        }
        return null; 
    }
}
