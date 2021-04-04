<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageRequest extends FormRequest
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
            'image' => 'required|file|mimes:jpeg,jpg,png,gif|max:10000',
        ];
    }

    public function messages()
    {
        return [
            'image.required' => 'A :attribute is required',
            'image.file' => 'A :attribute must be file',
            'image.mimes' => 'A :attribute must be correct type',
            'image.max' => 'A :attribute is too large',
        ];
    }

}
