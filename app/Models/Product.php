<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function shelfSlots()
    {
        return $this->hasMany(ShelfSlot::class, 'current_product_id');
    }
}
