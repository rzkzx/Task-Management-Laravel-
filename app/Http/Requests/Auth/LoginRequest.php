<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\ApiRequest;

class LoginRequest extends FormRequest
{
    use ApiRequest;

    public function rules()
    {
        return [
            'username' => 'required',
            'password' => 'required'
        ];
    }
}
