<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfferRequest extends FormRequest
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
            'title' => 'required',
            'expiry_date' => 'nullable|after:yesterday',
            'price' => 'required|numeric|min:1',
            'category_id' => 'required',
            'description' => 'required|min:20',
            'images.*' => 'image',
            'offer_type_id' => 'nullable',
            'cities.*' => 'nullable',
            'tags.*' => 'nullable'
        ];
    }
}
