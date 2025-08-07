<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreService extends FormRequest
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
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'available' => 'nullable|boolean',
            'file' => 'required|image|mimes:png,jpeg,jpg,svg|max:2048',
            
            'ingredient_id' => 'required|array',
            'ingredient_id.*' => 'integer|exists:stock,id', // Regra de validação para cada valor que vem do array
        ];
    }
}
