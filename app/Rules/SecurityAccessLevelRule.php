<?php

namespace App\Rules;

use App\Security;
use Illuminate\Contracts\Validation\Rule;

class SecurityAccessLevelRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        return is_string($value) && in_array($value, Security::ACCESS_LEVELS);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Access is incorrect.';
    }
}
