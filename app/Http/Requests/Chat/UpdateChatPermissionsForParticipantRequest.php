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
 * @property mixed user
 */
class UpdateChatPermissionsForParticipantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('updateChatPermissionsForParticipant', [$this->chat, $this->user]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "send_message" => 'required|boolean',
            "send_media" => 'required|boolean',
            "add_member" => 'required|boolean',
            "pin_message" => 'required|boolean',
            "change_info" => 'required|boolean',
        ];
    }

}
