<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Services\Response;
use App\User;
use App\Models\LoginToken;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;

class AuthController extends Controller
{
    private $user;
    private $loginToken;

    public function __construct(User $user, LoginToken $loginToken){
        $this->user = $user;
        $this->loginToken = $loginToken;
    }

    public function register(RegisterRequest $request){

        //create user in database
        $user = $this->user->create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'username' => $request['username'],
            'password' => Hash::make($request['password'])
        ]);

        //autologin after registration
        Auth::login($user);

        //bcrypt token
        $token = bcrypt($user['id']);
        //make token in database
        $this->loginToken->create([
            'token' => $token,
            'user_id' => $user['id']
        ]);
        
        //response registration
        return Response::data([
            'token' => $token,
            'role' => 'member'
        ]);
    }

    public function login(LoginRequest $request){
        //take input from user
        $credentials = $request->only(['username','password']);

        //login authorize
        if (Auth::attempt($credentials)){
            //take data user logged
            $user = Auth::user();

            //bcrypt token user logged
            $token = bcrypt($user['id']);
            $params = [
                'token' => $token,
                'user_id' => $user['id']
            ];

            //checking loginToken
            $data = $this->loginToken->where('user_id', '=',$user['id'])->first();
            if(!is_null($data)){
                $data->update($params);
            }else{
                $this->loginToken->create($params);
            }
            
            //response login success
            return Response::data([
                'token' => $token,
                'role' => 'member'
            ]);
        }else{
            //response invalid login
            return Response::invalidLogin();
        }
    }

    public function logout(Request $request){
        //take input token from user
        $token = $request->input('token');

        //checking token
        $data = $this->loginToken->where('token', '=',$token)->first();
        
        //delete token
        if(!is_null($data)){
            $data->delete();
        }

        //response logout
        return Response::success('logout success');
    }
}
