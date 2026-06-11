<div 
    wire:poll.30s="checkAutoLogout"
    class="min-h-screen bg-slate-100 p-8 text-slate-900">
    <div class="mx-auto max-w-5xl">
        <header class="mb-10 text-center">
            <h1 class="text-5xl font-bold text-blue-700">
                {{ $station->name }}
            </h1>
        </header>

        @if ($screen === 'locked')
            <section class="rounded-3xl bg-white p-12 text-center shadow">
                <h2 class="mb-6 text-5xl font-bold">
                    Chip vorhalten
                </h2>

                <p class="mb-8 text-2xl text-slate-500">
                    Bitte Mitarbeiter-Chip scannen.
                </p>

                <input
                    type="text"
                    wire:model="rfidInput"
                    wire:keydown.enter="submitRfid"
                    autofocus
                    class="mx-auto block w-full max-w-md rounded-xl border border-slate-300 p-4 text-center text-2xl"
                    placeholder="RFID Test"
                >
            </section>
        @endif

        @if ($screen === 'waiting')
            <section class="rounded-3xl bg-white p-12 text-center shadow">
                <h2 class="mb-6 text-5xl font-bold text-green-600">
                    Station bereit
                </h2>
                <p class="mb-4 text-xl text-slate-600">
                    Mitarbeiter:
                    <strong>{{ $packer?->name }}</strong>
                </p>

                <p class="mb-8 text-2xl text-slate-500">
                    Bitte Lieferschein scannen.
                </p>

                <input
                    type="text"
                    wire:model="deliveryNoteNumber"
                    wire:keydown.enter="submitDeliveryNote"
                    autofocus
                    class="mx-auto block w-full max-w-md rounded-xl border border-slate-300 p-4 text-center text-2xl"
                    placeholder="Lieferschein"
                >

                <button
                    wire:click="logout"
                    class="rounded-xl bg-red-600 px-5 py-3 text-white"
                >
                    Logout
                </button>
            </section>
        @endif

        @if ($screen === 'active')
            <section class="rounded-3xl bg-white p-8 shadow">

                <div class="mb-8 flex justify-between items-center">
                    <div>
                        <h2 class="text-4xl font-bold">
                            Lieferschein {{ $deliveryNote['document_number'] }}
                        </h2>

                        <p class="text-xl text-slate-500">
                            Zielgewicht:
                            {{ $deliveryNote['target_weight'] }} g
                        </p>
                    </div>

                    <button
                        wire:click="cancelDeliveryNote"
                        class="rounded-xl bg-red-600 px-6 py-4 text-white font-bold"
                    >
                        Abbrechen
                    </button>
                </div>

                <table class="w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="p-4 text-left">Slot</th>
                            <th class="p-4 text-left">Produkt</th>
                            <th class="p-4 text-left">SKU</th>
                            <th class="p-4 text-left">Menge</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($deliveryNote['items'] as $item)
                            <tr class="border-b">
                                <td class="p-4 font-bold">
                                    {{ $item['slot'] }}
                                </td>

                                <td class="p-4">
                                    {{ $item['name'] }}
                                </td>

                                <td class="p-4">
                                    {{ $item['sku'] }}
                                </td>

                                <td class="p-4 font-bold">
                                    {{ $item['quantity'] }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-8 text-center">
                    <button
                        wire:click="startWeightCheck"
                        class="rounded-xl bg-blue-700 px-10 py-5 text-2xl font-bold text-white"
                    >
                        Fertig gepickt — Gewicht prüfen
                    </button>
                </div>

            </section>
        @endif

        @if ($screen === 'weight-check')
            <section class="rounded-3xl bg-white p-12 text-center shadow">
                <h2 class="mb-6 text-5xl font-bold">
                    Box auf Waage stellen
                </h2>

                <p class="mb-8 text-2xl text-slate-500">
                    Zielgewicht: {{ $deliveryNote['target_weight'] ?? 0 }} g
                </p>

                <div class="mx-auto mb-8 flex h-48 w-48 items-center justify-center rounded-full bg-blue-100 text-5xl font-bold text-blue-700">
                    0 g
                </div>

                <p class="text-2xl text-slate-500">
                    Waage wird später automatisch gelesen.
                </p>

                <div class="mt-8 flex justify-center gap-4">
                    <button
                        wire:click="mockWeightOk"
                        class="rounded-xl bg-green-600 px-8 py-4 text-xl font-bold text-white"
                    >
                        Test: Gewicht OK
                    </button>

                    <button
                        wire:click="mockWeightFailed"
                        class="rounded-xl bg-red-600 px-8 py-4 text-xl font-bold text-white"
                    >
                        Test: Abweichung
                    </button>
                </div>
            </section>
        @endif

        @if ($screen === 'weight-deviation')
            <section class="rounded-3xl bg-white p-12 text-center shadow">
                <h2 class="mb-6 text-5xl font-bold text-red-600">
                    Gewichtsabweichung
                </h2>

                <p class="mb-8 text-2xl text-slate-600">
                    Bitte Menge prüfen, Box von der Waage nehmen und erneut auflegen.
                </p>

                <button
                    wire:click="startWeightCheck"
                    class="rounded-xl bg-blue-700 px-10 py-5 text-2xl font-bold text-white"
                >
                    Erneut prüfen
                </button>
            </section>
        @endif

        @if ($screen === 'printing')
            <section class="rounded-3xl bg-white p-12 text-center shadow">
                <h2 class="mb-6 text-5xl font-bold text-blue-700">
                    Label wird gedruckt
                </h2>

                <p class="text-2xl text-slate-500">
                    PrintNode-Anbindung kommt später.
                </p>

                <div class="mt-8">
                    <button
                        wire:click="mockPrintDone"
                        class="rounded-xl bg-green-600 px-10 py-5 text-2xl font-bold text-white"
                    >
                        Test: Druck fertig
                    </button>
                </div>
            </section>
        @endif

        @if ($screen === 'packed')
            <section class="rounded-3xl bg-white p-12 text-center shadow">
                <h2 class="mb-6 text-5xl font-bold text-green-600">
                    Paket fertigstellen
                </h2>

                <p class="mb-8 text-2xl text-slate-600">
                    Karton packen und Label aufkleben.
                </p>

                <button
                    wire:click="finishPacking"
                    class="rounded-xl bg-blue-700 px-10 py-5 text-2xl font-bold text-white"
                >
                    Fertig — nächster Lieferschein
                </button>
            </section>
        @endif

    </div>

    @script
    <script>
        const ledHost = @js($station->esp32_led_host);
        const oledHost = @js($station->esp32_oled_host);

        function buildLedPayload(slots, color = [255, 0, 0]) {
            const indexes = [];

            slots.forEach(slot => {
                if (!slot.led_from || !slot.led_to) {
                    return;
                }

                for (let i = slot.led_from; i <= slot.led_to; i++) {
                    indexes.push(i, color);
                }
            });

            return {
                seg: [
                    {
                        i: indexes
                    }
                ]
            };
        }

        async function illuminateSlots(slots) {
            const payload = buildLedPayload(slots);

            console.log('LED payload:', payload);

            // Enable later when ESP32 is available:
            /*
            await fetch(`http://${ledHost}/json/state`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(payload),
            });
            */
        }

        async function clearHardware(slots) {
            const payload = buildLedPayload(slots, [0, 0, 0]);

            console.log('Clear LED payload:', payload);
            console.log('Clear OLED payload: clear all');

            // Enable later when ESP32 is available:
            /*
            await fetch(`http://${ledHost}/json/state`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(payload),
            });

            await fetch(`http://${oledHost}/display/clear`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({}),
            });
            */
        }

        async function writeOledQuantities(slots) {
            for (const slot of slots) {
                if (!slot.oled_channel_front) {
                    continue;
                }

                const payload = {
                    channel: slot.oled_channel_front,
                    line1: `Slot ${slot.slot}`,
                    line2: `${slot.quantity} pcs`,
                };

                console.log('OLED payload:', payload);

                // Enable later when ESP32 is available:
                /*
                await fetch(`http://${oledHost}/display`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(payload),
                });
                */
            }
        }

        $wire.on('picklight-illuminate-slots', event => {
            illuminateSlots(event.slots);
            writeOledQuantities(event.slots);
        });

        $wire.on('picklight-clear-hardware', event => {
            clearHardware(event.slots || []);
        });
    </script>
    @endscript

</div>