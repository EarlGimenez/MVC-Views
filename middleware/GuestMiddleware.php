<?php

namespace Middleware;

use Responses\Response;

class GuestMiddleware {
    public function handle($request) {
        if (isset($_SESSION['user_id'])) {
            return new Response(302, '', ['Location' => '/dashboard']);
        }
        return null; 
    }
}
