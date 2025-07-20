<?php

namespace App\Controllers;
use App\Models\AdminModel;

class Auth extends BaseController
{
    public function index()
    {
        return view('auth/login');
    }

    public function login()
    {
        $session = session();
        $model = new AdminModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $admin = $model->where('username', $username)->first();

        if ($admin) {
            if (password_verify($password, $admin['password'])) {
                $session->set('isLoggedIn', true);
                $session->set('username', $admin['username']);
                return redirect()->to('/dashboard')->with('success', 'Login berhasil!');
            } else {
                return redirect()->to('/login')->with('error', 'Password salah!');
            }
        } else {
            return redirect()->to('/login')->with('error', 'Username tidak ditemukan!');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
    
}

