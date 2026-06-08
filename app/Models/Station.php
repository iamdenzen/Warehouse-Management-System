<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    public function printer()
    {
        return $this->belongsTo(Printer::class);
    }

    public function shelves()
    {
        return $this->hasMany(Shelf::class);
    }
}
