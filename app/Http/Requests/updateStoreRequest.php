<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateStoreRequest extends FormRequest
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
            "name" => "nullable|min:5|max:20",
            "owner" => "nullable|min:5|max:20",
            "nik" => "nullable|digits:16|unique:stores,nik",
            "ktp" => "nullable|mimes:png,jpg|max:2048",
            "siu" => "nullable|mimes:png,jpg|max:2048",
            "img_owner" => "nullable|mimes:png,jpg|max:2048",
            "img_store" => "nullable|mimes:png,jpg|max:2048",
        ];
    }
}
