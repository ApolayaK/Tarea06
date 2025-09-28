<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Informe 4 - Superhéroes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.0/dist/chart.umd.min.js"></script>
  <style>
    body {
      background-color: #f8f9fa;
      font-family: "Segoe UI", Roboto, sans-serif;
    }

    .header-section {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      margin-bottom: 40px;
    }

    .header-section h1 {
      margin: 0;
      font-weight: 700;
      font-size: 2.5rem;
      color: #343a40;
    }

    .header-section button {
      background-color: #007bff;
      color: #fff;
      border: none;
      padding: 10px 20px;
      font-size: 1rem;
    }

    .chart-container {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center;
      align-items: flex-start;
      margin-bottom: 40px;
    }

    .chart-box {
      flex: 1 1 300px;
      max-width: 500px;
      background: #fff;
      padding: 15px;
      border-radius: 10px;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.05);
    }

    canvas {
      max-width: 100%;
      height: 300px;
    }

    table {
      width: 100%;
      margin-top: 10px;
      border-collapse: collapse;
      transition: all 0.5s ease-in-out;
      opacity: 0;
      transform: translateY(20px);
    }

    table.show {
      opacity: 1;
      transform: translateY(0);
    }

    table th,
    table td {
      padding: 8px 12px;
      text-align: center;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header-section">
      <h1>Informe 4 - Superhéroes</h1>
      <button class="btn btn-primary" id="obtener-datos">Cargar Datos</button>
    </div>

    <!-- Gráfico y tabla Gender -->
    <div class="chart-container">
      <div class="chart-box">
        <h5 class="text-center">Superhéroes por Género</h5>
        <canvas id="lienzo"></canvas>
      </div>
      <div class="chart-box">
        <table class="table table-bordered table-striped" id="tabla-gender">
          <thead class="table-light">
            <tr>
              <th>Género</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>

    <!-- Gráfico y tabla Publisher -->
    <div class="chart-container">
      <div class="chart-box">
        <h5 class="text-center">Superhéroes por Publisher</h5>
        <canvas id="lienzo2"></canvas>
      </div>
      <div class="chart-box">
        <table class="table table-bordered table-striped" id="tabla-publisher">
          <thead class="table-light">
            <tr>
              <th>Publisher</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const lienzo = document.getElementById("lienzo");
      const lienzo2 = document.getElementById("lienzo2");
      const btnDatos = document.getElementById("obtener-datos");
      const tablaGender = document.getElementById("tabla-gender");
      const tablaPublisher = document.getElementById("tabla-publisher");

      let grafico = null;
      let grafico2 = null;

      function renderGraphic() {
        // Destruir gráficos anteriores si existen
        if (grafico) grafico.destroy();
        if (grafico2) grafico2.destroy();

        // Gráfico 1 - Pie suave (Gender)
        grafico = new Chart(lienzo, {
          type: 'pie',
          data: {
            labels: [],
            datasets: [{
              data: [],
              backgroundColor: ['#6c757d', '#17a2b8', '#ffc107', '#28a745', '#fd7e14'],
              borderColor: '#fff',
              borderWidth: 2
            }]
          },
          options: {
            responsive: true,
            plugins: { legend: { position: 'top' }, tooltip: { enabled: true } }
          }
        });

        // Gráfico 2 - Horizontal (Publisher)
        grafico2 = new Chart(lienzo2, {
          type: 'bar',
          data: { labels: [], datasets: [{ label: 'Cantidad de Superhéroes', data: [], backgroundColor: ['#6c757d', '#17a2b8', '#ffc107', '#28a745', '#fd7e14'], borderColor: '#fff', borderWidth: 2 }] },
          options: {
            indexAxis: 'y',
            responsive: true,
            plugins: { legend: { display: false }, title: { display: true, text: 'Cantidad de Superhéroes por Publisher' } },
            scales: {
              x: { beginAtZero: true, title: { display: true, text: 'Total de Superhéroes' } },
              y: { title: { display: true, text: 'Publisher' } }
            }
          }
        });
      }

      async function cargarDatos() {
        try {
          renderGraphic(); // reinicia los gráficos cada vez que se carga

          const responseGender = await fetch('<?= base_url() ?>/public/api/getdatainforme4cache');
          const dataGender = await responseGender.json();

          const responsePublisher = await fetch('<?= base_url() ?>/public/api/getdatainformepublishercache');
          const dataPublisher = await responsePublisher.json();

          // Pie (Gender)
          if (dataGender.success) {
            grafico.data.labels = dataGender.resumen.map(r => r.gender);
            grafico.data.datasets[0].data = dataGender.resumen.map(r => r.total);
            grafico.update();

            const tbody = tablaGender.querySelector("tbody");
            tbody.innerHTML = "";
            dataGender.resumen.forEach(r => {
              tbody.innerHTML += `<tr><td>${r.gender}</td><td>${r.total}</td></tr>`;
            });
            tablaGender.classList.add("show");
          }

          // Horizontal Bar (Publisher)
          if (dataPublisher.success) {
            grafico2.data.labels = dataPublisher.resumen.map(r => r.publisher);
            grafico2.data.datasets[0].data = dataPublisher.resumen.map(r => r.total);
            grafico2.update();

            const tbody = tablaPublisher.querySelector("tbody");
            tbody.innerHTML = "";
            dataPublisher.resumen.forEach(r => {
              tbody.innerHTML += `<tr><td>${r.publisher}</td><td>${r.total}</td></tr>`;
            });
            tablaPublisher.classList.add("show");
          }
        } catch (error) {
          console.error("Error al cargar los datos:", error);
        }
      }

      cargarDatos(); // carga automática al abrir
      btnDatos.addEventListener("click", cargarDatos); // refresca al presionar
    });
  </script>
</body>

</html>