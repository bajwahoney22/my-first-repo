<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthApiController extends Controller
{
    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->validated();
        $auth = Auth::attempt($credentials);
        $status = $auth ? 200 : 401;
        if ($auth) {
            $token = Auth::user()->createToken('auth token')->accessToken; // for passport
            // $token = Auth::user()->createToken('auth token')->plainTextToken; // for sanctum
            $data = [
                'success' => true,
                'message' => 'Authentication Successful',
                'token' => $token,
                'status' => 200
            ];
        } else {
            $data = [
                'success' => false,
                'message' => 'Authentication Failed',
                'token' => null,
                'status' => 401
            ];
        }

        } catch (Exception $e) {
            $status = 500;
            $msg = $e->getMessage();
            Log::error('An error occured while logging in via API.', ['message' => $msg]);
            $data = [
                'success' => false,
                'message' => 'Something went wrong. Contact the support.',
                'token' => null,
                'status' => 500
            ];
        }

        return response()->json($data, $status);
    }
}
