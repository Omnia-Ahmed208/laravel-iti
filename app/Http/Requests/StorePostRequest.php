<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // return false;
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => ['required', 'min:3'],
            'description' => ['required', 'min:10'],
            "select_post" => 'exists:\App\Models\User,id', // laravel validation (exists)
            'image' => ['mimes:jpg,png'],
        ];
    }

    public function messages()
    {
        return [
            'title.required' => "the title shouldn't be empty", // for change default error msg
            'title.min' => "minimum length of the title is 3"
        ];
    }
}

