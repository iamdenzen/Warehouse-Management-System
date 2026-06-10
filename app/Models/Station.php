<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Printer;
use App\Models\Shelf;
use App\Models\DeliveryNote;
use App\Models\Event;

#[Fillable([
    'name',
    'location',
    'esp32_led_host',
    'esp32_scale_host',
    'esp32_oled_host',
    'printer_id',
    'weight_tolerance_grams',
    'active',
])]

class Station extends Model
{
    protected function casts(): array
    {
        return [
            'active' => 'boolean',
        ];
    }

    public function printer(): BelongsTo
    {
        return $this->belongsTo(Printer::class);
    }

    public function shelves(): HasMany
    {
        return $this->hasMany(Shelf::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function deliveryNotes(): HasMany
    {
        return $this->hasMany(DeliveryNote::class);
    }
}
