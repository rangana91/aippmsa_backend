<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateItemRequest extends FormRequest
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
            'id' => 'required|integer|exists:items,id',
            'name' => 'required|string|max:255',
            'category_id' => 'required|integer|exists:categories,id',
            'price' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'language' => 'nullable|string|max:10',
            'imageFile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'variants' => 'required|array',
            'variants.*.size' => 'required|string',
            'variants.*.color' => 'required|string',
            'variants.*.quantity' => 'required|integer|min:1',
        ];
    }

    /**
     * Custom messages for validation errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'id.required' => 'The item ID is required.',
            'id.exists' => 'The item does not exist.',
            'name.required' => 'The item name is required.',
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'The selected category is invalid.',
            'price.required' => 'The price is required.',
            'price.integer' => 'The price must be a valid number.',
            'inventory_code.unique' => 'The inventory code must be unique.',
            'imageFile.image' => 'The file must be an image.',
            'imageFile.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
            'imageFile.max' => 'The image size must not exceed 2MB.',

            'variants.required' => 'You must provide at least one variant.',
            'variants.*.size.required' => 'Each variant must have a size.',
            'variants.*.color.required' => 'Each variant must have a color.',
            'variants.*.quantity.required' => 'Each variant must have a quantity.',
            'variants.*.quantity.integer' => 'Each variant quantity must be a valid number.',
            'variants.*.quantity.min' => 'Each variant quantity must be at least 1.',
        ];
    }
}
