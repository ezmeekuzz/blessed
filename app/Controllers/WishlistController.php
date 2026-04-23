<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class WishlistController extends BaseController
{
    public function index()
    {
        // Check if user is logged in
        if (!session()->has('user_user_id')) {
            return redirect()->to('/login')->with('error', 'Please login to view your wishlist.');
        }

        $data = [
            'title' => 'My Wishlist - The Blessed Manifest',
            'activeMenu' => 'wishlist'
        ];

        return view('pages/wishlist', $data);
    }
}