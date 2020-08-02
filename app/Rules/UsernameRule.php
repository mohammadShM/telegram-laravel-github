<?php

namespace App\Rules;

use App\H;
use App\User;
use Illuminate\Contracts\Validation\Rule;

class UsernameRule implements Rule
{
    /**
     * @var User
     */
    private $user;
    /**
     * @var bool
     */
    private $skipUserCheck;

    /**
     * Create a new rule instance.
     *
     * @param User $user
     * @param bool $skipUserCheck
     */
    public function __construct(User $user = null, bool $skipUserCheck = false)
    {
        $this->user = $user;
        $this->skipUserCheck = $skipUserCheck;
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
        if (!H::isValidUsername($value)) return false;
        // when checked $skipUserCheck == false because ! before variable
        // when not checked $skipUserCheck == true
        if (!$this->skipUserCheck) {
            if (!$this->user) {
                /** @noinspection PhpUndefinedMethodInspection */
                if (User::where(['username' => $value])->count()) return false;
            } else {
                /** @noinspection PhpUndefinedMethodInspection */
                if (User::where(['username' => $value])->where('id', '!=', $this->user->id)->count()) return false;
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The username is not valid.';
    }
}
