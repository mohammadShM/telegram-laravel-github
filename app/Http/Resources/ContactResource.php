<?php

namespace App\Http\Resources;

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
 * @property mixed user
 * @property mixed contact
 */
class ContactResource extends JsonResource
{
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
            'user_id' => $this->user_id,
            'contact_id' => $this->contact_id,
            'mobile' => $this->mobile,
            'name' => $this->name,
            //'username' => $this->user->username,
            //'last_seen' => $this->user->last_seen,
            //'profile_photos' => $this->profilePhotos(),
            'user' => $this->userResource(),
        ];
    }

    private function userResource()
    {
        return new UserResource($this->contact);
    }

}
