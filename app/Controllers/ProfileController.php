<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsersModel;
use CodeIgniter\HTTP\ResponseInterface;

class ProfileController extends BaseController
{
    protected $usersModel;

    public function __construct()
    {
        $this->usersModel = new UsersModel();
    }

    public function index()
    {
        // Check if user is logged in
        if (!session()->has('user_user_id')) {
            return redirect()->to('/login')->with('error', 'Please login to access your profile.');
        }

        $userId = session()->get('user_user_id');
        $user = $this->usersModel->find($userId);

        if (!$user) {
            return redirect()->to('/login')->with('error', 'User not found.');
        }

        $data = [
            'title' => 'My Profile - The Blessed Manifest',
            'activeMenu' => 'home',
            'user' => $user
        ];

        return view('pages/profile', $data);
    }

    public function update()
    {
        // Check if user is logged in
        if (!session()->has('user_user_id')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please login to update your profile.'
            ]);
        }

        // Check if AJAX request
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request method.'
            ]);
        }

        $userId = session()->get('user_user_id');
        $firstname = trim($this->request->getPost('firstname'));
        $lastname = trim($this->request->getPost('lastname'));
        $emailaddress = trim($this->request->getPost('emailaddress'));

        // Validate inputs
        if (empty($firstname)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'First name is required.'
            ]);
        }

        if (empty($lastname)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Last name is required.'
            ]);
        }

        if (empty($emailaddress)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Email address is required.'
            ]);
        }

        if (!filter_var($emailaddress, FILTER_VALIDATE_EMAIL)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please enter a valid email address.'
            ]);
        }

        // Check if email already exists for another user
        $existingUser = $this->usersModel
            ->where('emailaddress', $emailaddress)
            ->where('user_id !=', $userId)
            ->first();

        if ($existingUser) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'This email is already registered to another account.'
            ]);
        }

        // Update user data
        $data = [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'emailaddress' => $emailaddress,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->usersModel->update($userId, $data)) {
            // Update session data
            session()->set('user_firstname', $firstname);
            session()->set('user_lastname', $lastname);
            session()->set('user_emailaddress', $emailaddress);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Profile updated successfully!'
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to update profile. Please try again.'
        ]);
    }

    public function changePassword()
    {
        // Check if user is logged in
        if (!session()->has('user_user_id')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please login to change your password.'
            ]);
        }

        // Check if AJAX request
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request method.'
            ]);
        }

        $userId = session()->get('user_user_id');
        $currentPassword = $this->request->getPost('current_password');
        $newPassword = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');

        // Validate inputs
        if (empty($currentPassword)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Current password is required.'
            ]);
        }

        if (empty($newPassword)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'New password is required.'
            ]);
        }

        if (strlen($newPassword) < 8) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'New password must be at least 8 characters long.'
            ]);
        }

        if ($newPassword !== $confirmPassword) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'New passwords do not match.'
            ]);
        }

        // Get user data
        $user = $this->usersModel->find($userId);

        if (!$user) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'User not found.'
            ]);
        }

        // Verify current password
        if (!password_verify($currentPassword, $user['encryptpass'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Current password is incorrect.'
            ]);
        }

        // Update password
        $data = [
            'password' => $newPassword,
            'encryptpass' => password_hash($newPassword, PASSWORD_BCRYPT),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->usersModel->update($userId, $data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Password changed successfully!'
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to change password. Please try again.'
        ]);
    }
}