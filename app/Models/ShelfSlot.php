<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShelfSlot extends Model
{
    public function shelf()
    {
        return $this->belongsTo(Shelf::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'current_product_id');
    }
}
