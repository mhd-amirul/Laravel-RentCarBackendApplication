<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseFormatter;
use App\Models\userAgreement as ModelsUserAgreement;
use Closure;
use Illuminate\Http\Request;

class userAgreement
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
        // $userAgreement = ModelsUserAgreement::where("user", "exists", ["email" => auth()->user()->email])->first();
        $userAgreement = ModelsUserAgreement::where("user_id", auth()->user()->_id)->first();
        if ($userAgreement != null) {
            return $next($request);
        }
        return ResponseFormatter::error(null, "please agree our condition and term first", 403);
    }
}
