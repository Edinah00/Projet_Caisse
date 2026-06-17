<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion – Caisse</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h4>🛒 Caisse Supermarché</h4>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                    <?php endif; ?>
                    <form method="POST" action="/login">
                        <div class="mb-3">
                            <label>Utilisateur</label>
                            <input type="text" name="username" class="form-control" value="admin" required>
                        </div>
                        <div class="mb-3">
                            <label>Mot de passe</label>
                            <input type="password" name="password" class="form-control" value="admin123" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Se connecter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>