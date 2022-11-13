<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class addCarRequest extends FormRequest
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
            "plat" => "required|min:1",
            "brand" => "required|max:20",
            "model" => "required|max:20",
            "varian" => "required|max:10",
            "transmisi" => "required|max:10",
            "tahun" => "required",
            "warna" => "required|max:20",
            "cc" => "required|max:10",
            "seater" => "required|max:2",
            "bbm" => "required|max:20",
            "harga" => "required|max:20",
            "image1" => "required|file"
        ];
    }
}
