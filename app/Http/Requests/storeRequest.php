<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeRequest extends FormRequest
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
            "name" => "required|min:5|max:20",
            "owner" => "required|min:5|max:20",
            "nik" => "required|digits:16|unique:stores,nik",
            "village" => "required",
            "city" => "required",
            "province" => "required",
            "latitude" => "required",
            "longitude" => "required",
            "ktp" => "mimes:png,jpg|max:2048",
            "siu" => "mimes:png,jpg|max:2048",
            "img_owner" => "mimes:png,jpg|max:2048",
            "img_store" => "mimes:png,jpg|max:2048",
        ];
    }
}
