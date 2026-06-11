<?php

namespace App\Services\PickLight;

use App\Models\Product;
use App\Models\ShelfSlot;
use App\Models\Station;

class SlotResolver
{
    public function findSlotForSku(Station $station, string $sku): ?ShelfSlot
    {
        $product = Product::query()
            ->where('sku', $sku)
            ->where('active', true)
            ->first();

        if (! $product) {
            return null;
        }

        return ShelfSlot::query()
            ->where('current_product_id', $product->id)
            ->whereHas('shelf', function ($query) use ($station) {
                $query->where('station_id', $station->id);
            })
            ->with(['product', 'shelf'])
            ->first();
    }
}