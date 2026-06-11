<?php

namespace App\Services\PickLight;

use App\Enums\DeliveryNoteStatus;
use App\Models\DeliveryNote;
use RuntimeException;

class DeliveryNoteWorkflow
{
    public function markWeighed(DeliveryNote $note): void
    {
        if ($note->status !== DeliveryNoteStatus::IN_PROGRESS) {
            throw new RuntimeException('Delivery note cannot be weighed from current status.');
        }

        $note->update([
            'status' => DeliveryNoteStatus::WEIGHED,
            'weighed_at' => now(),
        ]);
    }

    public function markPrinted(DeliveryNote $note): void
    {
        if ($note->status !== DeliveryNoteStatus::WEIGHED) {
            throw new RuntimeException('Delivery note cannot be printed from current status.');
        }

        $note->update([
            'status' => DeliveryNoteStatus::PRINTED,
            'printed_at' => now(),
        ]);
    }

    public function markCompleted(DeliveryNote $note): void
    {
        if ($note->status !== DeliveryNoteStatus::PRINTED) {
            throw new RuntimeException('Delivery note cannot be completed from current status.');
        }

        $note->update([
            'status' => DeliveryNoteStatus::INVOICED, // temporary until real Xentral finalization
            'completed_at' => now(),
        ]);
    }

    public function cancel(DeliveryNote $note): void
    {
        if (! in_array($note->status, [
            DeliveryNoteStatus::IN_PROGRESS,
            DeliveryNoteStatus::WEIGHED,
        ], true)) {
            throw new RuntimeException('Delivery note cannot be cancelled from current status.');
        }

        $note->update([
            'status' => DeliveryNoteStatus::CANCELLED,
            'completed_at' => now(),
        ]);
    }
}