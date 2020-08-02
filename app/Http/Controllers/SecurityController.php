<?php

namespace App\Http\Controllers;

use App\Http\Requests\Security\BlockUserRequest;
use App\Http\Requests\Security\GetSecuritySettingRequest;
use App\Http\Requests\Security\UpdateAddToGroupsExceptionRequest;
use App\Http\Requests\Security\UpdateAddToGroupsRequest;
use App\Http\Requests\Security\UpdateForwardMessageExceptionRequest;
use App\Http\Requests\Security\UpdateForwardMessageRequest;
use App\Http\Requests\Security\UpdateLastSeenExceptionRequest;
use App\Http\Requests\Security\UpdateLastSeenRequest;
use App\Http\Requests\Security\UpdateProfilePhotoExceptionRequest;
use App\Http\Requests\Security\UpdateProfilePhotoRequest;
use App\Http\Requests\Security\UpdateSharePhoneNumberExceptionsRequest;
use App\Http\Requests\Security\UpdateSharePhoneNumberRequest;
use App\Http\Requests\Security\UnblockUserRequest;
use App\Http\Resources\SecurityResource;
use App\Services\SecurityService;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/** @noinspection PhpUnused */

class SecurityController extends Controller
{

    /** @noinspection PhpUnused */
    public function get(GetSecuritySettingRequest $request)
    {
        try {
            $security = SecurityService::get($request);
            return response(new SecurityResource($security), Response::HTTP_OK);
        } catch (Exception $exception) {
            Log::error($exception);
        }
        return abort(Response::HTTP_INTERNAL_SERVER_ERROR, 'Can not fetch security setting');
    }

    /** @noinspection PhpUnused */
    public function blockUser(BlockUserRequest $request)
    {
        try {
            SecurityService::blockUser($request->user);
            return response(null, Response::HTTP_ACCEPTED);
        } catch (Exception $exception) {
            Log::error($exception);
        }
        return abort(Response::HTTP_INTERNAL_SERVER_ERROR, 'Can not block user');
    }

    /** @noinspection PhpUnused */
    public function unblockUser(UnblockUserRequest $request)
    {
        try {
            SecurityService::unblockUser($request->user);
            return response(null, Response::HTTP_ACCEPTED);
        } catch (Exception $exception) {
            Log::error($exception);
        }
        return abort(Response::HTTP_INTERNAL_SERVER_ERROR, 'Can not unblock user');
    }

    /** @noinspection PhpUnused */
    public function updateSharePhoneNumber(UpdateSharePhoneNumberRequest $request)
    {
        try {
            SecurityService::updateSharePhoneNumber($request);
            return response(null, Response::HTTP_ACCEPTED);
        } catch (NotFoundHttpException $exception) {
            return abort(Response::HTTP_NOT_FOUND, 'Cannot upload photo');
        } catch (Exception $exception) {
            Log::error($exception);
        }
        return abort(Response::HTTP_INTERNAL_SERVER_ERROR, 'Can not update setting');
    }

    /** @noinspection PhpUnused */
    public function updateSharePhoneNumberExceptions(UpdateSharePhoneNumberExceptionsRequest $request)
    {
        try {
            SecurityService::updateSharePhoneNumberExceptions($request);
            return response(null, Response::HTTP_ACCEPTED);
        } catch (NotFoundHttpException $exception) {
            return abort(Response::HTTP_NOT_FOUND, 'Cannot upload photo');
        } catch (Exception $exception) {
            Log::error($exception);
        }
        return abort(Response::HTTP_INTERNAL_SERVER_ERROR, 'Can not update setting');
    }

    /** @noinspection PhpUnused */
    public function updateLastSeen(UpdateLastSeenRequest $request)
    {
        try {
            SecurityService::updateLastSeen($request);
            return response(null, Response::HTTP_ACCEPTED);
        } catch (NotFoundHttpException $exception) {
            return abort(Response::HTTP_NOT_FOUND, 'Cannot upload photo');
        } catch (Exception $exception) {
            Log::error($exception);
        }
        return abort(Response::HTTP_INTERNAL_SERVER_ERROR, 'Can not update setting');
    }

    /** @noinspection PhpUnused */
    public function updateLastSeenExceptions(UpdateLastSeenExceptionRequest $request)
    {
        try {
            SecurityService::updateLastSeenExceptions($request);
            return response(null, Response::HTTP_ACCEPTED);
        } catch (NotFoundHttpException $exception) {
            return abort(Response::HTTP_NOT_FOUND, 'Cannot upload photo');
        } catch (Exception $exception) {
            Log::error($exception);
        }
        return abort(Response::HTTP_INTERNAL_SERVER_ERROR, 'Can not update setting');
    }


    /** @noinspection PhpUnused */
    public function updateForwardMessage(UpdateForwardMessageRequest $request)
    {
        try {
            SecurityService::updateForwardMessage($request);
            return response(null, Response::HTTP_ACCEPTED);
        } catch (NotFoundHttpException $exception) {
            return abort(Response::HTTP_NOT_FOUND, 'Cannot upload photo');
        } catch (Exception $exception) {
            Log::error($exception);
        }
        return abort(Response::HTTP_INTERNAL_SERVER_ERROR, 'Can not update setting');
    }

    /** @noinspection PhpUnused */
    public function updateForwardMessageExceptions(UpdateForwardMessageExceptionRequest $request)
    {
        try {
            SecurityService::updateForwardMessageExceptions($request);
            return response(null, Response::HTTP_ACCEPTED);
        } catch (NotFoundHttpException $exception) {
            return abort(Response::HTTP_NOT_FOUND, 'Cannot upload photo');
        } catch (Exception $exception) {
            Log::error($exception);
        }
        return abort(Response::HTTP_INTERNAL_SERVER_ERROR, 'Can not update setting');
    }

    /** @noinspection PhpUnused */
    public function updateProfilePhoto(UpdateProfilePhotoRequest $request)
    {
        try {
            SecurityService::updateProfilePhoto($request);
            return response(null, Response::HTTP_ACCEPTED);
        } catch (NotFoundHttpException $exception) {
            return abort(Response::HTTP_NOT_FOUND, 'Cannot upload photo');
        } catch (Exception $exception) {
            Log::error($exception);
        }
        return abort(Response::HTTP_INTERNAL_SERVER_ERROR, 'Can not update setting');
    }

    /** @noinspection PhpUnused */
    public function updateProfilePhotoExceptions(UpdateProfilePhotoExceptionRequest $request)
    {
        try {
            SecurityService::updateProfilePhotoExceptions($request);
            return response(null, Response::HTTP_ACCEPTED);
        } catch (NotFoundHttpException $exception) {
            return abort(Response::HTTP_NOT_FOUND, 'Cannot upload photo');
        } catch (Exception $exception) {
            Log::error($exception);
        }
        return abort(Response::HTTP_INTERNAL_SERVER_ERROR, 'Can not update setting');
    }

    /** @noinspection PhpUnused */
    public function updateAddToGroups(UpdateAddToGroupsRequest $request)
    {
        try {
            SecurityService::updateAddToGroups($request);
            return response(null, Response::HTTP_ACCEPTED);
        } catch (NotFoundHttpException $exception) {
            return abort(Response::HTTP_NOT_FOUND, 'Cannot upload photo');
        } catch (Exception $exception) {
            Log::error($exception);
        }
        return abort(Response::HTTP_INTERNAL_SERVER_ERROR, 'Can not update setting');
    }

    /** @noinspection PhpUnused */
    public function updateAddToGroupsExceptions(UpdateAddToGroupsExceptionRequest $request)
    {
        try {
            SecurityService::updateAddToGroupsExceptions($request);
            return response(null, Response::HTTP_ACCEPTED);
        } catch (NotFoundHttpException $exception) {
            return abort(Response::HTTP_NOT_FOUND, 'Cannot upload photo');
        } catch (Exception $exception) {
            Log::error($exception);
        }
        return abort(Response::HTTP_INTERNAL_SERVER_ERROR, 'Can not update setting');
    }

}
