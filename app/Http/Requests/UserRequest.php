<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Set this to true if you want to authorize the validation
        // The default is false
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
            'name' => 'required|max:50',
            // I want to check the user if exists first
            // If exists, will pass the email for unique validation
            // This is efficient, rather than we creating another validation for create or update
            'email' => request()->route('user') 
                ? 'required|email|max:255|unique:users,email,' . request()->route('user')
                : 'required|email|max:255|unique:users,email',
            'password' => request()->route('user') ? 'nullable' : 'required|max:50'
        ];
    }
}
