<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ChatPhotoRule implements Rule
{
    /**
     * @var string
     */
    private $chatId;

    /**
     * Create a new rule instance.
     *
     * @param string|null $chatId
     */
    public function __construct(string $chatId = null)
    {
        $this->chatId = $chatId;
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
        if ($this->chatId) {
            return Str::startsWith($value, $this->chatId . '/')
                && Storage::disk('chatProfiles')->exists($value);
        }
        return Str::startsWith($value, 'user-' . auth()->id())
            && Storage::disk('chatProfiles')->exists($value);

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The chat photo entered is incorrect.';
    }

}
