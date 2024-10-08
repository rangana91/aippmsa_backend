<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email',
            'gender' => 'required|string|in:Male,Female,Other',
            'date_of_birth' => 'required|date',
            'address' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'post_code' => 'required|string|max:20',
            'number' => 'nullable|string|max:20'
        ];
    }
}
