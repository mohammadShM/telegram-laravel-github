<?php

namespace App\Http\Resources;

use App\Chat;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed name
 * @property mixed username
 * @property mixed mobile
 * @property mixed bio
 * @property mixed contact_id
 * @property mixed user_id
 * @property mixed contact
 * @property mixed chat_id
 * @property mixed admin
 * @property mixed permissions
 * @property mixed created_at
 * @property mixed user
 */
class ChatParticipantResource extends JsonResource
{
    /**
     * @var boolean
     */
    private static $isAdmin;

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'chat_id' => $this->chat_id,
            'user_id' => $this->user_id,
            'permissions' => $this->permissions(),
            'admin' => $this->admin,
            'created_at' => $this->created_at,
            'user' => $this->userResource(),
        ];
    }

    public function userResource()
    {
        return new UserResource($this->user);
    }

    private function permissions()
    {
        return static::$isAdmin ? $this->permissions : null;
    }

    public static function collectionForUserAndChat($resource, User $user, Chat $chat)
    {
        static::$isAdmin = $chat->isThisUserMyAdmin($user);
        return static::collection($resource);
    }

}
