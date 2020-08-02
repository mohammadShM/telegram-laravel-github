<?php

namespace App\Http\Requests\Chat;

use App\Chat;
use App\ChatOptions;
use App\Rules\ChatLinkRule;
use App\Rules\ChatPhotoRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed options
 * @property mixed type
 * @property mixed notification
 */
class CreateChatRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => 'required|in:' . implode(',', Chat::CHAT_TYPES),
            'notification' => 'boolean',
            'options' => 'required|array',
            'options.scope' => 'required|in:' . implode(',', ChatOptions::CHAT_SCOPES),
            'options.sign_messages' => 'boolean',
            'options.show_chat_history' => 'boolean',
            'options.link' => [new ChatLinkRule($this->options['scope'] ?? null)],
            'options.name' => 'nullable|string|min:1',
            'options.description' => 'nullable|string|min:1',
            'options.photo' => ['nullable', new ChatPhotoRule()],
        ];
    }
}
