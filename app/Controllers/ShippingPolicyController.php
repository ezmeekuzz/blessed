<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ShippingPolicyController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'The Blessed Manifest',
            'activeMenu' => 'home'
        ];

        return view('pages/shipping-policy', $data);
    }
}
