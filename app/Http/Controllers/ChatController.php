<?php

namespace App\Http\Controllers;

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
use App\Http\Resources\ChatParticipantResource;
use App\Http\Resources\ChatResource;
use App\Services\ChatService;
use Illuminate\Http\Response;

/** @noinspection PhpUnused */

class ChatController extends Controller
{
    /** @noinspection PhpUnused */
    public function show(ShowChatRequest $request)
    {
        $chat = ChatService::show($request);
        return response(new ChatResource($chat), 200);
    }

    public function create(CreateChatRequest $request)
    {
        $chat = ChatService::create($request);
        if ($chat) {
            return response(new ChatResource($chat), Response::HTTP_CREATED);
        }
        return response('Can not create chat', Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function update(UpdateChatRequest $request)
    {
        $chat = ChatService::update($request);
        return response(new ChatResource($chat), Response::HTTP_ACCEPTED);
    }

    /** @noinspection PhpUnused */
    public function uploadPhoto(UploadChatPhotoRequest $request)
    {
        $result = ChatService::uploadPhoto($request);
        return response(compact('result'), 200);
    }

    /** @noinspection PhpUnused */
    public function deletePhoto(DeleteChatPhotoRequest $request)
    {
        ChatService::deletePhoto($request);
        return response(null, Response::HTTP_ACCEPTED);
    }

    /** @noinspection PhpUnused */
    public function addParticipants(AddChatParticipantsRequest $request)
    {
        ChatService::addParticipants($request);
        return response(null, Response::HTTP_CREATED);
    }

    /** @noinspection PhpUnused */
    public function removeParticipants(RemoveChatParticipantsRequest $request)
    {
        if (ChatService::removeParticipants($request)) {
            return response(null, Response::HTTP_ACCEPTED);
        } else {
            return response(['message' => 'The operation failed, please try again'],
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /** @noinspection PhpUnused */
    public function promoteParticipantToAdmin(PromoteChatParticipantToAdminRequest $request)
    {
        if (ChatService::promoteParticipantToAdmin($request)) {
            return response(null, Response::HTTP_ACCEPTED);
        } else {
            return response(['message' => 'The operation failed, please try again'],
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /** @noinspection PhpUnused */
    public function updatePermissions(UpdateChatPermissionsRequest $request)
    {
        $chat = ChatService::updatePermissions($request);
        return response(new ChatResource($chat), Response::HTTP_ACCEPTED);
    }

    /** @noinspection PhpUnused */
    public function showParticipantPermissions(ShowChatParticipantPermissionsRequest $request)
    {
        $result = ChatService::showParticipantPermissions($request);
        return response($result, Response::HTTP_ACCEPTED);
    }

    /** @noinspection PhpUnused */
    public function updatePermissionsForParticipant(UpdateChatPermissionsForParticipantRequest $request)
    {
        $chat = ChatService::updatePermissionsForParticipant($request);
        return response(new ChatResource($chat), Response::HTTP_ACCEPTED);
    }

    /** @noinspection PhpUnused */
    public function listParticipants(ListChatParticipantRequest $request)
    {
        $result = ChatService::listParticipants($request);
        return response(ChatParticipantResource::collectionForUserAndChat($result, $request->user(), $request->chat)
            , Response::HTTP_ACCEPTED);
    }

}
