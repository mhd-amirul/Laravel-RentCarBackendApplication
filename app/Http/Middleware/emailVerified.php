<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseFormatter;
use Closure;
use Illuminate\Http\Request;

class emailVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->email_verified_at) {
            return $next($request);
        }
        return ResponseFormatter::error(null, "please verify your email address", 403);
        // return response()->json(
        //     [
        //         "code" => 403,
        //         "status" => "FORBIDDEN",
        //         "message" => "please verify your email address"
        //     ], 403
        // );
    }
}
