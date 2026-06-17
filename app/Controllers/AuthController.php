<?php
namespace App\Controllers;

class AuthController extends BaseController
{
    // Identifiants simples en dur pour le TD
    private array $users = [
        'caissier'  => '1234',
        'admin'     => 'admin',
    ];

    public function login()
    {
        return view('auth/login');
    }

    public function doLogin()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        if (isset($this->users[$username]) && $this->users[$username] === $password) {
            session()->set('user', $username);
            return redirect()->to('/caisse');
        }

        return redirect()->back()->with('error', 'Identifiants incorrects');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}