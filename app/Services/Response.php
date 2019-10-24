<?php

namespace App\Services;

class Response
{
    public static function validationError(){
        return response()->json([
            'message' => 'invalid field'
        ], 422);
    }

    public static function data($data){
        return response()->json($data, 200);
    }

    public static function success($message){
        return response()->json([
            'message' => $message
        ],200);
    }

    public static function invalidLogin(){
        return response()->json([
            'message' => 'invalid login'
        ], 401);
    }

    public static function unAuthorized(){
        return response()->json([
            'message' => 'unauthorized user'
        ], 401);
    } 

    public static function fail($message){
        return response()->json([
            'message' => $message
        ],422);
    }
}

?>