<?php

namespace App\Http\Requests\Contact;

use App\H;
use App\Rules\MobileRule;
use App\Rules\UsernameRule;
use App\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed mobile
 * @property mixed file
 * @property mixed name
 * @property mixed username
 * @property mixed id
 * @property mixed contact
 */
class DeleteContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
       return $this->user()->can('delete',$this->contact);
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
