<?php

namespace App\Http\Requests\Chat;

use App\Chat;
use App\ChatOptions;
use App\Rules\ChatLinkRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property mixed options
 * @property mixed type
 * @property mixed notification
 * @property mixed chat_id
 * @property mixed file
 */
class UploadChatPhotoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $chatId = $this->chat_id;
        return empty($chatId) || $this->user()->can('uploadPhoto', Chat::find($chatId));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file' => 'required|image|max:1024',
            'chat_id' => 'nullable',
        ];
    }
}
