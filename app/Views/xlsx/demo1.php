<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <button type="button" id="exportar">Exportar</button>
  <table id="tabla-datos">
    <thead>
      <tr>
        <th>#</th>
        <th>Apellidos</th>
        <th>Nombres</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>1</td>
        <td>Cárdenas</td>
        <td>Luis</td>
      </tr>
      <tr>
        <td>2</td>
        <td>Pachas</td>
        <td>José</td>
      </tr>
      <tr>
        <td>3</td>
        <td>Martinez</td>
        <td>Carlos</td>
      </tr>
    </tbody>
  </table>


  <script type="text/javascript" src="https://cdn.sheetjs.com/xlsx-0.20.3/package/dist/xlsx.full.min.js"></script>

  <script>
    document.addEventListener("DOMContentLoaded", () => {

      btn.addEventListener("click", () => {
        //Referencia a la fuente de datos TABLA HTML
        const tabla = document.getElementById('tabla-datos')
        //Crear un WorkBook (Libro de trabajo) > Hoja > Tabla
        const workBook = XLSX.utils.table_to_book(tabla, { sheet: 'Contactos' })
        //Contruir + habilita la descarga
        XLSX.writeFile(workBook, "Reporte.xlsx");
      })

    })
  </script>
</body>

</html>