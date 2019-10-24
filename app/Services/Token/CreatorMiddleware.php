<?php

namespace App\Services\Token;

use Closure;
use App\Services\Response;
use App\Models\Board;
use App\Models\LoginToken;

class CreatorMiddleware
{

    public function handle($request, Closure $next)
    {
        $token = $request->input('token');
        $boardId = $request->board;

        $user = LoginToken::where('token','=',$token)->first();
        $board = Board::find($boardId);

        if($user['user_id'] != $board['creator_id']){
            return Response::unAuthorized();
        }

        return $next($request);
    }
}
