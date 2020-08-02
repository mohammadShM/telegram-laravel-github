<?php

namespace App\Policies;

use App\Chat;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChatPolicy
{
    use HandlesAuthorization;

    /** @noinspection PhpUnused */
    public function uploadPhoto(User $user, Chat $chat)
    {
        return $chat->isMyCreator($user) // for admin
            || $chat->participantHasPermissions($user, 'change_info');
    }

    /** @noinspection PhpUnused */
    public function show(User $user, Chat $chat)
    {
        return $chat->isThisUserMyAdmin($user)
            || $chat->isThisUserMyParticipant($user);
    }

    /** @noinspection PhpUnused */
    public function update(User $user, Chat $chat)
    {
        return $chat->isMyCreator($user) // for admin
            || $chat->participantHasPermissions($user, 'change_info');
    }

    /** @noinspection PhpUnused */
    public function deletePhoto(User $user, Chat $chat)
    {
        return $chat->isMyCreator($user) // for admin
            || $chat->participantHasPermissions($user, 'change_info');
    }

    /** @noinspection PhpUnused */
    public function addParticipant(User $user, Chat $chat, $users = null)
    {
        //-------------------------------------------------step 5-------------------------------------------------//
        if (!$chat->participantHasPermissions($user, 'add_member')) return false;
        //-------------------------------------------------step 1-------------------------------------------------//
        if (!is_array($users)) abort(400, 'Users data is invalid');
        //-------------------------------------------------step 2-------------------------------------------------//
        if ($chat->isPrivate() && count($users) !== 1)
            abort(400, 'only one user is accepted for private chats');
        //-------------------------------------------------step 3-------------------------------------------------//
        $userIds = collect($users)->filter(function ($item) {
            return is_string($item) || is_integer($item);
        })->toArray();
        /** @noinspection PhpUndefinedMethodInspection */
        $allUsersIdsAreOk = count($userIds) === count($users)
            && User::whereIn('id', $users)->count() === count($users);
        if (!$allUsersIdsAreOk) abort(400, 'Users data is invalid');
        //-------------------------------------------------step 4-------------------------------------------------//
        $hasDuplicated = $chat->participants()
                ->whereIn('user_id', $users)
                ->count() > 0;
        if ($hasDuplicated) abort(400, 'Duplicated users');
        //-------------------------------------------------step 6-------------------------------------------------//
        // TODO:check if any user does not blocked me
        return true;
    }

    /** @noinspection PhpUnused */
    public function removeParticipant(User $user, Chat $chat, User $participant)
    {
        //-------------------------------------------------step 4-------------------------------------------------//
        if (!$chat->isThisUserMyAdmin($user))
            abort(400, 'You are not the administrator of this chat');
        //-------------------------------------------------step 1-------------------------------------------------//
        if (!$chat->isThisUserMyAdmin($user))
            abort(400, 'You are not the administrator of this chat');
        //-------------------------------------------------step 2-------------------------------------------------//
        if ($chat->isMyCreator($participant))
            abort(400, 'You do not have the right to delete the admin of this chat');
        //-------------------------------------------------step 3-------------------------------------------------//
        if (!$chat->isThisUserMyParticipant($participant))
            abort(400, 'The user is not available');
        return true;
    }

    /** @noinspection PhpUnused */
    public function promoteToAdminParticipant(User $user, Chat $chat, User $participant)
    {
        //-------------------------------------------------step 4-------------------------------------------------//
        if (!$chat->isThisUserMyAdmin($user))
            abort(400, 'You are not the administrator of this chat');
        //-------------------------------------------------step 1-------------------------------------------------//
        if ($chat->isThisUserMyAdmin($participant))
            abort(400, 'This user has already been the channel admin');
        //-------------------------------------------------step 2-------------------------------------------------//
        if (!$chat->isThisUserMyParticipant($participant)) abort(400, 'The user is not available');
        //-------------------------------------------------step 3-------------------------------------------------//
        if ($chat->isThisUserMyAdmin($participant))
            abort(400, 'This user has already been the channel admin');
        return true;
    }


    /** @noinspection PhpUnused */
    public function updateChatPermissions(User $user, Chat $chat)
    {
        if (!$chat->isGroup()) {
            return false; // if chat type is channel and private chat return false
            // only can change group permission
        }
        return $chat->isMyCreator($user)
            || $chat->participantHasPermissions($user, 'change_info');
        // check if current admin has can update chat permissions
    }

    /** @noinspection PhpUnused */
    public function updateChatPermissionsForParticipant(User $user, Chat $chat, User $chatUser)
    {
        /** @var Chat $participant */
        if (!$chat->isGroup()) {
            return false; // if chat type is channel and private chat return false
            // only can change group permission
        }
        if ($chat->isMyCreator($chatUser)) {
            return abort(400, 'You do not have the right to change access the admin of this chat');
            // for admin not change permissions
            // it's the chat creator and can not update it's permissions
        }
        return $chat->isMyCreator($user)
            || $chat->isThisUserMyAdmin($user);
        // check if current admin has can update chat permissions
    }

    /** @noinspection PhpUnused */
    public function viewChatParticipantPermissions(User $user, Chat $chat, User $chatUser)
    {
        /** @var Chat $participant */
        if (!$chat->isGroup()) {
            return false; // if chat type is view and private chat return false
            // only can view group permission
        }
        return $chat->isThisUserMyParticipant($chatUser)
            && $chat->isThisUserMyAdmin($user);
    }

    /** @noinspection PhpUnused */
    public function listChatParticipant(User $user, Chat $chat)
    {
        if ($chat->isChannel()) {
            return $chat->isMyCreator($user);
            // can view group list and only can view list member in chanel for admin
        }
        return $chat->isThisUserMyParticipant($user);
    }

}
