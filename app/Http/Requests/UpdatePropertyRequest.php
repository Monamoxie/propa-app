<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePropertyRequest extends FormRequest
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
            'property_type' => ['required', 'integer', 'exists:property_types,id'],
            'country' => ['required', 'string'],
            'address' => ['required', 'string'],
            'town' => ['required', 'string'],
            'county' => ['required', 'string'],
            'latitude' => ['required', 'string'],
            'longitude' => ['required', 'string'],
            'price' => ['required', 'string'],
            'type' => ['required', 'string'],
            'num_bathrooms' => ['required', 'integer'],
            'num_bedrooms' => ['required', 'integer'],
            'description' => ['required', 'string'],
            'image_full' => ['nullable', 'file', 'image', 'mimes:jpeg,jpg,png', 'max:5120'],
        ];
    }
}
