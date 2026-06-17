<?php 
namespace App\Controllers;
use App\Models\AchatModel;
use App\Models\ProduitModel;
use App\Models\CaisseModel;

class AchatController extends BaseController
{
    public function index()
    {
        if (!session()->get('caisse')) return redirect()->to('/caisse');

        $caisse = session()->get('caisse');
        $produits = (new ProduitModel())->findAll();
        $achats = (new AchatModel())
        ->where('caisse_id', $caisse['id'])
        ->where('statut', 'en_cours')
        ->findAll();

        $total =array_sum(array_map(fn($a)=> $a['prix_unit']*$a['quantite'], $achats));
        return view('achat/index', [
            'caisse' => $caisse,
            'produits' => $produits,
            'achats' => $achats,
            'total' => $total
        ]);

    }

    public function ajouter()
    {
        $caisse     = session()->get('caisse');
        $produit_id = $this->request->getPost('produit_id');
        $quantite   = (int) $this->request->getPost('quantite');

        $produit = (new ProduitModel())->find($produit_id);

        if ($produit['quantite_stock'] < $quantite) {
            return redirect()->to('/achats')
                            ->with('error', 
                            "Stock insuffisant ! Disponible : {$produit['quantite_stock']} unité(s)."
                            );
        }

        (new AchatModel())->insert([
            'caisse_id'  => $caisse['id'],
            'produit_id' => $produit_id,
            'quantite'   => $quantite,
            'prix_unit'  => $produit['prix'],
            'statut'     => 'en_cours',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/achats')
                        ->with('success', 'Article ajouté !');
    }

    public function cloturer()
    {
        $caisse       = session()->get('caisse');
        $achatModel   = new AchatModel();
        $produitModel = new ProduitModel();
        $caisseModel  = new CaisseModel();

        $achats = $achatModel
            ->where('caisse_id', $caisse['id'])
            ->where('statut', 'en_cours')
            ->findAll();

        if (empty($achats)) {
            return redirect()->to('/achats')
                            ->with('error', 'Aucun achat en cours.');
        }

        $lignesTicket = [];
        $totalAchat   = 0;

        foreach ($achats as $achat) {
            $produit = $produitModel->find($achat['produit_id']);

            if ($produit['quantite_stock'] < $achat['quantite']) {
                return redirect()->to('/achats')
                                ->with('error', "Stock insuffisant pour {$produit['designation']} !");
            }

            $sousTotal = $achat['prix_unit'] * $achat['quantite'];
            $totalAchat += $sousTotal;

            // Sauvegarder les lignes pour le ticket
            $lignesTicket[] = [
                'designation' => $produit['designation'],
                'quantite'    => $achat['quantite'],
                'prix_unit'   => $achat['prix_unit'],
                'sous_total'  => $sousTotal,
            ];

            $produitModel->update($achat['produit_id'], [
                'quantite_stock' => $produit['quantite_stock'] - $achat['quantite'],
            ]);
        }

        $caisseModel->update($caisse['id'], [
            'montant' => $caisse['montant'] + $totalAchat,
        ]);

        $achatModel
            ->where('caisse_id', $caisse['id'])
            ->where('statut', 'en_cours')
            ->set(['statut' => 'termine'])
            ->update();

        $caisseMAJ = $caisseModel->find($caisse['id']);
        session()->set('caisse', $caisseMAJ);

        // Sauvegarder le ticket en session pour l'afficher
        session()->setFlashdata('ticket', [
            'lignes'     => $lignesTicket,
            'total'      => $totalAchat,
            'caisse'     => $caisse['numero'],
            'date'       => date('d/m/Y H:i:s'),
            'numero'     => uniqid('TCK-'),
        ]);

        return redirect()->to('/achats/ticket');
    }
    public function ticket()
    {
        $ticket = session()->getFlashdata('ticket');

        if (!$ticket) {
            return redirect()->to('/achats');
        }

        return view('achat/ticket', ['ticket' => $ticket]);
    }
}