<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Informe 2</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</head>

<body>

  <div class="container my-4">
    <button class="btn btn-outline-primary mb-4" id="obtener-datos" type="button">Obtener datos</button>
    <span id="aviso" class="d-none">Por favor espere...</span>
    <canvas id="lienzo" width="600" height="300"></canvas>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.0/dist/chart.umd.min.js"></script>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const lienzo = document.getElementById("lienzo");
      const btnDatos = document.getElementById("obtener-datos");
      const aviso = document.getElementById("aviso");
      let grafico = null;

      function renderGraphic() {
        const backgroundColor = [
          'rgba(52, 73, 94, 0.5)',
          'rgba(41, 128, 185, 0.5)',
          'rgba(192, 57, 43, 0.5)',
          'rgba(149, 165, 166, 0.5)',
          'rgba(189, 195, 199, 0.5)'
        ];

        const borderColor = [
          'rgba(52, 73, 94, 1.0)',
          'rgba(41, 128, 185, 1.0)',
          'rgba(192, 57, 43, 1.0)',
          'rgba(149, 165, 166, 1.0)',
          'rgba(189, 195, 199, 1.0)'
        ];

        const borderWidth = 2;

        const options = {
          responsive: true,
          scales: {
            y: { beginAtZero: true }
          }
        };

        grafico = new Chart(lienzo, {
          type: 'bar',
          data: {
            labels: [],
            datasets: [
              {
                label: 'Popularidad de Superhéroes',
                data: [],
                backgroundColor: backgroundColor,
                borderColor: borderColor,
                borderWidth: borderWidth
              }
            ]
          },
          options
        });
      }

      btnDatos.addEventListener("click", async () => {
        try {
          aviso.classList.remove("d-none");
          btnDatos.disabled = true;

          const response = await fetch('http://superhero.test/public/api/getdatainforme2', {
            method: 'GET'
          });

          if (!response.ok) {
            throw new Error('No se pudo lograr comunicación con el servidor.');
          }

          const data = await response.json();
          console.log(data); // Verifica la estructura

          if (data.success) {
            grafico.data.labels = data.resumen.map(row => row.superhero);
            grafico.data.datasets[0].data = data.resumen.map(row => row.popularidad);
            grafico.update();
          } else {
            console.warn("La respuesta no contiene datos válidos.");
          }

        } catch (error) {
          console.error("Error al obtener los datos:", error);
        } finally {
          aviso.classList.add("d-none");
          btnDatos.disabled = false;
        }
      });

      renderGraphic();

      // SOLO ES PRACTICA
      // Practicando MAP
      const amigos = [
        { nombre: 'Betty', edad: 51, ciudad: 'Lima' },
        { nombre: 'Umita', edad: 16, ciudad: 'Lima' },
        { nombre: 'Oscar', edad: 19, ciudad: 'Lima' },
        { nombre: 'Lavi', edad: 35, ciudad: 'Arequipa' },
        { nombre: 'Anthony', edad: 20, ciudad: 'Lima' }
      ];

      let nombres = [];
      amigos.forEach(element => {
        nombres.push(element.nombre);
      });

      const edades = amigos.map(row => row.edad);
      const ciudades = amigos.map(row => row.ciudad);

      console.log(amigos);
      console.log(nombres);
      console.log(edades);
      console.log(ciudades);
    });
  </script>
</body>

</html>
