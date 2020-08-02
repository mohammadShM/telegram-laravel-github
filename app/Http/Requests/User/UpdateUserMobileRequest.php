<?php

namespace App\Http\Requests\User;

use App\H;
use App\Rules\MobileRule;
use App\Rules\UsernameRule;
use App\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed mobile
 */
class UpdateUserMobileRequest extends FormRequest
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
        $user = $this->user();
        return [
            'mobile' => ['required', new MobileRule(), 'unique:users,mobile,' . $user->id],
        ];
    }

    public function getValidatorInstance()
    {
        if ($this->has('mobile')) {
            $this->merge(['mobile' => H::toMobile($this->mobile)]);
        }
        return parent::getValidatorInstance();
    }

}
