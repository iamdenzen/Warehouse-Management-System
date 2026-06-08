<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryNoteItem extends Model
{
    public function deliveryNote()
    {
        return $this->belongsTo(DeliveryNote::class);
    }
}
