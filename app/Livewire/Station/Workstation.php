<?php

namespace App\Livewire\Station;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Enums\StationScreen;
use App\Enums\DeliveryNoteStatus;
use App\Models\Station;
use App\Models\Event;
use App\Models\User;
use App\Models\RfidCard;
use App\Models\DeliveryNote;
use App\Services\PickLight\DeliveryNoteWorkflow;
use App\Services\PickLight\SlotResolver;
use Carbon\Carbon;

#[Layout('layouts.station')]

class Workstation extends Component
{
    public Station $station;
    public ?User $packer = null;
    public string $screen = StationScreen::LOCKED->value;
    public string $rfidInput = '';
    public string $deliveryNoteNumber = '';
    public array $deliveryNote = [];
    public ?DeliveryNote $currentDeliveryNote = null;
    public int $autoLogoutMinutes = 10;

    public function mount(Station $station): void
    {
        abort_unless($station->active, 404);

        $this->station = $station;

        if ($this->isSessionExpired()) {
            session()->forget([
                'station_packer_id',
                'station_last_activity',
            ]);

            return;
        }

        $packerId = session('station_packer_id');

        if ($packerId) {
            $packer = User::find($packerId);

            if ($packer) {
                $this->packer = $packer;
                $this->screen = StationScreen::WAITING->value;

                $this->resumeActiveDeliveryNote();
            }
        }
    }

    public function render()
    {
        return view('livewire.station.workstation');
    }


    protected function touchActivity(): void
    {
        session([
            'station_last_activity' => now()->timestamp,
        ]);
    }

    protected function isSessionExpired(): bool
    {
        $lastActivity = session('station_last_activity');

        if (! $lastActivity) {
            return false;
        }

        return Carbon::createFromTimestamp($lastActivity)
            ->diffInMinutes(now()) >= $this->autoLogoutMinutes;
    }

    public function checkAutoLogout(): void
    {
        if (! $this->packer) {
            return;
        }

        if (! $this->isSessionExpired()) {
            return;
        }

        $this->logout();
    }

    public function submitRfid(): void
    {
        $uid = trim($this->rfidInput);

        if ($uid === '') {
            return;
        }

        $card = RfidCard::query()
            ->with('user')
            ->where('uid_hash', hash('sha256', $uid))
            ->where('active', true)
            ->first();

        $this->rfidInput = '';

        if (! $card || ! $card->user || ! $card->user->active) {
            return;
        }

        if (! $card->user->isPacker()) {
            return;
        }

        $this->packer = $card->user;

        session([
            'station_packer_id' => $card->user->id,
        ]);

        $this->touchActivity();
        $this->logEvent('packer_login');
        $this->screen = StationScreen::WAITING->value;
    }

    public function logout(): void
    {
        session()->forget([
            'station_packer_id',
            'station_last_activity',
        ]);
        $this->logEvent('packer_logout');
        $this->packer = null;
        $this->deliveryNote = [];
        $this->deliveryNoteNumber = '';
        $this->screen = StationScreen::LOCKED->value;
    }

    public function submitDeliveryNote(SlotResolver $slotResolver): void
    {
        $this->touchActivity();
        if (blank($this->deliveryNoteNumber)) {
            return;
        }

        $this->currentDeliveryNote = DeliveryNote::create([
            'document_number' => $this->deliveryNoteNumber,
            'status' => DeliveryNoteStatus::IN_PROGRESS,
            'station_id' => $this->station->id,
            'user_id' => $this->packer?->id,
            'total_weight_grams' => 1250,
            'started_at' => now(),
        ]);

        $mockItems = [
            [
                'product_id'  => 1,
                'product_sku' => 'test-001',
                'quantity' => 2,
                'expected_weight_grams' => 800,
            ],
            [
                'product_id'  => 2,
                'product_sku' => 'test-002',
                'quantity' => 1,
                'expected_weight_grams' => 450,
            ],
        ];

        $displayItems = [];
        foreach ($mockItems as $item) {
            $slot = $slotResolver->findSlotForSku($this->station, $item['product_sku']);

            $this->currentDeliveryNote->items()->create([
                'product_id' => $slot?->product?->id,
                'product_sku' => $item['product_sku'],
                'quantity' => $item['quantity'],
                'expected_weight_grams' => $item['expected_weight_grams'],
            ]);

            $displayItems[] = [
                'slot_id' => $slot?->id,
                'slot' => $slot?->label ?? 'Nicht zugeordnet',
                'sku' => $item['product_sku'],
                'name' => $slot?->product?->name ?? $item['product_sku'],
                'quantity' => $item['quantity'],
                'led_from' => $slot?->led_from,
                'led_to' => $slot?->led_to,
                'oled_channel_front' => $slot?->oled_channel_front,
            ];

        }

        $this->deliveryNote = [
            'document_number' => $this->deliveryNoteNumber,
            'target_weight' => 1250,
            'items' => $displayItems,
        ];

        $this->logEvent('delivery_note_scanned', [
            'delivery_note_id' => $this->currentDeliveryNote->id,
            'document_number' => $this->deliveryNoteNumber,
        ]);

        $this->dispatch('picklight-illuminate-slots', slots: $displayItems);

        $this->screen = StationScreen::ACTIVE->value;
    }

    public function startWeightCheck(): void
    {
        $this->touchActivity();
        $this->screen = StationScreen::WEIGHT_CHECK->value;
    }

    public function mockWeightOk(DeliveryNoteWorkflow $workflow): void
    {
        $this->touchActivity();
        if ($this->currentDeliveryNote) {
            $workflow->markWeighed($this->currentDeliveryNote);
        }

        $this->logEvent('weight_check_passed', [
            'document_number' => $this->deliveryNote['document_number'] ?? null,
        ]);

        $this->screen = StationScreen::PRINTING->value;
    }

    public function mockWeightFailed(): void
    {
        $this->touchActivity();
        $this->logEvent('weight_check_failed', [
            'document_number' => $this->deliveryNote['document_number'] ?? null,
        ]);
        $this->screen = StationScreen::WEIGHT_DEVIATION->value;
    }

    public function mockPrintDone(DeliveryNoteWorkflow $workflow): void
    {
        $this->touchActivity();
        if ($this->currentDeliveryNote) {
            $workflow->markPrinted($this->currentDeliveryNote);
        }

        $this->logEvent('label_printed', [
            'document_number' => $this->deliveryNote['document_number'] ?? null,
        ]);

        $this->screen = StationScreen::PACKED->value;
    }

    public function finishPacking(DeliveryNoteWorkflow $workflow): void
    {
        $this->touchActivity();
        if ($this->currentDeliveryNote) {
            $workflow->markCompleted($this->currentDeliveryNote);
        }

        $this->currentDeliveryNote = null;
        $this->deliveryNoteNumber = '';
        $this->deliveryNote = [];

        $this->dispatch('picklight-clear-hardware', slots: $this->deliveryNote['items'] ?? []);

        $this->screen = StationScreen::WAITING->value;
    }

    public function cancelDeliveryNote(DeliveryNoteWorkflow $workflow): void
    {
        $this->touchActivity();
        if ($this->currentDeliveryNote) {
            $workflow->cancel($this->currentDeliveryNote);

            $this->logEvent('delivery_note_cancelled', [
                'delivery_note_id' => $this->currentDeliveryNote->id,
                'document_number' => $this->currentDeliveryNote->document_number,
            ]);
        }

        $this->currentDeliveryNote = null;
        $this->deliveryNoteNumber = '';
        $this->deliveryNote = [];

        $this->dispatch('picklight-clear-hardware', slots: $this->deliveryNote['items'] ?? []);

        $this->screen = StationScreen::WAITING->value;
    }

    protected function resumeActiveDeliveryNote(): void
    {
        if (! $this->packer) {
            return;
        }

        $deliveryNote = DeliveryNote::query()
            ->with('items')
            ->where('station_id', $this->station->id)
            ->whereIn('status', [
                DeliveryNoteStatus::IN_PROGRESS,
                DeliveryNoteStatus::WEIGHED,
                DeliveryNoteStatus::PRINTED,
            ])
            ->latest()
            ->first();

        if (! $deliveryNote) {
            return;
        }

        $this->currentDeliveryNote = $deliveryNote;
        $this->deliveryNoteNumber = $deliveryNote->document_number;
        $this->deliveryNote = [
            'document_number' => $deliveryNote->document_number,
            'target_weight' => $deliveryNote->total_weight_grams,
            'items' => $deliveryNote->items->map(function ($item) {
                return [
                    'slot' => $item->product
                                ? ($item->product->shelfSlots()
                                    ->whereHas('shelf', fn ($query) => $query->where('station_id', $this->station->id))
                                    ->first()?->label ?? 'Nicht zugeordnet')
                                : 'Nicht zugeordnet',
                    'sku' => $item->product_sku,
                    'name' => $item->product?->name ?? $item->product_sku,
                    'quantity' => $item->quantity,
                ];
            })->toArray(),
        ];

        $this->screen = StationScreen::ACTIVE->value;
    }

    protected function logEvent(
        string $type,
        array $payload = []
    ): void {
        Event::create([
            'user_id' => $this->packer?->id,
            'station_id' => $this->station->id,
            'type' => $type,
            'payload' => $payload,
        ]);
    }

}