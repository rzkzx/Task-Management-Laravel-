<?php

namespace App\Services\Token;

use Closure;
use App\Models\LoginToken;
use App\Services\Response;

class AuthMiddleware
{
    public function handle($request, Closure $next)
    {
        $token = $request->input('token');

        $count = LoginToken::where('token','=',$token)->count();

        if($count == 0){
            return Response::unAuthorized();
        }

        return $next($request);
    }
}
