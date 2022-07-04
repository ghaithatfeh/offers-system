<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'name_en' => 'required|min:3',
            'name_pt' => 'required|min:3',
            'name_ar' => 'required|min:3',
            'parent_id' => 'nullable',
            'status' => 'nullable'
        ];
    }
}
