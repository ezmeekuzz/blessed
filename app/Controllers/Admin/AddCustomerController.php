<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use App\Models\UsersModel;

class AddCustomerController extends SessionController
{
    protected $usersModel;
    protected $validation;
    protected $session;
    protected $db;

    public function __construct()
    {
        $this->usersModel = new UsersModel();
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        // Check if user is logged in
        if (!$this->session->get('AdminLoggedIn')) {
            return redirect()->to('/admin/login');
        }

        $data = [
            'title' => 'The Blessed Manifest | Add Customer',
            'activeMenu' => 'addcustomer'
        ];

        return view('pages/admin/add-customer', $data);
    }

    /**
     * Handle customer submission
     */
    public function store()
    {
        // Check if user is logged in
        if (!$this->session->get('AdminLoggedIn')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please login first'
            ]);
        }

        // Check if this is an AJAX request
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request method.'
            ]);
        }

        // Set validation rules
        $this->setValidationRules();

        if (!$this->validate($this->validation->getRules())) {
            return $this->response->setJSON([
                'success' => false,
                'message' => $this->getFormattedErrors()
            ]);
        }

        // Check if email already exists
        $email = $this->request->getPost('emailaddress');
        $existingUser = $this->usersModel->where('emailaddress', $email)->first();
        if ($existingUser) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Email address already exists. Please use a different email.'
            ]);
        }

        // Generate password
        $plainPassword = $this->request->getPost('password');
        $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);
        
        // Generate verification token (optional)
        $verificationToken = bin2hex(random_bytes(32));
        $tokenExpiry = date('Y-m-d H:i:s', strtotime('+7 days'));

        // Prepare data
        $data = [
            'firstname' => $this->request->getPost('firstname'),
            'lastname' => $this->request->getPost('lastname'),
            'emailaddress' => $email,
            'password' => $plainPassword,
            'encryptpass' => $hashedPassword, // Store plain password as per your model
            'usertype' => 'Regular User', // Default user type
            'email_verified' => $this->request->getPost('email_verified') ? 1 : 0,
            'verification_token' => $verificationToken,
            'token_expiry' => $tokenExpiry,
            'status' => $this->request->getPost('status') === 'active' ? 1 : 0
        ];

        // Save to database
        if ($this->usersModel->insert($data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Customer added successfully!',
                'user_id' => $this->usersModel->getInsertID(),
                'redirect' => base_url('admin/customer-masterlist')
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to add customer. Please try again.'
        ]);
    }

    /**
     * Set validation rules
     */
    private function setValidationRules()
    {
        $this->validation->setRules([
            'firstname' => [
                'label' => 'First Name',
                'rules' => 'required|min_length[2]|max_length[100]',
                'errors' => [
                    'required' => 'First name is required',
                    'min_length' => 'First name must be at least 2 characters',
                    'max_length' => 'First name cannot exceed 100 characters'
                ]
            ],
            'lastname' => [
                'label' => 'Last Name',
                'rules' => 'required|min_length[2]|max_length[100]',
                'errors' => [
                    'required' => 'Last name is required',
                    'min_length' => 'Last name must be at least 2 characters',
                    'max_length' => 'Last name cannot exceed 100 characters'
                ]
            ],
            'emailaddress' => [
                'label' => 'Email Address',
                'rules' => 'required|valid_email|max_length[255]',
                'errors' => [
                    'required' => 'Email address is required',
                    'valid_email' => 'Please enter a valid email address',
                    'max_length' => 'Email address cannot exceed 255 characters'
                ]
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required|min_length[6]|max_length[255]',
                'errors' => [
                    'required' => 'Password is required',
                    'min_length' => 'Password must be at least 6 characters',
                    'max_length' => 'Password cannot exceed 255 characters'
                ]
            ],
            'confirm_password' => [
                'label' => 'Confirm Password',
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Please confirm your password',
                    'matches' => 'Passwords do not match'
                ]
            ],
            'status' => [
                'label' => 'Status',
                'rules' => 'required|in_list[active,inactive]'
            ]
        ]);
    }

    /**
     * Get formatted error messages
     * @return string
     */
    private function getFormattedErrors()
    {
        $errors = $this->validation->getErrors();
        $errorMessages = [];
        foreach ($errors as $field => $error) {
            $errorMessages[] = $error;
        }
        return implode('<br>', $errorMessages);
    }
}