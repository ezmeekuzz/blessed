<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class OrdersController extends BaseController
{
    public function index()
    {
        // Check if user is logged in
        if (!session()->has('user_user_id')) {
            return redirect()->to('/login')->with('error', 'Please login to view your orders.');
        }

        $data = [
            'title' => 'The Blessed Manifest',
            'activeMenu' => 'orders'
        ];

        return view('pages/orders', $data);
    }
}