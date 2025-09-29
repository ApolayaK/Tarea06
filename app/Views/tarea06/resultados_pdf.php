<style>
body { font-family: Arial, sans-serif; color:#2c3e50; }
table { border-collapse: collapse; width: 100%; }
th, td { border: 1px solid #bdc3c7; padding: 8px; text-align: left; }
th { background-color: #34495e; color: white; }
tr:nth-child(even) { background-color:#ecf0f1; }
h2 { text-align:center; color:#2c3e50; }
</style>

<h2><?= $titulo ?></h2>

<table>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Nombre Real</th>
        <th>Raza</th>
        <th>Género</th>
    </tr>
    <?php if(!empty($superheroes)): ?>
        <?php foreach($superheroes as $hero): ?>
            <tr>
                <td><?= $hero['id'] ?></td>
                <td><?= $hero['superhero_name'] ?></td>
                <td><?= $hero['full_name'] ?></td>
                <td><?= $hero['race'] ?></td>
                <td><?= $hero['gender'] ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="5" style="text-align:center;">No se encontraron superhéroes.</td>
        </tr>
    <?php endif; ?>
</table>
