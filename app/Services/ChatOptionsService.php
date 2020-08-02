<?php

namespace App\Services;

use App\Chat;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/** @noinspection PhpUnused */

class ChatOptionsService
{

    public static function create(Chat $chat, array $request)
    {
        $photo = null;
        if (!empty($request['photo'])) {
            $photo = explode('/', $request['photo'])[1];
            $destination = $chat->id . '/' . $photo;
            Storage::disk('chatProfiles')->move($request['photo'], $destination);
        }
        return $chat->options()->create([
            'name' => $request['name'] ?? null,
            'description' => $request['description'] ?? null,
            'photos' => $photo ? [$photo] : null,
            'scope' => $request['scope'] ?? null,
            'link' => $request['link'] ?? null,
            'sign_messages' => $request['sign_messages'] ?? false,
            'show_chat_history' => $request['show_chat_history'] ?? false,
        ]);
    }

    public static function update(Chat $chat, array $request)
    {
        return $chat->options->update($request);
    }

    public static function uploadPhoto(UploadedFile $file, int $chatId = null)
    {
        $path = $chatId ? $chatId : 'user-' . auth()->user()->id;
        /** @var Storage $photo */
        $photo = Storage::disk('chatProfiles')->put($path, $file);
        if (!is_null($chatId)) {
            /** @var Chat $chat */
            $chat = Chat::find($chatId);
            $newPhoto = str_replace($chat->id . '/', '', $photo);
            $chat->options->photos = empty($chat->options->photos)
                ? [$newPhoto]
                : array_merge($chat->options->photos, [$newPhoto]);
            $chat->options->save();
        }
        return [
            'path' => $photo,
            'url' => $photo = Storage::disk('chatProfiles')->url($photo),
        ];
    }

    public static function deletePhoto(Chat $chat, string $photo_id): bool
    {
        // for one way in for ==============================
//        $exists = false;
//        foreach ($chat->options->photos as $photo) {
//            if (Str::startsWith($photo, $photo_id)) {
//                $exists = true;
//                break;
//            }
//        }
        // for tow way in for ==============================
//        $result = array_filter($chat->options->photos, function ($item) use ($photo_id) {
//            return Str::startsWith($item, $photo_id);
//        });
        // for three way in for ==============================
        $photos = collect($chat->options->photos);
        if ($photos->filter(function ($photo) use ($photo_id) {
            return Str::startsWith($photo, $photo_id);
        })->isEmpty()) {
            throw new ModelNotFoundException("The desired image was not found");
        }
        $chat->options->photos = $photos->filter(function ($photo) use ($photo_id, $chat) {
            if (!Str::startsWith($photo, $photo_id)) {
                return true;
            }
            Storage::disk('chatProfiles')->exists($chat->id . '/' . $photo) ?
                Storage::disk('chatProfiles')->delete($chat->id . '/' . $photo)
                : false;
            return false;
        })->values();
        $chat->options->save();
        return true;
    }

}
