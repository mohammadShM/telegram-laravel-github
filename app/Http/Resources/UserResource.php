<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * @property mixed id
 * @property mixed name
 * @property mixed username
 * @property mixed mobile
 * @property mixed bio
 * @property mixed last_seen
 */
class UserResource extends JsonResource
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
            'name' => $this->name,
            'username' => $this->username,
            'mobile' => $this->mobile(),
            'bio' => $this->bio,
            'last_seen' => $this->lastSeen(),
            'profile_photos' => $this->profilePhotos(),
        ];
    }

    private function profilePhotos()
    {
        if (auth()->user()->can('viewProfilePhoto', $this->resource)) {
            return collect(Storage::disk('profiles')->files($this->id))->map(function ($item) {
                return Storage::disk('profiles')->url($item);
            });
        }
        return [];
    }

    private function mobile()
    {
        //auth()->user()->can('view-mobile', $this->resource);
        return auth()->user()->can('viewMobile', $this->resource)
            ? $this->resource->mobile
            : null;
    }

    private function lastSeen()
    {
        return auth()->user()->can('viewLastSeen', $this->resource)
            ? $this->resource->last_seen
            : null;
    }

}
