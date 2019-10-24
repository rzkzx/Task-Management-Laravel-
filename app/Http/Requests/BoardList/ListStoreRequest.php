<?php

namespace App\Http\Requests\BoardList;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\ApiRequest;

class ListStoreRequest extends FormRequest
{
    use ApiRequest;

    public function rules()
    {
        return [
            'name' => 'required'
        ];
    }
}
