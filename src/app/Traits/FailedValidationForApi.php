<?php

namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait FailedValidationForApi
{
    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'message' => 'Validation Failed',
            'errors' => $validator->errors()->messages(),
        ], 422);

        throw new HttpResponseException($response);
    }
}