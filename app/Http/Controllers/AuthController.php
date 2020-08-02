<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\GenerateCodeRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\PersonalAccessTokenResult;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        try {
            /** @var PersonalAccessTokenResult $token */
            $token = AuthService::login($request);
            /** @noinspection PhpUndefinedFieldInspection */
            return response([
                'token' => $token->accessToken,
                'token_type' => 'Bearer',
                'expire_at' => $token->token->expires_at->toDateTimeString(),
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            Log::info('Login failed ', ['mobile' => $request->mobile]);
            return abort(Response::HTTP_UNAUTHORIZED,'The identity was not verified');
        }
    }

    /** @noinspection PhpUnused */
    public function generateCode(GenerateCodeRequest $request)
    {
        try {
            AuthService::generateCode($request);
            return response(null, Response::HTTP_CREATED);
        } catch (Exception $exception) {
            Log::error($exception);
            return abort(Response::HTTP_INTERNAL_SERVER_ERROR, 'Can not generate code');
        }
    }

}
