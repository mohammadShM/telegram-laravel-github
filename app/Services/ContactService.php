<?php

namespace App\Services;

use App\Contact;
use App\Http\Requests\Contact\AddContactRequest;
use App\Http\Requests\Contact\DeleteContactRequest;
use App\Http\Requests\Contact\ListContactRequest;
use App\Http\Requests\Contact\UpdateContactRequest;
use App\User;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ContactService
{
    public static function create(AddContactRequest $request)
    {
        /** @var User $user */
        $user = $request->user();
        /** @noinspection PhpUndefinedMethodInspection */
        $contactUser = $request->username
            ? User::where('username', $request->username)->first()
            : User::where('mobile', $request->mobile)->first();
        if (empty($contactUser)) {
            throw new NotFoundHttpException('Contact not found');
        }
        /** @var Contact $contact */
        /** @noinspection PhpUndefinedMethodInspection */
        $contact = $user->contacts()->withTrashed()->where('contact_id', $contactUser->id)->first();
        if (empty($contact)) {
            $contact = $user->contacts()->create([
                'user_id' => $user->id,
                'contact_id' => $contactUser->id,
                'mobile' => $request->username ? null : $request->mobile,
                'name' => $request->name ?: $contactUser->name,
            ]);
        }
        if ($contact->trashed()) { // for deleted_at active (softDeletes)
            $contact->restore();
        }
        return $contact;
    }

    public static function delete(DeleteContactRequest $request)
    {
        /** @var Contact $contact */
        $contact = $request->contact;
        /** @noinspection PhpUnhandledExceptionInspection */
        return $contact->delete();
    }

    public static function update(UpdateContactRequest $request)
    {
        if (!empty($request->name)) {
            $request->contact->name = $request->name;
        }
        if (!empty($request->mobile)) {
            if ($request->mobile === $request->contact->contact->mobile) {
                $request->contact->mobile = $request->mobile;
            } else {
                return false;
            }
        }
        $request->contact->save();
        return $request->contact;
    }

    public static function list(ListContactRequest $request)
    {
        return $request->user()->contacts()
            ->with(['contact'])
            ->get();
//        return Contact::with(['user'])
//            ->where('user_id',$request->user()->id)
//            ->get();
    }

}
