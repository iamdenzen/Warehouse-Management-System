<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Station;
use App\Models\ShelfSlot;

#[Fillable([
    'station_id',
    'name',
    'rows',
    'columns'
])]

class Shelf extends Model
{
    protected function casts(): array
    {
        return [
            'rows'      => 'integer',
            'columns'   => 'integer'
        ];
    }

    public function station(): BelongsTo
    {
        return $this->belongsTo(Station::class);
    }

    public function slots(): HasMany
    {
        return $this->hasMany(ShelfSlot::class);
    }
}
