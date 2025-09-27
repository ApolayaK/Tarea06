<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Informe 4</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
</head>

<body>
  <div class="container">
    <h2 class="my-4">Informe 4 - Superhéroes</h2>
    <button class="btn btn-outline-primary mb-4" id="obtener-datos">Cargar Datos</button>

    <!-- Gráfico 1: por género -->
    <h4>Superhéroes por Género</h4>
    <canvas id="lienzo"></canvas>

    <!-- Gráfico 2: por publisher -->
    <h4 class="mt-4">Superhéroes por Publisher</h4>
    <canvas id="lienzo2"></canvas>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.0/dist/chart.umd.min.js"></script>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const lienzo = document.getElementById("lienzo");
      const lienzo2 = document.getElementById("lienzo2");
      const btnDatos = document.getElementById("obtener-datos");
      let grafico = null;
      let grafico2 = null;

      // Inicialización de gráficos vacíos
      function renderGraphic() {
        // Gráfico 1 - Pastel (Gender)
        grafico = new Chart(lienzo, {
          type: 'pie',
          data: { labels: [], datasets: [{ label: '', data: [], backgroundColor: ['rgba(255,99,132,0.7)','rgba(54,162,235,0.7)','rgba(255,206,86,0.7)'], borderColor:'white', borderWidth:2 }] },
          options: { responsive:true, plugins:{ legend:{ position:'top' } } }
        });

        // Gráfico 2 - Barras (Publisher)
        grafico2 = new Chart(lienzo2, {
          type: 'bar',
          data: { labels: [], datasets: [{ label: 'Cantidad de Superhéroes', data: [], backgroundColor:['rgba(255,99,132,0.7)','rgba(54,162,235,0.7)','rgba(255,206,86,0.7)','rgba(155,89,182,0.7)','rgba(149,165,166,0.7)'], borderColor:'white', borderWidth:2 }] },
          options: {
            responsive: true,
            plugins: { 
              legend: { display: false },
              title: { display: true, text: 'Cantidad de Superhéroes por Publisher' }
            },
            scales: {
              y: { beginAtZero:true, title:{ display:true, text:'Total de Superhéroes' } },
              x: { title:{ display:true, text:'Publisher' } }
            }
          }
        });
      }

      btnDatos.addEventListener("click", async () => {
        try {
          // Fetch para Gender
          const responseGender = await fetch('<?= base_url() ?>/public/api/getdatainforme4cache');
          const dataGender = await responseGender.json();

          // Fetch para Publisher
          const responsePublisher = await fetch('<?= base_url() ?>/public/api/getdatainformepublishercache');
          const dataPublisher = await responsePublisher.json();

          // Actualizar gráfico 1
          if (dataGender.success) {
            grafico.data.labels = dataGender.resumen.map(r => r.gender);
            grafico.data.datasets[0].data = dataGender.resumen.map(r => r.total);
            grafico.update();
          }

          // Actualizar gráfico 2
          if (dataPublisher.success) {
            grafico2.data.labels = dataPublisher.resumen.map(r => r.publisher); // usar 'publisher' desde el modelo
            grafico2.data.datasets[0].data = dataPublisher.resumen.map(r => r.total); // usar 'total' desde el modelo
            grafico2.update();
          }

        } catch (error) {
          console.error("Error al cargar los datos:", error);
        }
      });

      renderGraphic();
    });
  </script>
</body>
</html>
