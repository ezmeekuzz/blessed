<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use App\Models\UsersModel;

class EditCustomerController extends SessionController
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

    public function index($id)
    {
        // Check if user is logged in
        if (!$this->session->get('AdminLoggedIn')) {
            return redirect()->to('/admin/login');
        }

        // Get customer data
        $customer = $this->usersModel->find($id);
        
        if (!$customer) {
            return redirect()->to('/admin/customer-masterlist')->with('error', 'Customer not found');
        }

        // Check if user is a customer
        if ($customer['usertype'] !== 'Regular User') {
            return redirect()->to('/admin/customer-masterlist')->with('error', 'Invalid user type');
        }

        $data = [
            'title' => 'The Blessed Manifest | Edit Customer',
            'activeMenu' => 'usermasterlist',
            'customer' => $customer
        ];

        return view('pages/admin/edit-customer', $data);
    }

    /**
     * Update customer
     */
    public function update($id)
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

        // Get existing customer
        $customer = $this->usersModel->find($id);
        if (!$customer) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Customer not found'
            ]);
        }

        // Set validation rules
        $this->setValidationRules($id);

        if (!$this->validate($this->validation->getRules())) {
            return $this->response->setJSON([
                'success' => false,
                'message' => $this->getFormattedErrors()
            ]);
        }

        // Prepare data
        $data = [
            'firstname' => $this->request->getPost('firstname'),
            'lastname' => $this->request->getPost('lastname'),
            'emailaddress' => $this->request->getPost('emailaddress'),
            'email_verified' => $this->request->getPost('email_verified') ? 1 : 0,
            'status' => $this->request->getPost('status') === 'active' ? 1 : 0
        ];

        // Update password if provided
        $newPassword = $this->request->getPost('password');
        if (!empty($newPassword)) {
            $data['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
            $data['encryptpass'] = $newPassword;
        }

        // Update database
        if ($this->usersModel->update($id, $data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Customer updated successfully!',
                'customer_id' => $id,
                'redirect' => base_url('admin/customer-masterlist')
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to update customer. Please try again.'
        ]);
    }

    /**
     * Set validation rules
     */
    private function setValidationRules($customerId = null)
    {
        $emailRules = 'required|valid_email|max_length[255]';
        if ($customerId) {
            $emailRules .= '|is_unique[users.emailaddress,user_id,' . $customerId . ']';
        } else {
            $emailRules .= '|is_unique[users.emailaddress]';
        }

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
                'rules' => $emailRules,
                'errors' => [
                    'required' => 'Email address is required',
                    'valid_email' => 'Please enter a valid email address',
                    'is_unique' => 'This email address is already registered',
                    'max_length' => 'Email address cannot exceed 255 characters'
                ]
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'permit_empty|min_length[6]|max_length[255]',
                'errors' => [
                    'min_length' => 'Password must be at least 6 characters',
                    'max_length' => 'Password cannot exceed 255 characters'
                ]
            ],
            'confirm_password' => [
                'label' => 'Confirm Password',
                'rules' => 'permit_empty|matches[password]',
                'errors' => [
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