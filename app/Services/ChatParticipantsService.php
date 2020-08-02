<?php

namespace App\Services;

use App\Chat;
use App\ChatParticipant;
use App\User;
use Exception;

/** @noinspection PhpUnused */

class ChatParticipantsService
{

    public static function create(Chat $chat, User $user, bool $isAdmin = false, array $permissions = [])
    {
        /** @var ChatParticipant $participant */
        $participant = $chat->participants()->create([
            'user_id' => $user->id,
            'admin' => $isAdmin,
            'permissions' => empty($permissions) ? null : $permissions,
        ]);
        return $participant;
    }

    public static function createBatch(Chat $chat, array $userIds, bool $isAdmin = false, array $permissions = null)
    {
        $permissions = empty($permissions) ? null : $permissions;
        $items = collect($userIds)->map(function ($userId) use ($isAdmin, $permissions, $chat) {
            return [
                'chat_id' => $chat->id,
                'user_id' => $userId,
                'admin' => $isAdmin,
                'permissions' => json_encode($permissions),
            ];
        });
        return ChatParticipant::insert($items->toArray());
    }

    public static function remove(Chat $chat, User $participant)
    {
        try {
            $success = $chat->participants()->where('user_id', $participant->id)->forceDelete();
            return (bool)$success;

        } catch (Exception $exception) {
            return false;
        }
    }

    public static function promoteToAdmin(Chat $chat, User $participant)
    {
        try {
            $success = $chat->participants()->where('user_id', $participant->id)->update([
                'admin' => true,
            ]);
            return (bool)$success;

        } catch (Exception $exception) {
            return false;
        }
    }

}
