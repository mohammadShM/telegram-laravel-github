<?php

namespace App\Services;

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
use App\Security;
use App\User;

class SecurityService
{
    public static function get(GetSecuritySettingRequest $request)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return Security::where('user_id', $request->user()->id)->first();
    }

    public static function blockUser(User $user)
    {
        $authUser = auth()->user();
        $blockedUserIds = $authUser->security->blocked_users;
        if (empty($blockedUserIds)) {
            $blockedUserIds = [$user->id];
        } else if (!in_array($user->id, $blockedUserIds)) {
            $blockedUserIds[] = $user->id;
        }
        $authUser->security->blocked_users = $blockedUserIds;
        $authUser->security->save();
        return true;
    }

    public static function unblockUser(User $user)
    {
        $authUser = auth()->user();
        $blockedUserIds = $authUser->security->blocked_users;
        if (!empty($blockedUserIds)) {
            $index = array_search($user->id, $blockedUserIds);
            unset($blockedUserIds[$index]);
            $authUser->security->blocked_users = array_values($blockedUserIds) ?: null;
            $authUser->security->save();
        }
        return true;
    }

    public static function updateSharePhoneNumber(UpdateSharePhoneNumberRequest $request)
    {
        $authUser = auth()->user();
        if ($authUser->security->share_phone_number !== $request->value) {
            $authUser->security->share_phone_number_exceptions = null;
        }
        $authUser->security->share_phone_number = $request->value;
        $authUser->security->save();
        return true;
    }

    public static function updateSharePhoneNumberExceptions(UpdateSharePhoneNumberExceptionsRequest $request)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        Security::where('user_id', $request->user()->id)->update([
            'share_phone_number_exceptions' => $request->users ?: null,
        ]);
        return true;
    }

    public static function updateLastSeen(UpdateLastSeenRequest $request)
    {
        $authUser = auth()->user();
        if ($authUser->security->last_seen !== $request->value) {
            $authUser->security->last_seen_exceptions = null;
        }
        $authUser->security->last_seen = $request->value;
        $authUser->security->save();
        return true;
    }

    public static function updateLastSeenExceptions(UpdateLastSeenExceptionRequest $request)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        Security::where('user_id', $request->user()->id)->update([
            'last_seen_exceptions' => $request->users ?: null,
        ]);
        return true;
    }

    public static function updateForwardMessage(UpdateForwardMessageRequest $request)
    {
        $authUser = auth()->user();
        if ($authUser->security->forward_message !== $request->value) {
            $authUser->security->forward_message_exceptions = null;
        }
        $authUser->security->forward_message = $request->value;
        $authUser->security->save();
        return true;
    }

    public static function updateForwardMessageExceptions(UpdateForwardMessageExceptionRequest $request)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        Security::where('user_id', $request->user()->id)->update([
            'forward_message_exceptions' => $request->users ?: null,
        ]);
        return true;
    }

    public static function updateProfilePhoto(UpdateProfilePhotoRequest $request)
    {
        $authUser = auth()->user();
        if ($authUser->security->profile_photo !== $request->value) {
            $authUser->security->profile_photo_exceptions = null;
        }
        $authUser->security->profile_photo = $request->value;
        $authUser->security->save();
        return true;
    }

    public static function updateProfilePhotoExceptions(UpdateProfilePhotoExceptionRequest $request)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        Security::where('user_id', $request->user()->id)->update([
            'profile_photo_exceptions' => $request->users ?: null,
        ]);
        return true;
    }

    public static function updateAddToGroups(UpdateAddToGroupsRequest $request)
    {
        $authUser = auth()->user();
        if ($authUser->security->add_to_groups !== $request->value) {
            $authUser->security->add_to_groups_exceptions = null;
        }
        $authUser->security->add_to_groups = $request->value;
        $authUser->security->save();
        return true;
    }

    public static function updateAddToGroupsExceptions(UpdateAddToGroupsExceptionRequest $request)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        Security::where('user_id', $request->user()->id)->update([
            'add_to_groups_exceptions' => $request->users ?: null,
        ]);
        return true;
    }

}
