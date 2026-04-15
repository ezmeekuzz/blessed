<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ProductDetailsController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'The Blessed Manifest',
            'activeMenu' => 'products'
        ];

        return view('pages/product-details', $data);
    }
}
