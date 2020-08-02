<?php

namespace App\Http\Requests\Chat;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed options
 * @property mixed type
 * @property mixed notification
 * @property mixed chat
 * @property mixed chat_id
 * @property mixed photo_id
 * @property mixed users
 */
class AddChatParticipantsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('addParticipant', [$this->chat,$this->users]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'users' => 'required|array',
        ];
    }

}
