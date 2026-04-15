<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ContactUsController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'The Blessed Manifest',
            'activeMenu' => 'contact'
        ];

        return view('pages/contact-us', $data);
    }
}
