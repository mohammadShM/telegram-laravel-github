<?php

namespace App\Services;

use App\Events\GenerateCodeToLogin;
use App\H;
use App\Http\Requests\Auth\GenerateCodeRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Passport\PersonalAccessTokenResult;
use Laravel\Passport\Token;

class AuthService
{
    public static function login(LoginRequest $request): PersonalAccessTokenResult
    {
        $mobile = H::toMobile($request->mobile);
        /** @var User $user */
        /** @noinspection PhpUndefinedMethodInspection */
        $user = User::where(['mobile' => $mobile, 'code' => $request->code])->first();
        if (!$user) {
            Throw new ModelNotFoundException('User not found');
        }
        $tokenResponse = $user->createToken('Personal token');
        /** @var Token $token */
        $token = $tokenResponse->token;
        $expirationDays = env('AUTH_TOKEN_EXPIRATION_DAYS', 365);
        /** @noinspection PhpUndefinedFieldInspection */
        $token->expires_at = Carbon::now()->addDays($expirationDays);
        $token->save();
        return $tokenResponse;
    }

    public static function generateCode(GenerateCodeRequest $request)
    {
        $mobile = H::toMobile($request->mobile);
        /** @noinspection PhpUnhandledExceptionInspection */
        $code = random_int(1000, 9999);
        $expirationTime = now()->addMinutes(env('LOGIN_CODE_EXPIRATION_DURATION_IN_MINUTES', 30));
        /** @var User $user */
        /** @noinspection PhpUndefinedMethodInspection */
        if ($user = User::where(['mobile' => $mobile])->first()) {
            $user->code = $code;
            $user->code_expiration = $expirationTime;
            $user->save();
        } else {
            $user = User::create([
                'mobile' => $mobile,
                'name' => $mobile,
                'code' => $code,
                'code_expiration' => $expirationTime,
            ]);
            $user->security()->create();
        }
        event(new GenerateCodeToLogin($user));
        return $user;
    }
}
