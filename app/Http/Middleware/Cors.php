<?php
namespace App\Http\Middleware;

use Closure;

class Cors
{
    public function handle($request, Closure $next)
    {
        header("Access-Control-Allow-Origin","*");
        $headers = [
            'Access-Control-Allow-Methods' => 'OPTIONS, POST, GET , PUT, DELETE',
	    'Access-Control-Allow-Headers' => 'Content-Type, X-Auth-Token, Origin, Authorization',
	    'Content-Type' => 'application/json',
        ];
        if ($request->getMethod() == "OPTIONS") {
            return response()->json('OK', 200, $headers);
        }
        $response = $next($request);

        foreach ($headers as $key => $value) {
            $response-> header($key, $value);
        }
        return $response;
    }
}
