<?php

namespace App\Http\Middleware;

use Closure;

class CrossOver
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
        $header = [
            'Access-Control-Allow-Origin' =>'*',
            'Access-Control-Allow-Headers'=> 'Origin, token, Content-Type, Cookie, Accept, multipart/form-data, application/json',
            'Access-Control-Allow-Methods'=>'GET, POST, DELETE, PATCH, PUT, OPTIONS',
            'Access-Control-Allow-Credentials', 'true'
        ];

        if($request->isMethod('options')){
            return response(200, '')->withHeaders($headers);
        }


        $response =  $next($request);

        return $response->withHeaders($header);
    }
}
