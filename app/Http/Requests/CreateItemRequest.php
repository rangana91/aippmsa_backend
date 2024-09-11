<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'type' => 'required|string|in:shirt,t-shirt,blouse,skirt,short',
            'category_id' => 'required|integer|exists:categories,id',
            'price' => 'required|integer|min:1',
            'size' => 'required|array',
            'size.*' => 'required|string',
            'color' => 'required|array',
            'color.*' => 'required|string',
            'quantity' => 'required|array',
            'quantity.*' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'language' => 'nullable|string',
            'imageFile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }

    /**
     * Get custom messages for validation errors.
     *
     * @return array<string, mixed>
     */
    public function messages(): array
    {
        return [
            'size.required' => 'At least one size is required.',
            'size.*.required' => 'Each size is required and must be valid.',
            'color.required' => 'At least one color is required.',
            'color.*.required' => 'Each color is required and must be valid.',
            'quantity.required' => 'At least one quantity is required.',
            'quantity.*.required' => 'Each quantity is required and must be valid.',
            'quantity.*.integer' => 'Each quantity must be an integer.',
            'quantity.*.min' => 'Each quantity must be at least 1.',
            'price.required' => 'Price is required.',
            'price.integer' => 'Price must be an integer value.',
            'price.min' => 'Price must be at least 1.'
        ];
    }
}
