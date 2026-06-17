<?php
namespace App\Controllers;
use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        // Si déjà connecté, on redirige
        if (session()->get('user')) {
            return redirect()->to('/caisse');
        }
        return view('auth/login');
    }

    public function doLogin()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $model = new UserModel();
        $user  = $model->findByUsername($username);

        // Vérification : user existe + mot de passe correct
        if ($user && password_verify($password, $user['password'])) {
            session()->set([
                'user'     => $user['username'],
                'user_id'  => $user['id'],
                'role'     => $user['role'],
                'logged_in' => true,
            ]);
            return redirect()->to('/caisse');
        }

        return redirect()->back()
                         ->with('error', 'Identifiants incorrects')
                         ->withInput();
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}