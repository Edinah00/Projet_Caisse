<?php 
namespace App\Controllers;
use App\Models\AchatModel;
use App\Models\ProduitModel;

class AchatController extends BaseController
{
    public function index()
    {
        if (!session()->get('caisse')) return redirect()->to('/caisse');

        $caisse = session()->get('caisse');
        $produits = (new ProduitModel())->findAll();
        $achats = (new AchatModel())
        ->where('caisse_id', $caisse['id'])
        ->where('status', 'en_cours')
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
        $caisse = session()->get('caisse');
        $produit_id = $this->request->getPost('produit_id');
        $quantite = $this->request->getPost('quantite');

        $produit = (new ProduitModel())->find($produit_id);
        (new AchatModel())->insert([
            'caisse_id' => $caisse['id'],
            'produit_id' => $produit_id,
            'quantite' => $quantite,
            'prix_unit' => $produit['prix'],
            'status' => 'en_cours',
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        return redirect()->to('/achats');
    }

    public function cloturer()
    {
        $caisse = session()->get('caisse');
        (new AchatModel())
        ->where('caisse_id', $caisse['id'])
        ->where('status', 'en_cours')
        ->set(['status' => 'termine'])
        ->update();
        return redirect()->to('/achats')->with('success', 'Achat clôturé avec succès');
    }
}