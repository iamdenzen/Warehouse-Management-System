window.stationHardware = function (config) {
    return {
        weight: 0,
        scaleTimer: null,

        async setSlotsRed(items) {
            console.log('Light slots:', items);

            // Later:
            // POST http://<led-host>/json/state
        },

        async clearHardware() {
            console.log('Clear LEDs/OLEDs');
        },

        startScalePolling() {
            if (this.scaleTimer) {
                clearInterval(this.scaleTimer);
            }

            this.scaleTimer = setInterval(async () => {
                try {
                    const response = await fetch(`http://${config.scaleHost}/weight`);
                    const data = await response.json();

                    this.weight = Math.round(data.weight ?? 0);
                } catch (error) {
                    console.error('Scale unreachable', error);
                }
            }, 300);
        },
    };
};

document.addEventListener('livewire:init', () => {
    Livewire.on('delivery-note-started', ({ items }) => {
        window.dispatchEvent(new CustomEvent('picklight:slots-started', {
            detail: items,
        }));
    });

    Livewire.on('start-scale-polling', () => {
        window.dispatchEvent(new CustomEvent('picklight:start-scale'));
    });

    Livewire.on('clear-hardware', () => {
        window.dispatchEvent(new CustomEvent('picklight:clear-hardware'));
    });
});