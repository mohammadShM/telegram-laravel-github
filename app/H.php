<?php

namespace App;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


// use Kavenegar;

class H
{
    //region mobile ====================================================================================================
    public static function isMobile(?string $value): bool
    {
        return (bool)preg_match('~^(((\+|00)?98)|0)?9\d{9}$~', $value);
    }

    public static function toMobile(?string $value): ?string
    {
        return H::isMobile($value)
            ? '+98' . Str::substr($value, Str::length($value) - 10, 10)
            : null;
    }
    //endregion mobile *************************************************************************************************


    // region username =================================================================================================
    public static function isValidUsername($username)
    {
        if (is_string($username)) {
            return preg_match('~^[a-zA-Z_][a-zA-Z0-9_]{2,19}$~', $username);
        }

        return false;
    }
    // endregion username **********************************************************************************************


    // region security =================================================================================================
    public static function checkSecurityShareData(User $user, User $otherUser, string $filed)
    {
        $filedException = $filed . '_exceptions';
        if ($otherUser->security) {
            // if otherUser blocked the user
            if ($filed !== 'forward_messages' && is_array($otherUser->security->blocked_users)
                && in_array($user->id, $otherUser->security->blocked_users)) {
                return false;
            }
            if ($otherUser->security[$filed] === Security::ACCESS_LEVEL_EVERYONE) {
                return is_array($otherUser->security[$filedException])
                    ? !in_array($user->id, $otherUser->security[$filedException])
                    : true;
            } else if ($otherUser->security[$filed] === Security::ACCESS_LEVEL_NOBODY) {
                return is_array($otherUser->security[$filedException])
                    ? in_array($user->id, $otherUser->security[$filedException])
                    : false;
            } else if ($otherUser->security[$filed] === Security::ACCESS_LEVEL_CONTACTS) {
                return $otherUser->contacts()->where('contact_id', $user->id)->count() > 0
                    ? (
                    is_array($otherUser->security[$filedException])
                        ? !in_array($user->id, $otherUser->security[$filedException])
                        : true
                    )
                    : false;
            }
        }
        return false;
    }
    // endregion security **********************************************************************************************


    // region for sms ==================================================================================================
    /** @noinspection PhpUnusedParameterInspection */
    public static function sendSms(string $number, string $message)
    {
        //Kavenegar::send(config('kavenegar.sender'), $number, $message);
        //Kavenegar::send(config('kavenegar.sender'), '09194172664', $message);
        if (empty(env('SMS_DISABLE', false)) !== true) {
            Log::info(config('kavenegar.sender') . ' 09194172664 ' . $message . ' with SMS ');
        } else {
            Log::info(config('kavenegar.sender') . ' 09194172664 ' . $message . ' Without SMS');
        }
    }
    // endregion for sms ***********************************************************************************************


    // region for chat =================================================================================================
    public static function isUniqueChatLink($value, string $chatScope, Chat $skipThisChat = null)
    {
        if (is_string($value)) {
            if ($chatScope === ChatOptions::CHAT_SCOPE_PRIVATE
                && !preg_match('~^[0-9a-zA-Z]{40}$~', $value)) {
                return false;
            }
            /** @noinspection PhpUndefinedMethodInspection */
            $query = ChatOptions::where('link', $value);
            if ($skipThisChat) {
                /** @noinspection PhpUndefinedMethodInspection */
                $query->where('chat_id', '!=', $skipThisChat->id);
            }
            /** @noinspection PhpUndefinedMethodInspection */
            return preg_match('~^[0-9a-zA-Z_]{4,40}$~', $value)
                && $query->count() === 0;
        }
        return is_null($value);
    }
    // endregion for chat **********************************************************************************************

}
