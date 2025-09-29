<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class="container mt-4 p-3 shadow rounded" style="background-color:#f8f9fa; max-width:600px;">
    <h3 class="text-center mb-3" style="color:#2c3e50;">Exportar Superhéroes a PDF</h3>

    <form id="superheroForm" action="<?= base_url('tarea06/exportPDF') ?>" method="POST">

        <!-- Título -->
        <div class="mb-3">
            <label class="form-label"><strong>Título:</strong></label>
            <input type="text" name="titulo" value="Reporte 01" class="form-control form-control-sm" required>
        </div>

        <!-- Géneros -->
        <div class="mb-3">
            <label class="form-label"><strong>Géneros:</strong></label><br>
            <?php foreach ($genders as $gender): ?>
                <div class="form-check form-check-inline">
                    <input class="form-check-input gender-checkbox" type="checkbox" name="gender_ids[]"
                        value="<?= $gender['id'] ?>">
                    <label class="form-check-label"><?= $gender['gender'] ?></label>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Cantidades por género -->
        <div id="genderCounts" class="p-2 mb-2 rounded"
            style="background-color:#e3eaf1; display:none; border:1px solid #cfd8e3;">
            <small class="fw-bold">Distribuye la cantidad de registros por género:</small>
        </div>

        <!-- Límite total -->
        <div class="mb-3">
            <label class="form-label"><strong>Límite total (10-200):</strong></label>
            <input type="number" name="limit" id="limitTotal" value="10" min="10" max="200"
                class="form-control form-control-sm">
        </div>

        <button type="submit" class="btn btn-primary btn-sm w-100 mt-2">Exportar a PDF</button>
    </form>
</div>

<script>
    const checkboxes = document.querySelectorAll('.gender-checkbox');
    const genderCountsDiv = document.getElementById('genderCounts');
    const limitInput = document.getElementById('limitTotal');
    
    function updateGenderCounts() {
        const selected = Array.from(checkboxes).filter(cb => cb.checked);
        genderCountsDiv.innerHTML = '<small class="fw-bold">Distribuye la cantidad de registros por género:</small>';

        if (selected.length >= 2 && selected.length <= 3) {
            const limit = parseInt(limitInput.value);
            const defaultVal = Math.floor(limit / selected.length);

            selected.forEach(cb => {
                const div = document.createElement('div');
                div.classList.add('d-flex', 'align-items-center', 'mb-1', 'gap-2');

                // Tomar el texto del label que está dentro del mismo form-check
                const labelText = cb.parentElement.querySelector('label').innerText;

                const label = document.createElement('span');
                label.innerText = labelText + ':';
                label.style.minWidth = '80px';
                label.classList.add('fw-semibold');

                const input = document.createElement('input');
                input.type = 'number';
                input.name = 'gender_counts[' + cb.value + ']';
                input.value = defaultVal;
                input.min = 0;
                input.max = limit;
                input.classList.add('form-control', 'form-control-sm', 'w-auto');

                input.addEventListener('input', () => adjustCounts(selected, limit));

                div.appendChild(label);
                div.appendChild(input);
                genderCountsDiv.appendChild(div);
            });

            adjustCounts(selected, limit);
            genderCountsDiv.style.display = 'block';
        } else {
            genderCountsDiv.style.display = 'none';
        }
    }

    function adjustCounts(selected, limit) {
        const inputs = Array.from(genderCountsDiv.querySelectorAll('input'));
        let sum = inputs.reduce((acc, i) => acc + parseInt(i.value || 0), 0);
        let diff = sum - limit;

        if (diff !== 0) {
            for (let i = inputs.length - 1; i >= 0; i--) {
                let val = parseInt(inputs[i].value || 0);
                if (diff > 0) {
                    let reduce = Math.min(val, diff);
                    inputs[i].value = val - reduce;
                    diff -= reduce;
                } else if (diff < 0) {
                    let increase = -diff;
                    inputs[i].value = val + increase;
                    diff += increase;
                }
                if (diff === 0) break;
            }
        }
    }

    checkboxes.forEach(cb => cb.addEventListener('change', updateGenderCounts));
    limitInput.addEventListener('input', updateGenderCounts);
</script>