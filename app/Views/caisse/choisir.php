<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Choisir une caisse</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background: #f0f4f8; }
        .caisse-card {
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            border: 3px solid transparent;
        }
        .caisse-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            border-color: #0d6efd;
        }
        .caisse-card.selected {
            border-color: #0d6efd;
            background: #e8f0fe;
        }
        .caisse-icon { font-size: 3rem; }
        .header-bar {
            background: linear-gradient(135deg, #0d6efd, #0056b3);
            color: white;
            padding: 20px 0;
            margin-bottom: 40px;
        }
    </style>
</head>
<body>

<!-- Header -->
<div class="header-bar text-center">
    <h2>🛒 Caisse Supermarché</h2>
    <p class="mb-0 opacity-75">Connecté en tant que <strong><?= session()->get('user') ?></strong></p>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"> Sélectionnez votre caisse</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="/caisse" id="formCaisse">
                        <div class="row g-3 mb-4">
                            <?php foreach ($caisses as $c): ?>
                            <div class="col-md-6">
                                <div class="card caisse-card p-3 text-center"
                                     onclick="selectCaisse(<?= $c['id'] ?>, this)">
                                    <div class="caisse-icon"></div>
                                    <h5 class="mt-2"><?= esc($c['numero']) ?></h5>
                                    <p class="text-muted mb-1">
                                         <?= esc($c['localisation']) ?>
                                    </p>
                                    <p class="text-success fw-bold mb-0">
                                         <?= number_format($c['montant'] ?? 0, 0, ',', ' ') ?> Ar
                                    </p>
                                    <input type="radio" name="caisse_id"
                                           value="<?= $c['id'] ?>"
                                           id="caisse_<?= $c['id'] ?>"
                                           style="display:none">
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg" id="btnValider" disabled>
                                 Ouvrir la caisse sélectionnée
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Lien déconnexion -->
            <div class="text-center mt-3">
                <a href="/logout" class="text-muted text-decoration-none">
                     Se déconnecter
                </a>
            </div>

        </div>
    </div>
</div>

<script>
function selectCaisse(id, card) {
    // Retirer la sélection précédente
    document.querySelectorAll('.caisse-card').forEach(c => c.classList.remove('selected'));
    // Sélectionner la carte cliquée
    card.classList.add('selected');
    // Cocher le radio
    document.getElementById('caisse_' + id).checked = true;
    // Activer le bouton
    document.getElementById('btnValider').disabled = false;
}
</script>

</body>
</html>