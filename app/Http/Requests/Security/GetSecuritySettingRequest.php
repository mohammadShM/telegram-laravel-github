<?php

namespace App\Http\Requests\Security;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed mobile
 * @property mixed file
 * @property mixed name
 * @property mixed username
 * @property mixed contact
 * @property mixed user
 */
class GetSecuritySettingRequest extends FormRequest
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
        ];
    }

}
