<?php
namespace App\Controllers;
use App\Models\AchatModel;
use App\Models\CaisseModel;

class HistoriqueController extends BaseController
{
    public function index()
    {
        if (!session()->get('user')) return redirect()->to('/');

        $db = \Config\Database::connect();

        // Récupérer tous les achats terminés avec le nom du produit et la caisse
        $achats = $db->table('achat a')
            ->select('a.*, p.designation, p.prix as prix_actuel, c.numero as caisse_numero, a.created_at')
            ->join('produit p', 'p.id = a.produit_id')
            ->join('caisse c',  'c.id = a.caisse_id')
            ->where('a.statut', 'termine')
            ->orderBy('a.created_at', 'DESC')
            ->get()
            ->getResultArray();

        // Grouper par date + caisse (simulation numéro de ticket)
        $tickets = [];
        foreach ($achats as $achat) {
            // Clé unique = caisse + date tronquée à la minute
            $cle = $achat['caisse_numero'] . '_' . substr($achat['created_at'], 0, 16);
            $tickets[$cle]['caisse']    = $achat['caisse_numero'];
            $tickets[$cle]['date']      = $achat['created_at'];
            $tickets[$cle]['lignes'][]  = $achat;
            $tickets[$cle]['total']     = ($tickets[$cle]['total'] ?? 0)
                                        + ($achat['prix_unit'] * $achat['quantite']);
        }

        // Stats globales
        $stats = [
            'total_ventes'   => array_sum(array_column($tickets, 'total')),
            'nb_tickets'     => count($tickets),
            'nb_articles'    => count($achats),
        ];

        // Solde par caisse
        $caisses = (new CaisseModel())->findAll();

        return view('historique/index', compact('tickets', 'stats', 'caisses'));
    }
}