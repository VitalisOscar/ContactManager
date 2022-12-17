<?php

namespace App\Http\Requests\Contacts;

use App\Models\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class ContactDataRequest extends FormRequest
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
            'full_name' => 'required|string',
            'email' => 'required|email',
            'photo' => 'nullable|image|max:512',
            'phone_numbers' => 'required|array',
            'phone_numbers.*' => 'array',
            'phone_numbers.*.number' => 'required|string',
            'phone_numbers.*.label' => 'nullable|in:'.implode(',', PhoneNumber::LABELS)
        ];
    }
}