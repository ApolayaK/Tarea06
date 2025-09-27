<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Informe 3</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
</head>

<body>
  <div class="container">
    <button class="btn btn-outline-primary" id="obtener-datos" type="button">
      Obtener datos
    </button>
    <canvas id="lienzo"></canvas>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.0/dist/chart.umd.min.js"></script>

  <script>
    document.addEventListener("DOMContentLoaded", () =>{
      const lienzo = document.getElementById("lienzo")
    const btnDatos = document.getElementById("obtener-datos")
    let grafico = null

    function renderGraphic() {
      grafico = new Chart(lienzo, {
        type: 'bar',
        data: {
          labels: [],
          datasets: [
            {
              label: '',
              data: []
            }
          ]
        }
      })
    }

    btnDatos.addEventListener("click", async () => {
      try {
        const response = await fetch('<?=base_url()?>/public/api/getdatainforme3cache', { method: 'GET' })
        if (!response.ok) {
          throw new Error('No se pudo conectar al servicio')
        }

        const data = await response.json()
        if (data.success) {
          grafico.data.labels = data.resumen.map(row => row.alignment)
          grafico.data.datasets[0].data = data.resumen.map(row => row.total)
          grafico.data.datasets[0].label = data.message
          grafico.update()
        }

      } catch (error) {
        console.error(error)
      }
    });

    renderGraphic()
    });
    
  </script>
</body>

</html>