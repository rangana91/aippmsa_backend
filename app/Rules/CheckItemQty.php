<?php

namespace App\Rules;

use App\Models\Item;
use Illuminate\Contracts\Validation\Rule;

class CheckItemQty implements Rule
{
    private $inventory_code;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($inventoryCode)
    {
        $this->inventory_code = $inventoryCode;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $item = Item::where('inventory_code', $this->inventory_code)->first();
        if ($item->qty < $value) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Stock unavailable.';
    }
}
