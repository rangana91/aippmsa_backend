<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemVariant extends Model
{
    use HasFactory;
    protected $fillable = ['item_id', 'size', 'color', 'quantity'];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
