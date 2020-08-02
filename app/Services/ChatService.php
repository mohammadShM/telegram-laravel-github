<?php

namespace App\Services;

use App\Chat;
use App\Http\Requests\Chat\AddChatParticipantsRequest;
use App\Http\Requests\Chat\CreateChatRequest;
use App\Http\Requests\Chat\DeleteChatPhotoRequest;
use App\Http\Requests\Chat\ListChatParticipantRequest;
use App\Http\Requests\Chat\PromoteChatParticipantToAdminRequest;
use App\Http\Requests\Chat\RemoveChatParticipantsRequest;
use App\Http\Requests\Chat\ShowChatParticipantPermissionsRequest;
use App\Http\Requests\Chat\ShowChatRequest;
use App\Http\Requests\Chat\UpdateChatPermissionsForParticipantRequest;
use App\Http\Requests\Chat\UpdateChatPermissionsRequest;
use App\Http\Requests\Chat\UpdateChatRequest;
use App\Http\Requests\Chat\UploadChatPhotoRequest;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChatService
{

    private static $chatDefaultPermissions = [
        "send_message" => true,
        "send_media" => true,
        "add_member" => true,
        "pin_message" => true,
        "change_info" => true,
    ];

    public static function create(CreateChatRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = $request->user();
            $data = $request->only('type', 'notification');
            $data['permissions'] = static::$chatDefaultPermissions;
            $chat = $user->chats()->create($data);
            ChatParticipantsService::create($chat, $user, true, static::$chatDefaultPermissions);
            ChatOptionsService::create($chat, $request->options);
            DB::commit();
            return $chat;
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            return null;
        }
    }

    public static function show(ShowChatRequest $request)
    {
        return $request->chat;
    }

    public static function update(UpdateChatRequest $request)
    {
        try {
            DB::beginTransaction();
            $chat = $request->chat;
            if ($request->has('notification')) {
                $chat->notification = $request->notification;
                $chat->save();
            }
            $options = collect($request->options)
                ->only(['scope', 'sign_messages', 'show_chat_history', 'link', 'name', 'description',])
                ->filter(function ($item) {
                    return !is_null($item);
                })->toArray();
            ChatOptionsService::update($chat, $options);
            DB::commit();
            return $chat;
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            return null;
        }
    }

    public static function uploadPhoto(UploadChatPhotoRequest $request)
    {
        return ChatOptionsService::uploadPhoto($request->file('file'), $request->chat_id);
    }

    public static function deletePhoto(DeleteChatPhotoRequest $request)
    {
        return ChatOptionsService::deletePhoto($request->chat, $request->photo_id);
    }

    public static function addParticipants(AddChatParticipantsRequest $request)
    {
        ChatParticipantsService::createBatch($request->chat, $request->users, false,
            static::$chatDefaultPermissions);
    }

    public static function removeParticipants(RemoveChatParticipantsRequest $request)
    {
        return ChatParticipantsService::remove($request->chat, $request->user);
    }

    public static function promoteParticipantToAdmin(PromoteChatParticipantToAdminRequest $request)
    {
        return ChatParticipantsService::promoteToAdmin($request->chat, $request->user);
    }

    public static function showParticipantPermissions(ShowChatParticipantPermissionsRequest $request)
    {
        /** @var Chat $participant */
        $participant = $request->chat->participants()->where('user_id', $request->user->id)->first();
        return empty($participant) || empty($participant->permissions)
            ? $request->chat->permissions
            : $participant->permissions;
    }

    public static function updatePermissions(UpdateChatPermissionsRequest $request)
    {
        /** @var Chat $chat */
        $chat = $request->chat;
        $chat->permissions = $request->validated();
        $chat->save();
        return $chat;
    }

    public static function updatePermissionsForParticipant(UpdateChatPermissionsForParticipantRequest $request)
    {
        /** @var Chat $participant */
        $participant = $request->chat->participants()->where('user_id', $request->user->id)->first();
        $participant->permissions = $request->validated();
        $participant->save();
        return $request->chat;
    }

    public static function listParticipants(ListChatParticipantRequest $request)
    {
        /** @var Chat $participant */
        $participant = $request->chat->participants;
        return $participant;
    }

}
