<?php

namespace App\Http\Requests\Contact;

use App\H;
use App\Rules\MobileRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed mobile
 * @property mixed file
 * @property mixed name
 * @property mixed username
 * @property mixed contact
 */
class UpdateContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('update',$this->contact);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'mobile' => [new MobileRule()],
            'name' => 'string|max:150',
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
