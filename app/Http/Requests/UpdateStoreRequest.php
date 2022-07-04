<?php

namespace App\Http\Requests;

use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStoreRequest extends FormRequest
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
            'name' => 'required|string|min:3',
            'description' => 'nullable|string',
            'city_id' => 'nullable|numeric',
            'expiry_date' => 'date|after:yesterday',
            'user_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $this->route('store')->user_id
        ];
    }
}
