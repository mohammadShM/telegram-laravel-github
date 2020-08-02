<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed user_id
 * @property mixed blockUsers
 * @property mixed share_phone_number
 * @property mixed share_phone_number_exceptions
 * @property mixed last_seen
 * @property mixed last_seen_exceptions
 * @property mixed forward_message
 * @property mixed forward_message_exceptions
 * @property mixed profile_photo
 * @property mixed profile_photo_exceptions
 * @property mixed add_to_groups
 * @property mixed add_to_groups_exceptions
 * @property mixed created_at
 * @property mixed updated_at
 * @property mixed deleted_at
 * @method blockUsers()
 * @method SharePhoneNumberExceptionUsers()
 */
class SecurityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $array = parent::toArray($request);
        $array['blocked_users'] = $this->blockUsersRelation();
        $array['share_phone_number_exceptions'] = $this->SharePhoneNumberExceptionUsersRelation();
        return $array;
//        return [
//            "id" => $this->id,
//            "user_id" => $this->user_id,
//            "blocked_users" => $this->blockUsersRelation(),
//            "share_phone_number" => $this->share_phone_number,
//            "share_phone_number_exceptions" => $this->share_phone_number_exceptions,
//            "last_seen" => $this->last_seen,
//            "last_seen_exceptions" => $this->last_seen_exceptions,
//            "forward_message" => $this->forward_message,
//            "forward_message_exceptions" => $this->forward_message_exceptions,
//            "profile_photo" => $this->profile_photo,
//            "profile_photo_exceptions" => $this->profile_photo_exceptions,
//            "add_to_groups" => $this->add_to_groups,
//            "add_to_groups_exceptions" => $this->add_to_groups_exceptions,
//            "created_at" => $this->created_at,
//            "updated_at" => $this->updated_at,
//            "deleted_at" => $this->deleted_at,
//        ];
    }

    private function blockUsersRelation()
    {
        return UserResource::collection($this->blockUsers());
    }

    private function SharePhoneNumberExceptionUsersRelation()
    {
        return UserResource::collection($this->SharePhoneNumberExceptionUsers());
    }
}
