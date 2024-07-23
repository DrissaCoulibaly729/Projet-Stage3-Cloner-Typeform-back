<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Ensure $response is a Response instance
        if (!$response instanceof Response) {
            $response = response($response);
        }

        // Handle CORS
        return $response
            ->header('Access-Control-Allow-Origin', 'https://accounts.google.com, https://clone-typeform.netlify.app, https://play.google.com, http://localhost:3000')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With, Application')
            ->header('Access-Control-Allow-Credentials', 'true');
    }
}
