<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Saisie achats</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-dark bg-primary px-3">
    <span class="navbar-brand">🛒 Caisse Supermarché</span>
    <span class="text-white fw-bold">📍 <?= esc($caisse['numero']) ?></span>
    <a href="/logout" class="btn btn-outline-light btn-sm">Déconnexion</a>
</nav>

<div class="container mt-4">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <!-- Partie HAUTE : formulaire d'ajout -->
    <div class="card mb-4">
        <div class="card-header bg-secondary text-white">Ajouter un article</div>
        <div class="card-body">
            <form method="POST" action="/achats/ajouter" class="row g-3">
                <div class="col-md-7">
                    <select name="produit_id" class="form-select" required>
                        <option value="">-- Choisir un produit --</option>
                        <?php foreach ($produits as $p): ?>
                            <option value="<?= $p['id'] ?>">
                                <?= esc($p['designation']) ?> — <?= number_format($p['prix'], 0, ',', ' ') ?> Ar
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" name="quantite" min="1" value="1"
                           class="form-control" placeholder="Quantité" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success w-100">Ajouter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Partie BASSE : liste des articles -->
    <div class="card">
        <div class="card-header bg-dark text-white">Articles en cours</div>
        <div class="card-body">
            <?php if (empty($achats)): ?>
                <p class="text-muted">Aucun article pour cet achat.</p>
            <?php else: ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Produit</th>
                        <th>Qté</th>
                        <th>Prix unit.</th>
                        <th>Sous-total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($achats as $i => $a): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= esc($a['produit_id']) ?></td>
                        <td><?= $a['quantite'] ?></td>
                        <td><?= number_format($a['prix_unit'], 0, ',', ' ') ?> Ar</td>
                        <td><?= number_format($a['prix_unit'] * $a['quantite'], 0, ',', ' ') ?> Ar</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="table-dark">
                        <td colspan="4" class="text-end fw-bold">TOTAL</td>
                        <td class="fw-bold"><?= number_format($total, 0, ',', ' ') ?> Ar</td>
                    </tr>
                </tfoot>
            </table>

            <form method="POST" action="/achats/cloturer">
                <button type="submit" class="btn btn-danger">
                    ✅ Clôturer l'achat
                </button>
            </form>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>