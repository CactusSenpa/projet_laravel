document.addEventListener('DOMContentLoaded', () => {
    const library = document.getElementById('appliance-library');
    const list = document.getElementById('appliance-rows');
    const addBtn = document.getElementById('add-appliance');
    if (!library || !list || !addBtn) {
        return;
    }

    const appliances = JSON.parse(library.textContent);

    const addRow = (preset = null) => {
        const index = list.children.length;
        const item = preset || {
            id: '',
            name: '',
            default_power_w: 100,
            default_duration_hours: 4,
            has_startup_surge: false,
            startup_factor: 3,
        };

        const row = document.createElement('div');
        row.className = 'card mb-3 appliance-row';
        row.innerHTML = `
            <div class="card-body">
                <div class="row g-2 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Nom</label>
                        <input class="form-control" name="items[${index}][name]" value="${item.name}" required>
                        <input type="hidden" name="items[${index}][appliance_id]" value="${item.id || ''}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Puissance (W)</label>
                        <input class="form-control" type="number" min="1" name="items[${index}][power_w]" value="${item.default_power_w}" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Quantité</label>
                        <input class="form-control" type="number" min="1" name="items[${index}][quantity]" value="1" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Heures</label>
                        <input class="form-control" type="number" min="0.1" step="0.1" name="items[${index}][duration_hours]" value="${item.default_duration_hours}" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Période</label>
                        <select class="form-select" name="items[${index}][usage_period]">
                            <option value="jour">Jour</option>
                            <option value="nuit">Nuit</option>
                            <option value="mixte">Mixte</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-outline-danger w-100 remove-row" aria-label="Retirer">&times;</button>
                    </div>
                    <div class="col-12">
                        <div class="form-check">
                            <input type="hidden" name="items[${index}][has_startup_surge]" value="0">
                            <input class="form-check-input" type="checkbox" name="items[${index}][has_startup_surge]" value="1" ${item.has_startup_surge ? 'checked' : ''}>
                            <label class="form-check-label">Pic de démarrage (moteur / compresseur)</label>
                        </div>
                        <input type="hidden" name="items[${index}][startup_factor]" value="${item.startup_factor || 3}">
                    </div>
                </div>
            </div>
        `;
        list.appendChild(row);
    };

    addBtn.addEventListener('click', () => {
        const selectedId = document.getElementById('preset-appliance').value;
        if (selectedId === 'custom') {
            addRow({ name: 'Appareil personnalisé', default_power_w: 100, default_duration_hours: 4, has_startup_surge: false, startup_factor: 3 });
            return;
        }
        const found = appliances.find((a) => String(a.id) === String(selectedId));
        addRow(found);
    });

    list.addEventListener('click', (event) => {
        if (event.target.classList.contains('remove-row')) {
            event.target.closest('.appliance-row').remove();
        }
    });

    const steps = [...document.querySelectorAll('.calc-step')];
    const showStep = (n) => {
        steps.forEach((step, i) => step.classList.toggle('active', i === n));
    };

    document.querySelectorAll('[data-next-step]').forEach((btn) => {
        btn.addEventListener('click', () => showStep(Number(btn.dataset.nextStep)));
    });

    showStep(0);
});
