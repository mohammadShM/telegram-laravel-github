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
 * @property mixed chat
 */
class ShowChatRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('show', $this->chat);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        ];
    }
}
