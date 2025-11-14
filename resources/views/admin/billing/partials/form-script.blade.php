<script>
document.addEventListener('DOMContentLoaded', function() {
    const quantityInputs = document.querySelectorAll('.fleet-quantity');
    const pickupInput = document.getElementById('pickup_date');
    const dropoffInput = document.getElementById('dropoff_date');
    const totalInput = document.querySelector('[x-model="total"]');
    const daysInput = document.querySelector('[x-model="days"]');
    const priceInput = document.getElementById('price_per_day');

    const MS_PER_DAY = 1000 * 60 * 60 * 24;

    function parseDateLocal(dateString) {
        if (!dateString) return null;
        const parts = dateString.split('-').map(Number);
        return new Date(parts[0], parts[1] - 1, parts[2]);
    }

    function calculateTotal() {
        let totalRate = 0;
        quantityInputs.forEach(input => {
            const qty = parseInt(input.value, 10) || 0;
            const rate = parseFloat(input.dataset.rate || 0);
            totalRate += qty * rate;
        });

        if (priceInput) {
            priceInput.value = totalRate;
        }

        const pickup = parseDateLocal(pickupInput?.value);
        const dropoff = parseDateLocal(dropoffInput?.value);

        if (pickup && dropoff) {
            const diffMs = dropoff.getTime() - pickup.getTime();

            if (diffMs < 0) {
                daysInput.value = 0;
                totalInput.value = '0.00';
                return;
            }

            const diffDays = Math.round(diffMs / MS_PER_DAY);
            const days = Math.max(1, diffDays || 0);
            daysInput.value = days;

            const total = days * totalRate;
            totalInput.value = total.toFixed(2);
        } else {
            daysInput.value = 0;
            totalInput.value = '0.00';
        }
    }

    quantityInputs.forEach(input => {
        input.addEventListener('input', calculateTotal);
        input.addEventListener('change', calculateTotal);
    });
    pickupInput?.addEventListener('change', calculateTotal);
    dropoffInput?.addEventListener('change', calculateTotal);

    calculateTotal();
});
</script>

