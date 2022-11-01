<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseFormatter;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return ResponseFormatter::error(null, "please verify your email address", 403);
            // return route('login');
        }
    }
}
