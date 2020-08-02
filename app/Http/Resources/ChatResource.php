<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;


class ChatResource extends JsonResource
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
            'id' => $this->resource->id,
            'type' => $this->resource->type,
            'created_at' => $this->resource->created_at,
            'notification' => $this->resource->notification,
            'options' => $this->options(),
            'permissions' => $this->resource->permissions,
        ];
    }

    private function options()
    {
        $options = $this->resource->options->toArray();
        if ($options['photos']) {
            $options['photos'] = collect($options['photos'])->map(function ($photo) {
                return Storage::disk('chatProfiles')->url($photo);
            });
        }
        return $options;
    }
}
