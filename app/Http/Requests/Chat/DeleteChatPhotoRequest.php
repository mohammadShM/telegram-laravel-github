<?php

namespace App\Http\Requests\Chat;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed options
 * @property mixed type
 * @property mixed notification
 * @property mixed chat
 * @property mixed chat_id
 * @property mixed photo_id
 */
class DeleteChatPhotoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('deletePhoto', $this->chat);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'photo_id' => 'required|string',
        ];
    }

    public function getValidatorInstance()
    {
        $this->merge(['photo_id' => $this->photo_id]);
        return parent::getValidatorInstance();
    }

}
