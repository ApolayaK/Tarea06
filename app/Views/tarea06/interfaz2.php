<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filtro Editoriales</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.0/dist/chart.umd.min.js"></script>
    <style>
        #checkbox-container {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            background-color: #f9f9f9;
            max-height: 350px;
            overflow-y: auto;
        }

        .form-check-label {
            cursor: pointer;
        }

        #btn-datos,
        #btn-pdf {
            margin-right: 10px;
            margin-top: 5px;
        }

        #checkboxes-editoriales .form-check {
            margin-bottom: 8px;
        }

        /* vertical */
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Superhéroes por Editorial</h1>

        <div class="row">
            <!-- Filtro de editoriales (izquierda) -->
            <div class="col-md-4">
                <form id="form-editoriales">
                    <h5 class="mb-2">Seleccione las editoriales</h5>
                    <div id="checkbox-container" class="mb-3" style="max-height: 300px; overflow-y:auto;">
                        <div id="checkboxes-editoriales" class="d-flex flex-column"></div>
                    </div>
                    <button type="button" id="btn-datos" class="btn btn-primary btn-sm me-2">Actualizar gráfico</button>
                    <button type="button" id="btn-pdf" class="btn btn-success btn-sm">Generar PDF</button>
                </form>
            </div>

            <!-- Gráfico circular (derecha) -->
            <div class="col-md-8 d-flex justify-content-center align-items-center">
                <div class="card p-3 shadow-sm" style="width: 100%; max-width: 400px;">
                    <canvas id="lienzo" style="max-height: 300px;"></canvas>
                </div>
            </div>
        </div>
    </div>


    <script>
        const lienzo = document.getElementById("lienzo");
        let grafico = null;

        // Inicializar gráfico circular
        function renderGraphic() {
            grafico = new Chart(lienzo, {
                type: "pie",
                data: {
                    labels: [],
                    datasets: [{
                        label: "Cantidad de superhéroes",
                        data: [],
                        backgroundColor: [
                            "#36A2EB", 
                            "#FF6384", 
                            "#FFCE56", 
                            "#4BC0C0", 
                            "#9966FF", 
                            "#FF9F40", 
                            "#FF9F70", 
                            "#8A2BE2", 
                            "#20B2AA", 
                            "#FF1493"
                        ]
                    }]
                },
                options: { responsive: true }
            });
        }

        // Cargar todas las editoriales
        async function cargarEditoriales() {
            const res = await fetch("<?= base_url('tarea06/getEditoriales') ?>");
            const data = await res.json();
            const container = document.getElementById("checkboxes-editoriales");
            container.innerHTML = "";
            data.forEach(e => {
                container.innerHTML += `
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="editorial_ids[]" value="${e.id}" id="editorial-${e.id}">
            <label class="form-check-label" for="editorial-${e.id}">${e.publisher_name}</label>
          </div>
        `;
            });
        }

        // Obtener editoriales seleccionadas
        function getSeleccionadas() {
            const formData = new FormData(document.getElementById("form-editoriales"));
            return formData.getAll("editorial_ids[]");
        }

        // Actualizar gráfico
        document.getElementById("btn-datos").addEventListener("click", async () => {
            const seleccionadas = getSeleccionadas();
            if (seleccionadas.length === 0) { alert("Selecciona al menos una editorial"); return; }

            try {
                const formData = new URLSearchParams();
                seleccionadas.forEach(id => formData.append('editorial_ids[]', id));

                const res = await fetch("<?= base_url('tarea06/getEditorialData') ?>", {
                    method: "POST",
                    body: formData
                });
                const data = await res.json();

                if (data.success) {
                    grafico.data.labels = data.resumen.map(r => r.publisher_name);
                    grafico.data.datasets[0].data = data.resumen.map(r => r.total_superheroes);
                    grafico.update();
                }
            } catch (error) { console.error("Error al obtener datos:", error); }
        });

        // Generar PDF
        document.getElementById("btn-pdf").addEventListener("click", () => {
            const seleccionadas = getSeleccionadas();
            if (seleccionadas.length === 0) { alert("Selecciona al menos una editorial"); return; }

            const form = document.createElement("form");
            form.method = "POST";
            form.action = "<?= base_url('tarea06/exportPDFEditorial') ?>";
            seleccionadas.forEach(id => {
                const input = document.createElement("input");
                input.type = "hidden";
                input.name = "editorial_ids[]";
                input.value = id;
                form.appendChild(input);
            });
            document.body.appendChild(form);
            form.submit();
        });

        document.addEventListener("DOMContentLoaded", () => {
            renderGraphic();
            cargarEditoriales();
        });
    </script>
</body>

</html>