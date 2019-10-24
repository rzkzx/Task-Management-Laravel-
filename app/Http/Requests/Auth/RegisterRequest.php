<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\ApiRequest;

class RegisterRequest extends FormRequest
{
    use ApiRequest;

    public function rules()
    {
        return [
            'first_name' => ['required','string','min:2','max:20'],
            'last_name' => ['required','string','min:2','max:20'],
            'username' => ['required','unique:users','alpha_num','min:5','max:12'],
            'password' => ['required','min:5','max:12']
        ];
    }
}
