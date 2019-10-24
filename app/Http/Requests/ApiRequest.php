<?php

namespace App\Http\Requests;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Services\Response;

trait ApiRequest
{
    public function authorize()
    {
        return true;
    }

    protected function failedValidation(Validator $validator) {
		throw new HttpResponseException(Response::validationError());
	}
}
