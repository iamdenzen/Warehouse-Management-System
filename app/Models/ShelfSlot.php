<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Product;
use App\Models\Shelf;

#[Fillable([
    'shelf_id',
    'label',
    'led_from',
    'led_to',
    'oled_channel_front',
    'oled_channel_back',
    'current_product_id',
])]

class ShelfSlot extends Model
{
    public function shelf(): BelongsTo
    {
        return $this->belongsTo(Shelf::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'current_product_id');
    }
}
