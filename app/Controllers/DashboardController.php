<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsersModel;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends BaseController
{
    protected $usersModel;

    public function __construct()
    {
        $this->usersModel = new UsersModel();
    }

    public function index()
    {
        // Check if user is logged in
        if (!session()->has('user_user_id')) {
            return redirect()->to('/login')->with('error', 'Please login to access your dashboard.');
        }

        $userId = session()->get('user_user_id');
        $user = $this->usersModel->find($userId);

        if (!$user) {
            return redirect()->to('/login')->with('error', 'User not found.');
        }

        $data = [
            'title' => 'Dashboard - The Blessed Manifest',
            'activeMenu' => 'dashboard',
            'user' => $user
        ];

        return view('pages/dashboard', $data);
    }
}