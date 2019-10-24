<?php

namespace App\Http\Requests\Board;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\ApiRequest;

class BoardUpdateRequest extends FormRequest
{
    use ApiRequest;

    public function rules()
    {
        return [
            'name' => 'required'
        ];
    }
}
