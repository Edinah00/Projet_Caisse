<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ticket de caisse</title>
    <link rel="stylesheet" 
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background: #f0f0f0; }
        .ticket {
            max-width: 400px;
            margin: 30px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .ticket h4 { text-align: center; border-bottom: 2px dashed #333; padding-bottom: 10px; }
        .ticket .total { border-top: 2px dashed #333; padding-top: 10px; font-weight: bold; }
        .ticket .footer { text-align: center; font-size: 0.85rem; color: #888; margin-top: 15px; }
    </style>
</head>
<body>

<div class="ticket">
    <h4>🛒 CAISSE SUPERMARCHÉ</h4>

    <p class="mb-1">📍 <?= esc($ticket['caisse']) ?></p>
    <p class="mb-1">📅 <?= esc($ticket['date']) ?></p>
    <p class="mb-3">🔖 N° <?= esc($ticket['numero']) ?></p>

    <table class="table table-sm">
        <thead>
            <tr>
                <th>Article</th>
                <th class="text-center">Qté</th>
                <th class="text-end">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ticket['lignes'] as $ligne): ?>
            <tr>
                <td>
                    <?= esc($ligne['designation']) ?><br>
                    <small class="text-muted">
                        <?= number_format($ligne['prix_unit'], 0, ',', ' ') ?> Ar × <?= $ligne['quantite'] ?>
                    </small>
                </td>
                <td class="text-center"><?= $ligne['quantite'] ?></td>
                <td class="text-end">
                    <?= number_format($ligne['sous_total'], 0, ',', ' ') ?> Ar
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="total d-flex justify-content-between">
        <span>TOTAL</span>
        <span><?= number_format($ticket['total'], 0, ',', ' ') ?> Ar</span>
    </div>

    <div class="footer">
        <p>Merci pour votre achat !<br>À bientôt 😊</p>
    </div>
</div>

<!-- Boutons -->
<div class="text-center mt-3">
    <button onclick="window.print()" class="btn btn-secondary">
        🖨️ Imprimer
    </button>
    <a href="/achats" class="btn btn-primary ms-2">
        ➕ Nouvel achat
    </a>
</div>

</body>
</html>