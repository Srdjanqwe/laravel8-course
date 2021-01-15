<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule as ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUser extends FormRequest
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
            'avatar' => 'image|mimes:png,jpg,jpeg,gif,svg|max:1024|dimensions:width=128,height=128',
            // 'avatar' => 'image|mimes:png,jpg,jpeg,gif,svg|max:1024|dimensions:min_height=500'
            'locale' =>  [
                'required',
                ValidationRule::in(array_keys(User::Locales))
            ]
        ];
    }
}
