<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class LogoutController extends BaseController
{
    public function index()
    {
        // Destroy admin session data
        session()->remove(['user_user_id', 'user_firstname', 'user_lastname', 'user_emailaddress', 'user_usertype', 'UserLoggedIn']);
        
        // Redirect to the admin login page
        return redirect()->to('/login');
    }
}