<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shelf extends Model
{
    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function slots()
    {
        return $this->hasMany(ShelfSlot::class);
    }
}
