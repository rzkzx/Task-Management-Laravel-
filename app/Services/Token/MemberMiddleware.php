<?php

namespace App\Services\Token;

use Closure;
use App\Services\Response;
use App\Models\LoginToken;
use App\Models\BoardMember;

class MemberMiddleware
{
    public function handle($request, Closure $next)
    {
        $token = $request->input('token');
        $boardId = $request->board;

        $user = LoginToken::where('token','=',$token)->first();
        $member = BoardMember::where('user_id','=',$user['user_id'])->first();

        if($member['board_id'] != $boardId){
            return Response::unAuthorized();
        }

        return $next($request);
    }
}
