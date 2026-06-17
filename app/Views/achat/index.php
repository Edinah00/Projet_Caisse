<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Achats — <?= esc($caisse['numero']) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background: #f0f4f8; }
        .navbar { box-shadow: 0 2px 8px rgba(0,0,0,0.2); }
        .badge-caisse {
            background: rgba(255,255,255,0.2);
            border-radius: 20px;
            padding: 5px 15px;
            font-size: 0.9rem;
        }
        .card { border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .table thead { background: #343a40; color: white; }
        .total-row { background: #212529; color: white; font-size: 1.1rem; }
        .stock-badge {
            font-size: 0.75rem;
            padding: 2px 8px;
        }
        .empty-state {
            text-align: center;
            padding: 40px;
            color: #aaa;
        }
        .empty-state .icon { font-size: 4rem; }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-dark bg-primary px-4">
    <span class="navbar-brand fw-bold">🛒 Caisse Supermarché</span>

    <div class="d-flex align-items-center gap-3">
        <span class="badge-caisse text-white">
            <?= esc($caisse['numero']) ?>
            &nbsp;|&nbsp;
            <?= number_format($caisse['montant'] ?? 0, 0, ',', ' ') ?> Ar
        </span>
        <a href="/caisse" class="btn btn-warning btn-sm">Changer</a>
        <a href="/historique" class="btn btn-outline-light btn-sm">Historique</a>
        <a href="/logout" class="btn btn-outline-light btn-sm"> Quitter</a>
    </div>
</nav>

<div class="container mt-4">

    <!-- ALERTES -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
             <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
             <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row g-4">

        <!-- COLONNE GAUCHE : formulaire ajout -->
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header bg-secondary text-white fw-bold">
                    + Ajouter un article
                </div>
                <div class="card-body">
                    <form method="POST" action="/achats/ajouter">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Produit</label>
                            <select name="produit_id" class="form-select" required
                                    onchange="updatePrix(this)">
                                <option value="">-- Choisir --</option>
                                <?php foreach ($produits as $p): ?>
                                    <option value="<?= $p['id'] ?>"
                                            data-prix="<?= $p['prix'] ?>"
                                            data-stock="<?= $p['quantite_stock'] ?>"
                                            <?= $p['quantite_stock'] == 0 ? 'disabled' : '' ?>>
                                        <?= esc($p['designation']) ?>
                                        (<?= $p['quantite_stock'] ?> en stock)
                                        <?= $p['quantite_stock'] == 0 ? '— Rupture' : '' ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Info prix & stock -->
                        <div class="mb-3 p-2 bg-light rounded" id="infoProduit" style="display:none">
                            <small>
                                 Prix : <strong id="affPrix">—</strong> Ar<br>
                                 Stock : <strong id="affStock">—</strong> unité(s)
                            </small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Quantité</label>
                            <input type="number" name="quantite" id="inputQte"
                                   min="1" value="1"
                                   class="form-control" required>
                        </div>

                        <!-- Sous-total calculé -->
                        <div class="mb-3 p-2 bg-primary text-white rounded text-center"
                             id="sousTotal" style="display:none">
                            Sous-total : <strong id="affSousTotal">0</strong> Ar
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">
                                ➕ Ajouter
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- COLONNE DROITE : liste achats -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-dark text-white fw-bold d-flex justify-content-between">
                    <span> Articles en cours</span>
                    <span class="badge bg-secondary"><?= count($achats) ?> article(s)</span>
                </div>
                <div class="card-body p-0">

                    <?php if (empty($achats)): ?>
                        <div class="empty-state">
                            <div class="icon"></div>
                            <p>Aucun article pour cet achat.</p>
                            <small>Utilisez le formulaire pour ajouter des articles.</small>
                        </div>
                    <?php else: ?>
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Article</th>
                                    <th class="text-center">Qté</th>
                                    <th class="text-end">Prix unit.</th>
                                    <th class="text-end">Sous-total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($achats as $i => $a): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= esc($a['designation'] ?? 'Produit #'.$a['produit_id']) ?></td>
                                    <td class="text-center">
                                        <span class="badge bg-primary"><?= $a['quantite'] ?></span>
                                    </td>
                                    <td class="text-end">
                                        <?= number_format($a['prix_unit'], 0, ',', ' ') ?> Ar
                                    </td>
                                    <td class="text-end fw-semibold">
                                        <?= number_format($a['prix_unit'] * $a['quantite'], 0, ',', ' ') ?> Ar
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr class="total-row">
                                    <td colspan="4" class="text-end fw-bold px-3">TOTAL</td>
                                    <td class="text-end fw-bold px-3">
                                        <?= number_format($total, 0, ',', ' ') ?> Ar
                                    </td>
                                </tr>
                            </tfoot>
                        </table>

                        <!-- Bouton clôturer -->
                        <div class="p-3 text-end">
                            <form method="POST" action="/achats/cloturer"
                                  onsubmit="return confirm('Confirmer la clôture de cet achat ?')">
                                <button type="submit" class="btn btn-danger btn-lg">
                                    Clôturer l'achat
                                </button>
                            </form>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function updatePrix(select) {
    const option = select.options[select.selectedIndex];
    const prix   = option.dataset.prix;
    const stock  = option.dataset.stock;

    if (prix) {
        document.getElementById('affPrix').textContent  = parseInt(prix).toLocaleString('fr-FR');
        document.getElementById('affStock').textContent = stock;
        document.getElementById('infoProduit').style.display = 'block';
        document.getElementById('inputQte').max = stock;
        calculerSousTotal(prix);
        document.getElementById('sousTotal').style.display = 'block';
    }
}

function calculerSousTotal(prix) {
    const qte      = document.getElementById('inputQte').value;
    const sousTotal = parseInt(prix) * parseInt(qte);
    document.getElementById('affSousTotal').textContent = sousTotal.toLocaleString('fr-FR');
}

document.getElementById('inputQte').addEventListener('input', function() {
    const select = document.querySelector('select[name="produit_id"]');
    const prix   = select.options[select.selectedIndex].dataset.prix;
    if (prix) calculerSousTotal(prix);
});
</script>

</body>
</html>