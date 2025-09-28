<h2 style="color:#2c3e50;">Exportar Superhéroes a PDF</h2>

<form action="<?= base_url('tarea06/exportPDF') ?>" method="POST" style="background-color:#ecf0f1;padding:20px;border-radius:10px;width:400px;">
    <label><strong>Título:</strong></label>
    <input type="text" name="titulo" value="Reporte 01" required style="width:100%;padding:5px;margin-bottom:10px;"><br>

    <label><strong>Género:</strong></label><br>
    <?php foreach($genders as $gender): ?>
        <input type="checkbox" name="gender_ids[]" value="<?= $gender['id'] ?>"> <?= $gender['gender'] ?><br>
    <?php endforeach; ?>
    <br>

    <label><strong>Límite de resultados (10-200):</strong></label>
    <input type="number" name="limit" value="10" min="10" max="200" style="width:100%;padding:5px;margin-bottom:10px;"><br>

    <button type="submit" style="background-color:#2980b9;color:white;padding:10px 20px;border:none;border-radius:5px;cursor:pointer;">Exportar a PDF</button>
</form>
