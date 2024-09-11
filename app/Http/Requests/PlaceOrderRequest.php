<?php

namespace App\Http\Requests;

use App\Rules\CheckItemQty;
use Illuminate\Foundation\Http\FormRequest;

class PlaceOrderRequest extends FormRequest
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
            'inventory_code' => 'required|string|exists:items,inventory_code',
            'qty' => ['required', 'int', new CheckItemQty($this->inventory_code)],
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|email',
            'number' => 'nullable',
            'address' => 'required|string'
        ];
    }
}
