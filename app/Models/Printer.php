<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Station;

#[Fillable([
    'name',
    'printnode_printer_id'
])]

class Printer extends Model
{

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
        ];
    }

    public function stations(): HasMany
    {
        return $this->hasMany(Station::class);
    }
}
