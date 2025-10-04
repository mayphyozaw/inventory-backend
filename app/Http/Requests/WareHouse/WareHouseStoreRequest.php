<?php

namespace App\Http\Requests\WareHouse;

use Illuminate\Foundation\Http\FormRequest;

class WareHouseStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:ware_houses,email,' . $this->route('warehouse'),
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:255',

        ];
    }
}
