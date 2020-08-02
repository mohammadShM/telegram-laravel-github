<?php

namespace App\Services;

use App\Http\Requests\User\CheckUsernameRequest;
use App\Http\Requests\User\DeleteProfilePictureUserRequest;
use App\Http\Requests\User\FindByUsernameRequest;
use App\Http\Requests\User\UpdateUserMobileRequest;
use App\Http\Requests\User\UpdateUserMobileVerifyRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\UploadProfilePictureUserRequest;
use App\Jobs\SendSmsJob;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserService
{
    public static function update(UpdateUserRequest $request)
    {
        $data = $request->validated();
        /** @var User $user */
        $user = $request->user();
        $user->update($data);
        return $user;
    }

    public static function updateMobile(UpdateUserMobileRequest $request)
    {
        $mobile = $request->mobile;
        /** @var User $user */
        $user = $request->user();
        /** @noinspection PhpUnhandledExceptionInspection */
        $code = random_int(1000, 9999);
        $expirationTime = now()->addMinutes(env('CHANGE_MOBILE_CODE_EXPIRATION_DURATION_IN_MINUTES', 1));
        Cache::put('user-mobile-change-verification-code-' . $user->id,
            compact('code', 'mobile'), $expirationTime);
        Log::info('old mobile : ' . $user->mobile . ' new  mobile :  ' . $mobile .
            ' your telegram verify code for change mobile number : ' . $code);
        SendSmsJob::dispatch($mobile, 'your telegram verify code for change mobile number : ' . $code);
        return $code;
    }

    public static function updateMobileVerify(UpdateUserMobileVerifyRequest $request)
    {
        /** @var User $user */
        $user = $request->user();
        $data = Cache::pull('user-mobile-change-verification-code-' . $user->id);
        if (!empty($data) && (string)$request->code === (string)$data['code']) {
            $user->mobile = $data['mobile'];
            $user->code = $data['code'];
            $user->save();
            return true;
        }
        return false;
    }

    public static function uploadProfilePicture(UploadProfilePictureUserRequest $request)
    {
        $file = $request->file('file');
        /** @var Storage $uploadedFile */
        $uploadedFile = Storage::disk('profiles')->put($request->user()->id, $file);
        return Storage::disk('profiles')->url($uploadedFile);
    }

    public static function deleteProfilePicture(DeleteProfilePictureUserRequest $request)
    {
        $fileName = $request->user()->id . '/' . $request->name;
        if (Storage::disk('profiles')->exists($fileName)) {
            Storage::disk('profiles')->delete($fileName);
            return true;
        }
        return false;
    }

    public static function checkUsername(CheckUsernameRequest $request)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return User::where(['username' => $request->username])
                ->where('id', '!=', $request->user()->id)->count() === 0;
    }

    public static function findByUsername(FindByUsernameRequest $request)
    {
        // if (!H::isValidUsername($request->username)) return null;
        /** @noinspection PhpUndefinedMethodInspection */
        /** @var Collection $users */
        $users = User::where('username', 'like', "%" . $request->username . "%")
            ->orWhere('name', 'like', "%" . $request->username . "%")
            ->take(5)->get();
        return $users->isEmpty() ? null : $users;
    }

}
