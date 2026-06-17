<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Choisir une caisse</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Choisir votre caisse</h2>
    <form method="POST" action="/caisse">
        <div class="mb-3">
            <label class="form-label">Numéro de caisse</label>
            <select name="caisse_id" class="form-select">
                <?php foreach ($caisses as $c): ?>
                    <option value="<?= $c['id'] ?>"><?= $c['numero'] ?> — <?= $c['localisation'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Valider</button>
    </form>
</div>
</body>
</html>