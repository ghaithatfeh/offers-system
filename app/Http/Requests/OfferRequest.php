<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'offer_type_id' => Rule::requiredIf(auth()->user()->role != 'Store Owner'),
            'images.*' => 'image',
            'cities.*' => 'nullable',
            'tags.*' => 'nullable'
        ];
    }
}
