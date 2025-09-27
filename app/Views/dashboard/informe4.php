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
    <button class="btn btn-outline-primary my-4" id="obtener-datos" type="button">
      Obtener datos
    </button>
    <canvas id="lienzo"></canvas>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.0/dist/chart.umd.min.js"></script>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const lienzo = document.getElementById("lienzo");
      const lienzo2 = document.getElementById("lienzo2");
      const btnDatos = document.getElementById("obtener-datos");
      let grafico = null;
      let grafico2 = null;

      function renderGraphic() {
        grafico = new Chart(lienzo, {
          type: 'pie',
          data: {
            labels: [],
            datasets: [
              {
                label: '',
                data: [],
                backgroundColor: [
                  'rgba(255, 99, 132, 0.7)',  // Rojo rosado
                  'rgba(54, 162, 235, 0.7)',  // Azul
                  'rgba(255, 206, 86, 0.7)'   // Amarillo
                ],
                borderColor: 'white',
                borderWidth: 2,
              }
            ]
          },
          options: {
            responsive: true,
            plugins: {
              legend: {
                display: true,
                position: 'top'
              }
            }
          }
        });

        grafico2 = new Chart(lienzo2, {
          type: 'pie',
          data: {
            labels: [],
            datasets: [
              {
                label: '',
                data: [],
                backgroundColor: [
                  'rgba(255, 99, 132, 0.7)',  // id = 4
                  'rgba(54, 162, 235, 0.7)',  // id = 13
                  'rgba(255, 206, 86, 0.7)',  // id = 3
                  'rgba(155, 89, 182, 0.7)',  // id = 5
                  'rgba(149, 165, 166,0.7)'   // id = 10
                ],
                borderColor: 'white',
                borderWidth: 2,
              }
            ]
          },
          options: {
            responsive: true,
            plugins: {
              legend: {
                display: true,
                position: 'top'
              }
            }
          }
        });


      }

      btnDatos.addEventListener("click", async () => {
        try {
          // Fetch para género
          const responseGender = await fetch('<?= base_url() ?>/public/api/getdatainforme4cache', { method: 'GET' });
          if (!responseGender.ok) throw new Error('No se pudo conectar al servicio de género');
          const dataGender = await responseGender.json();

          // Fetch para publishers
          const responsePublisher = await fetch('<?= base_url() ?>/public/api/getdatainformepublishercache', { method: 'GET' });
          if (!responsePublisher.ok) throw new Error('No se pudo conectar al servicio de publishers');
          const dataPublisher = await responsePublisher.json();

          if (dataGender.success) {
            grafico.data.labels = dataGender.resumen.map(row => row.gender);
            grafico.data.datasets[0].data = dataGender.resumen.map(row => row.total);
            grafico.data.datasets[0].label = dataGender.message;
            grafico.update();
          }

          if (dataPublisher.success) {
            grafico2.data.labels = dataPublisher.resumen.map(row => row.publisher);
            grafico2.data.datasets[0].data = dataPublisher.resumen.map(row => row.total);
            grafico2.data.datasets[0].label = dataPublisher.message;
            grafico2.update();
          }

        } catch (error) {
          console.error(error);
        }
      });


      renderGraphic();
    });
  </script>
</body>

</html>