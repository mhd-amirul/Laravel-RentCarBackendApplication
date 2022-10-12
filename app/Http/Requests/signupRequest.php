<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class signupRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "first_name" => "required",
            "last_name" => "required",
            "email" => "required|email|unique:users",
            "no_hp" => "required|min:3|unique:users",
            "password" => "required|min:5|confirmed",
            "password_confirmation" => "required",
        ];
    }

    public function messages()
    {
        return [
            "first_name.required" => "First name must not be null",
            "last_name.required" => "Last name Must not be null"
        ];
    }
}
