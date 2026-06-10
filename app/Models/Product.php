<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use App\Models\ShelfSlot;
use Illuminate\Database\Eloquent\Relations\HasMany;


#[Fillable([
    'sku',
    'name',
    'weight_grams',
    'active',
])]

class Product extends Model
{
    protected function casts(): array
    {
        return [
            'weight_grams'  =>  'float',
            'active'        => 'boolean',
        ];
    }

    public function shelfSlots(): HasMany
    {
        return $this->hasMany(ShelfSlot::class, 'current_product_id');
    }
}
