<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CheckUsernameRequest;
use App\Http\Requests\User\DeleteProfilePictureUserRequest;
use App\Http\Requests\User\FindByUsernameRequest;
use App\Http\Requests\User\UpdateUserMobileRequest;
use App\Http\Requests\User\UpdateUserMobileVerifyRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\UploadProfilePictureUserRequest;
use App\Http\Resources\ProfilePhotoResource;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends Controller
{
    public function update(UpdateUserRequest $request)
    {
        $user = UserService::update($request);
        return new UserResource($user);
    }

    /** @noinspection PhpUnused */
    public function updateMobile(UpdateUserMobileRequest $request)
    {
        UserService::updateMobile($request);
        return response([], 201);
    }

    /** @noinspection PhpUnused */
    public function updateMobileVerify(UpdateUserMobileVerifyRequest $request)
    {
        if (UserService::updateMobileVerify($request)) {
            return response([], 201);
        }
        return abort(Response::HTTP_BAD_REQUEST, 'code is not valid or maybe expired');
    }

    /** @noinspection PhpUnused */
    public function checkUsername(CheckUsernameRequest $request)
    {
        if (UserService::checkUsername($request)) {
            return response(null, Response::HTTP_OK);
        }
        return abort(Response::HTTP_BAD_REQUEST, 'Username already exists');
    }

    /** @noinspection PhpUnused */
    public function uploadProfilePicture(UploadProfilePictureUserRequest $request)
    {
        try {
            $url = UserService::uploadProfilePicture($request);
            return new ProfilePhotoResource($url);
        } catch (Exception $exception) {
            Log::error($exception);
            return abort(Response::HTTP_INTERNAL_SERVER_ERROR, 'Cannot upload photo');
        }
    }

    /** @noinspection PhpUnused */
    public function deleteProfilePicture(DeleteProfilePictureUserRequest $request)
    {
        try {
            if (UserService::deleteProfilePicture($request)) {
                return response(null, Response::HTTP_ACCEPTED);
            } else {
                return abort(Response::HTTP_NOT_FOUND, 'Profile picture not exists');
            }
        } catch (NotFoundHttpException $exception) {
            throw  $exception;
        } catch (Exception $exception) {
            Log::error($exception);
            return abort(Response::HTTP_INTERNAL_SERVER_ERROR, 'Cannot remove photo');
        }
    }

    /** @noinspection PhpUnused */
    public function findByUsername(FindByUsernameRequest $request)
    {
        try {
            $users = UserService::findByUsername($request);
            if (!empty($users)) {
                return response(UserResource::collection($users), Response::HTTP_OK);
            }
        } catch (Exception $exception) {
            Log::error($exception);
        }
        return response([], Response::HTTP_OK);
    }

}
