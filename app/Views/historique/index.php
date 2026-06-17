<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Historique des achats</title>
    <link rel="stylesheet" 
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background: #f0f4f8; }
        .navbar { box-shadow: 0 2px 8px rgba(0,0,0,0.2); }
        .stat-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        .stat-icon { font-size: 2.5rem; }
        .ticket-header {
            cursor: pointer;
            background: #f8f9fa;
            transition: background 0.2s;
        }
        .ticket-header:hover { background: #e9ecef; }
        .caisse-badge {
            font-size: 0.8rem;
            padding: 3px 10px;
            border-radius: 20px;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-dark bg-dark px-4">
    <span class="navbar-brand fw-bold">🛒 Caisse Supermarché — Historique</span>
    <div class="d-flex gap-2">
        <a href="/achats" class="btn btn-outline-light btn-sm"> Caisse</a>
        <a href="/logout" class="btn btn-outline-danger btn-sm"> Quitter</a>
    </div>
</nav>

<div class="container mt-4">

    <!-- STATS GLOBALES -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card stat-card text-center p-3">
                <div class="stat-icon"></div>
                <h4 class="mt-2"><?= $stats['nb_tickets'] ?></h4>
                <p class="text-muted mb-0">Tickets émis</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card text-center p-3">
                <div class="stat-icon"></div>
                <h4 class="mt-2"><?= $stats['nb_articles'] ?></h4>
                <p class="text-muted mb-0">Articles vendus</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card text-center p-3 bg-success text-white">
                <div class="stat-icon"></div>
                <h4 class="mt-2">
                    <?= number_format($stats['total_ventes'], 0, ',', ' ') ?> Ar
                </h4>
                <p class="mb-0 opacity-75">Total des ventes</p>
            </div>
        </div>
    </div>

    <!-- SOLDE PAR CAISSE -->
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-header bg-primary text-white fw-bold">
            Solde actuel par caisse
        </div>
        <div class="card-body">
            <div class="row g-3">
                <?php foreach ($caisses as $c): ?>
                <div class="col-md-6">
                    <div class="d-flex justify-content-between align-items-center
                                p-3 bg-light rounded">
                        <div>
                            <strong> <?= esc($c['numero']) ?></strong><br>
                            <small class="text-muted"><?= esc($c['localisation']) ?></small>
                        </div>
                        <span class="fs-5 fw-bold text-success">
                            <?= number_format($c['montant'] ?? 0, 0, ',', ' ') ?> Ar
                        </span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- LISTE DES TICKETS -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-dark text-white fw-bold d-flex justify-content-between">
            <span> Tickets d'achat</span>
            <span class="badge bg-secondary"><?= count($tickets) ?> ticket(s)</span>
        </div>
        <div class="card-body p-0">

            <?php if (empty($tickets)): ?>
                <div class="text-center p-5 text-muted">
                    <div style="font-size:3rem"></div>
                    <p>Aucun achat clôturé pour le moment.</p>
                </div>
            <?php else: ?>

            <div class="accordion" id="accordionTickets">
                <?php $i = 1; foreach ($tickets as $cle => $ticket): ?>
                <div class="accordion-item border-0 border-bottom">

                    <!-- En-tête ticket -->
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed ticket-header"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#ticket_<?= $i ?>">
                            <div class="d-flex justify-content-between w-100 pe-3">
                                <div>
                                    <span class="badge bg-primary caisse-badge me-2">
                                         <?= esc($ticket['caisse']) ?>
                                    </span>
                                    <strong>Ticket #<?= str_pad($i, 4, '0', STR_PAD_LEFT) ?></strong>
                                    <small class="text-muted ms-2">
                                         <?= date('d/m/Y H:i', strtotime($ticket['date'])) ?>
                                    </small>
                                </div>
                                <span class="text-success fw-bold">
                                    <?= number_format($ticket['total'], 0, ',', ' ') ?> Ar
                                </span>
                            </div>
                        </button>
                    </h2>

                    <!-- Détail ticket -->
                    <div id="ticket_<?= $i ?>" 
                         class="accordion-collapse collapse"
                         data-bs-parent="#accordionTickets">
                        <div class="accordion-body p-0">
                            <table class="table table-sm table-hover mb-0">
                                <thead class="table-secondary">
                                    <tr>
                                        <th>Article</th>
                                        <th class="text-center">Qté</th>
                                        <th class="text-end">Prix unit.</th>
                                        <th class="text-end">Sous-total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($ticket['lignes'] as $ligne): ?>
                                    <tr>
                                        <td><?= esc($ligne['designation']) ?></td>
                                        <td class="text-center">
                                            <span class="badge bg-primary">
                                                <?= $ligne['quantite'] ?>
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <?= number_format($ligne['prix_unit'], 0, ',', ' ') ?> Ar
                                        </td>
                                        <td class="text-end fw-semibold">
                                            <?= number_format(
                                                $ligne['prix_unit'] * $ligne['quantite'],
                                                0, ',', ' '
                                            ) ?> Ar
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr class="table-dark">
                                        <td colspan="3" class="text-end fw-bold">TOTAL</td>
                                        <td class="text-end fw-bold">
                                            <?= number_format($ticket['total'], 0, ',', ' ') ?> Ar
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                </div>
                <?php $i++; endforeach; ?>
            </div>

            <?php endif; ?>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>