<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateCarRequest extends FormRequest
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
            "plat" => "nullable|min:1",
            "brand" => "nullable|max:20",
            "model" => "nullable|max:20",
            "varian" => "nullable|max:10",
            "transmisi" => "nullable|max:10",
            "warna" => "nullable|max:20",
            "cc" => "nullable|max:10",
            "seater" => "nullable|max:2",
            "bbm" => "nullable|max:20",
            "harga" => "nullable|max:20",
            "image1" => "nullable|file"
        ];
    }
}
