<?php

namespace App\Http\Middleware;

use Closure;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        $headers = apache_request_headers();
        
        if(!isset($headers['x-api-key'])){
            
            return response()->json(['error' => 'api key not found'], 400);
            
        }else{
            
            if($headers['x-api-key'] != env('API_KEY')){
                
                return response()->json(['error' => ' api key wrong'], 400);
            }
        }
        
        return $next($request);
    }
}
