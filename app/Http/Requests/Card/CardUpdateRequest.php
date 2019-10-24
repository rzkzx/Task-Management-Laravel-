<?php

namespace App\Http\Requests\Card;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\ApiRequest;

class CardUpdateRequest extends FormRequest
{
    use ApiRequest;

    public function rules()
    {
        return [
            'task' => 'required'
        ];
    }
}
