<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title><?= isset($titulo) ? $titulo : 'Reporte de Superhéroes' ?></title>
    <style>
        /* Tamaños de pdf */
        @page {
            size: A4 landscape;
            margin: 20mm 10mm 20mm 10mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 0;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        thead {
            display: table-header-group;
        }

        /* Repetir encabezado en cada página si se rompe */
        tr {
            page-break-inside: avoid;
        }

        /* Evitar que se rompan filas */
    </style>
</head>

<body>

    <h1 style="text-align:center; margin-bottom:10px;"><?= isset($titulo) ? $titulo : 'Reporte de Superhéroes' ?></h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre de Héroe</th>
                <th>Nombre Real</th>
                <th>Raza</th>
                <th>Género</th>
                <th>Editorial</th>
                <th>Alineamiento</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($superheroes)): ?>
                <?php foreach ($superheroes as $hero): ?>
                    <tr>
                        <td><?= $hero['id'] ?? '-' ?></td>
                        <td><?= $hero['superhero_name'] ?? 'Sin nombre' ?></td>
                        <td><?= $hero['full_name'] ?? '-' ?></td>
                        <td><?= $hero['race'] ?? '-' ?></td>
                        <td><?= $hero['gender'] ?? '-' ?></td>
                        <td><?= $hero['publisher_name'] ?? '-' ?></td>
                        <td><?= $hero['alignment'] ?? '-' ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align:center;">No hay superhéroes para mostrar</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>

</html>