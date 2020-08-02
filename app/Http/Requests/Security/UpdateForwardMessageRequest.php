<?php

namespace App\Http\Requests\Security;

use App\Rules\SecurityAccessLevelRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed mobile
 * @property mixed file
 * @property mixed name
 * @property mixed username
 * @property mixed contact
 * @property mixed user
 * @property mixed value
 * @property mixed users
 */
class UpdateForwardMessageRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('change-setting');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'value'=> ['required', new SecurityAccessLevelRule()],
        ];
    }

}
