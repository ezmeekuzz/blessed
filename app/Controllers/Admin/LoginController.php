<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsersModel;

class LoginController extends BaseController
{
    public function index()
    {
        if (session()->has('admin_user_id') && session()->get('admin_usertype') == 'Administrator') {
            return redirect()->to('/admin/dashboard');
        }

        $data = [
            'title' => 'The Blessed Manifest',
            'activeMenu' => 'home'
        ];

        return view('pages/admin/login', $data);
    }

    public function authenticate()
    {
        $userModel = new UsersModel();
    
        $emailaddress = $this->request->getPost('emailaddress');
        $password = $this->request->getPost('password');
        $redirect = $this->request->getPost('redirect');
    
        $result = $userModel
            ->where('emailaddress', $emailaddress)
            ->where('usertype', 'Administrator')
            ->first();
    
        if ($result && password_verify($password, $result['encryptpass'])) {
            // Set session data
            session()->set([
                'admin_user_id' => $result['user_id'],
                'admin_firstname' => $result['firstname'],
                'admin_lastname' => $result['lastname'],
                'admin_emailaddress' => $result['emailaddress'],
                'admin_usertype' => $result['usertype'],
                'AdminLoggedIn' => true,
            ]);
    
            $redirectUrl = '/admin/dashboard';
    
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
