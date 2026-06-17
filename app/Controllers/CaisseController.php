<?php
namespace App\Controllers;
use App\Models\CaisseModel;

class Caissecontroller extends BaseController
{
    public function choisir()
    {
        if (!session()->get('user')) return redirect()->to('/');

        // Réinitialiser la caisse en session
        session()->remove('caisse');

        $model   = new CaisseModel();
        $caisses = $model->findAll();
        return view('caisse/choisir', ['caisses' => $caisses]);
    }

    public function valider()
    {
        $id = $this->request->getPost('caisse_id');
        $model = new CaisseModel();
        $caisse = $model->find($id);

        session()->set('caisse',$caisse);
        return redirect()->to('/achats');
    }
}