<?php

namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait ApiValidationTrait
{
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        // Customize the error response format
        $response = response()->json([
            'success' => false,
            'status' => 422,
            'message' => 'Validation failed.',
            'errors' => $errors->messages()
        ], 422);

        throw new HttpResponseException($response);
    }
}
