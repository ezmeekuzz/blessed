<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsersModel;

class LoginController extends BaseController
{
    public function index()
    {
        if (session()->has('user_user_id') && session()->get('user_usertype') == 'Regular User') {
            return redirect()->to('/');
        }

        $data = [
            'title' => 'The Blessed Manifest',
            'activeMenu' => 'home'
        ];

        return view('pages/login', $data);
    }

    public function authenticate()
    {
        $userModel = new UsersModel();
    
        $emailaddress = $this->request->getPost('emailaddress');
        $password = $this->request->getPost('password');
        $redirect = $this->request->getPost('redirect');
    
        $result = $userModel
            ->where('emailaddress', $emailaddress)
            ->where('usertype', 'Regular User')
            ->where('email_verified', 1)
            ->first();
    
        if ($result && password_verify($password, $result['encryptpass'])) {
            // Set session data
            session()->set([
                'user_user_id' => $result['user_id'],
                'user_firstname' => $result['firstname'],
                'user_lastname' => $result['lastname'],
                'user_emailaddress' => $result['emailaddress'],
                'user_usertype' => $result['usertype'],
                'UserLoggedIn' => true,
            ]);
    
            $redirectUrl = '/';
    
            // Prepare response
            $response = [
                'success' => true,
                'redirect' => $redirectUrl,
                'message' => 'Login successful'
            ];
        } else {
            // Prepare response for invalid login
            $response = [
                'success' => false,
                'message' => 'Invalid login credentials'
            ];
        }
    
        // Return JSON response
        return $this->response->setJSON($response);
    }    
}
