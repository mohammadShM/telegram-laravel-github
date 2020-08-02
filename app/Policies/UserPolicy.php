<?php

namespace App\Policies;

use App\H;
use App\Security;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /** @noinspection PhpUnused */
    public function block(User $user, User $blockUser)
    {
        // I just can't block myself
        return $blockUser->id !== $user->id;
    }

    /** @noinspection PhpUnused */
    public function unblock(User $user, User $unblockUser)
    {
        return $unblockUser->id !== $user->id;
    }

    /** @noinspection PhpUnused */
    public function viewMobile(User $user, User $otherUser)
    {
        return H::checkSecurityShareData($user, $otherUser, 'share_phone_number');
    }

    /** @noinspection PhpUnused */
    public function viewLastSeen(User $user, User $otherUser)
    {
        return H::checkSecurityShareData($user, $otherUser, 'last_seen');
    }

    /** @noinspection PhpUnused */
    public function viewProfilePhoto(User $user, User $otherUser)
    {
        return H::checkSecurityShareData($user, $otherUser, 'profile_photos');
    }

    /** @noinspection PhpUnused */
    public function forwardMessage(User $user, User $otherUser)
    {
        return H::checkSecurityShareData($user, $otherUser, 'forward_message');
    }

    /** @noinspection PhpUnused */
    public function addToGroups(User $user, User $otherUser)
    {
        return H::checkSecurityShareData($user, $otherUser, 'add_to_groups');
    }

}
