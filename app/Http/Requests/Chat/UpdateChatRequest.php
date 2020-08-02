<?php

namespace App\Http\Requests\Chat;

use App\ChatOptions;
use App\Rules\ChatLinkRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed options
 * @property mixed type
 * @property mixed notification
 * @property mixed chat
 */
class UpdateChatRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('update', $this->chat);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'type' => 'nullable|in:' . implode(',', Chat::CHAT_TYPES),
            'notification' => 'nullable|boolean',
            'options' => 'nullable|array',
            'options.scope' => 'nullable|required_with:options.link|in:'
                . implode(',', ChatOptions::CHAT_SCOPES),
            'options.sign_messages' => 'nullable|boolean',
            'options.show_chat_history' => 'nullable|boolean',
            'options.link' => ['nullable', new ChatLinkRule($this->options['scope'] ?? null,$this->chat)],
            'options.name' => 'nullable|string|min:1',
            'options.description' => 'nullable|string|min:1',
            // 'options.photo' => ['nullable', new ChatPhotoRule()],
        ];
    }
}
