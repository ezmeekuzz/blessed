<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsersModel;
use Hermawan\DataTables\DataTable;

class CustomerMasterlistController extends SessionController
{
    protected $db;
    
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    
    public function index()
    {
        // Check if user is logged in
        if (!$this->session->get('AdminLoggedIn')) {
            return redirect()->to('/admin/login');
        }
        
        $data = [
            'title' => 'The Blessed Manifest | Customer Masterlist',
            'activeMenu' => 'customermasterlist'
        ];
        return view('pages/admin/customer-masterlist', $data);
    }
    
    public function getData()
    {
        // Check if user is logged in
        if (!$this->session->get('AdminLoggedIn')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized'
            ]);
        }
        
        $db = db_connect();
        
        // Only get customers (usertype = 'customer')
        $builder = $db->table('users')
                    ->select('
                        user_id, 
                        firstname, 
                        lastname, 
                        emailaddress, 
                        usertype,
                        email_verified,
                        status,
                        created_at,
                        updated_at
                    ')
                    ->where('usertype', 'Regular User')
                    ->orderBy('user_id', 'DESC');

        // Get DataTable response
        $response = DataTable::of($builder)->toJson();
        $json = $response->getBody();
        $result = json_decode($json, true);
        
        // Check if data key exists, if not, initialize empty array
        if (!isset($result['data'])) {
            $result['data'] = [];
        }

        // Transform data
        $data = [];
        foreach ($result['data'] as $row) {
            $fullName = $row[1] . ' ' . $row[2];
            $emailVerifiedBadge = $row[5] == 1 ? 
                '<span class="badge badge-success"><i class="fas fa-check-circle"></i> Verified</span>' : 
                '<span class="badge badge-warning"><i class="fas fa-clock"></i> Unverified</span>';
            
            $data[] = [
                'user_id' => $row[0],
                'firstname' => $row[1],
                'lastname' => $row[2],
                'fullname' => $fullName,
                'emailaddress' => $row[3],
                'usertype' => $row[4],
                'email_verified' => $row[5],
                'email_verified_badge' => $emailVerifiedBadge,
                'status' => $row[6],
                'status_badge' => $row[6] == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>',
                'created_at' => $row[7] ? date('F d Y, h:i:s A', strtotime($row[7])) : 'N/A',
                'updated_at' => $row[8] ? date('F d Y, h:i:s A', strtotime($row[8])) : 'N/A'
            ];
        }

        $result['data'] = $data;
        return $this->response->setJSON($result);
    }
    
    /**
     * Get single customer for viewing
     */
    public function getCustomer($id)
    {
        // Check if user is logged in
        if (!$this->session->get('AdminLoggedIn')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized'
            ]);
        }
        
        // Check if it's an AJAX request
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid request'
            ]);
        }
        
        $usersModel = new UsersModel();
        $customer = $usersModel->find($id);
        
        if (!$customer) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Customer not found'
            ]);
        }
        
        // Prepare data for view
        $customerData = [
            'user_id' => $customer['user_id'],
            'firstname' => htmlspecialchars($customer['firstname']),
            'lastname' => htmlspecialchars($customer['lastname']),
            'fullname' => htmlspecialchars($customer['firstname'] . ' ' . $customer['lastname']),
            'emailaddress' => htmlspecialchars($customer['emailaddress']),
            'usertype' => $customer['usertype'],
            'email_verified' => $customer['email_verified'],
            'email_verified_badge' => $customer['email_verified'] == 1 ? 
                '<span class="badge badge-success">Verified</span>' : 
                '<span class="badge badge-warning">Unverified</span>',
            'status' => $customer['status'],
            'status_badge' => $customer['status'] == 1 ? 
                '<span class="badge badge-success">Active</span>' : 
                '<span class="badge badge-danger">Inactive</span>',
            'created_at' => isset($customer['created_at']) ? date('F d Y, h:i:s A', strtotime($customer['created_at'])) : 'N/A',
            'updated_at' => isset($customer['updated_at']) ? date('F d Y, h:i:s A', strtotime($customer['updated_at'])) : 'N/A'
        ];
        
        return $this->response->setJSON([
            'status' => 'success',
            'data' => $customerData
        ]);
    }
    
    /**
     * Toggle customer status (Active/Inactive)
     */
    public function toggleStatus($id)
    {
        // Check if user is logged in
        if (!$this->session->get('AdminLoggedIn')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized'
            ]);
        }
        
        // Check if it's an AJAX request
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid request'
            ]);
        }
        
        $usersModel = new UsersModel();
        $customer = $usersModel->find($id);
        
        if ($customer) {
            $newStatus = $customer['status'] == 1 ? 0 : 1;
            $usersModel->update($id, ['status' => $newStatus]);
            
            return $this->response->setJSON([
                'status' => 'success',
                'message' => $newStatus == 1 ? 'Customer activated' : 'Customer deactivated',
                'status' => $newStatus
            ]);
        }
        
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Customer not found'
        ]);
    }
    
    /**
     * Toggle email verification status
     */
    public function toggleEmailVerification($id)
    {
        // Check if user is logged in
        if (!$this->session->get('AdminLoggedIn')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized'
            ]);
        }
        
        // Check if it's an AJAX request
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid request'
            ]);
        }
        
        $usersModel = new UsersModel();
        $customer = $usersModel->find($id);
        
        if ($customer) {
            $newStatus = $customer['email_verified'] == 1 ? 0 : 1;
            $usersModel->update($id, ['email_verified' => $newStatus]);
            
            return $this->response->setJSON([
                'status' => 'success',
                'message' => $newStatus == 1 ? 'Email marked as verified' : 'Email marked as unverified',
                'email_verified' => $newStatus
            ]);
        }
        
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Customer not found'
        ]);
    }
    
    /**
     * Delete customer
     */
    public function delete($id)
    {
        // Check if user is logged in
        if (!$this->session->get('AdminLoggedIn')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized'
            ]);
        }
        
        // Check if it's an AJAX request
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid request'
            ]);
        }
        
        $usersModel = new UsersModel();
        
        // Find the customer by ID
        $customer = $usersModel->find($id);
        
        if ($customer) {
            // Delete the customer record
            $deleted = $usersModel->delete($id);
            
            if ($deleted) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Customer deleted successfully'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Failed to delete customer'
                ]);
            }
        }
        
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Customer not found'
        ]);
    }
}