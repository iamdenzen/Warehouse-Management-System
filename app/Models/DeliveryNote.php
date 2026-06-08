<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\DeliveryNoteStatus;

class DeliveryNote extends Model
{
    
    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'weighed_at' => 'datetime',
            'labeled_at' => 'datetime',
            'printed_at' => 'datetime',
            'completed_at' => 'datetime',
            'status' => DeliveryNoteStatus::class,
        ];
    }

    public function items()
    {
        return $this->hasMany(DeliveryNoteItem::class);
    }
}
