<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\AddContactRequest;
use App\Http\Requests\Contact\DeleteContactRequest;
use App\Http\Requests\Contact\ListContactRequest;
use App\Http\Requests\Contact\UpdateContactRequest;
use App\Http\Resources\ContactResource;
use App\Services\ContactService;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/** @noinspection PhpUnused */

class ContactController extends Controller
{
    public function create(AddContactRequest $request)
    {
        try {
            $contact = ContactService::create($request);
            return new ContactResource($contact);
        } catch (NotFoundHttpException $exception) {
            return abort(Response::HTTP_NOT_FOUND, 'Cannot create contact');
        } catch (Exception $exception) {
            Log::error($exception);
        }
        return abort(Response::HTTP_INTERNAL_SERVER_ERROR, 'Cannot create contact');
    }

    public function update(UpdateContactRequest $request)
    {
        try {
            $contact = ContactService::update($request);
            if ($contact === false) {
                return abort(Response::HTTP_BAD_REQUEST, 'mobile is not the same as contact mobile');
            }
            return new ContactResource($contact);
        } catch (HttpException $exception) {
            return abort($exception->getStatusCode(), 'Cannot update contact');
        } catch (Exception $exception) {
            Log::error($exception);
        }
        return abort(Response::HTTP_INTERNAL_SERVER_ERROR, 'Cannot update contact');
    }

    public function delete(DeleteContactRequest $request)
    {
        try {
            ContactService::delete($request);
            return response([], Response::HTTP_ACCEPTED);
        } catch (Exception $exception) {
            Log::error($exception);
        }
        return abort(Response::HTTP_INTERNAL_SERVER_ERROR, 'Cannot delete contact');
    }

    public function list(ListContactRequest $request)
    {
        try {
            $contact = ContactService::list($request);
            return ContactResource::collection($contact);
        } catch (Exception $exception) {
            Log::error($exception);
        }
        return abort(Response::HTTP_INTERNAL_SERVER_ERROR, 'Cannot get user list');
    }

}
