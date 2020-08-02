<?php

namespace App\Rules;

use App\Chat;
use App\H;
use Illuminate\Contracts\Validation\Rule;

class ChatLinkRule implements Rule
{
    /**
     * @var string
     */
    private $chatScope;
    /**
     * @var Chat
     */
    private $chat;

    /**
     * Create a new rule instance.
     *
     * @param string|null $chatScope
     * @param Chat $chat
     */
    public function __construct(string $chatScope = null, Chat $chat = null)
    {
        $this->chatScope = $chatScope;
        $this->chat = $chat;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return !is_null($this->chatScope) && H::isUniqueChatLink($value, $this->chatScope, $this->chat);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The link entered is incorrect.';
    }
}
