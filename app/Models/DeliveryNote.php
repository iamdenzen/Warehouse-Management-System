<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\DeliveryNoteItem;
use App\Enums\DeliveryNoteStatus;

#[Fillable([
    'document_number',
    'sales_order_id',
    'xentral_delivery_id',
    'status',
    'station_id',
    'user_id',
    'tracking_number',
    'label_pdf_base64',
    'printnode_job_id',
    'total_weight_grams',
    'started_at',
    'weighed_at',
    'labeled_at',
    'printed_at',
    'completed_at'
])]

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

    public function items(): HasMany
    {
        return $this->hasMany(DeliveryNoteItem::class);
    }
}
