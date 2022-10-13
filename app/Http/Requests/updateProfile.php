<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateProfile extends FormRequest
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
            "email" => "nullable|email|unique:users,email",
            "no_hp" => "nullable|min:3|unique:users,no_hp"
        ];
    }
}
