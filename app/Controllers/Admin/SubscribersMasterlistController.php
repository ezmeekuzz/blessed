<?php
// File: app/Controllers/Admin/SubscribersMasterlistController.php
// Newsletter Subscribers Masterlist Controller

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\NewsletterSubscriberModel;
use Hermawan\DataTables\DataTable;

class SubscribersMasterlistController extends SessionController
{
    protected $db;
    
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    
    /**
     * Display the subscribers masterlist page
     */
    public function index()
    {
        // Check if user is logged in
        if (!$this->session->get('AdminLoggedIn')) {
            return redirect()->to('/admin/login');
        }
        
        $data = [
            'title' => 'Newsletter Subscribers | Admin Dashboard',
            'activeMenu' => 'subscribersmasterlist'
        ];
        return view('pages/admin/subscribers-masterlist', $data);
    }
    
    /**
     * Get data for DataTable with server-side processing
     */
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
        $builder = $db->table('newsletter_subscribers')
                    ->select('
                        subscriber_id,
                        email,
                        name,
                        status,
                        is_verified,
                        subscribed_at,
                        verified_at,
                        unsubscribed_at,
                        ip_address
                    ')
                    ->orderBy('subscriber_id', 'DESC');
        
        // Apply filters
        $status = $this->request->getPost('status');
        if ($status && $status !== '') {
            $builder->where('status', $status);
        }
        
        $verified = $this->request->getPost('verified');
        if ($verified !== null && $verified !== '') {
            $builder->where('is_verified', $verified);
        }
        
        $dateRange = $this->request->getPost('date_range');
        if ($dateRange && strpos($dateRange, 'to') !== false) {
            $dates = explode(' to ', $dateRange);
            if (count($dates) == 2) {
                $startDate = trim($dates[0]);
                $endDate = trim($dates[1]);
                $builder->where('DATE(subscribed_at) >=', $startDate);
                $builder->where('DATE(subscribed_at) <=', $endDate);
            }
        }
        
        // Get DataTable response
        $response = DataTable::of($builder)->toJson();
        $json = $response->getBody();
        $result = json_decode($json, true);
        
        // Transform data
        $data = [];
        foreach ($result['data'] as $row) {
            $data[] = [
                'subscriber_id' => $row[0],
                'email' => $row[1],
                'name' => $row[2] ?? '',
                'status' => $row[3] ?? 'pending',
                'is_verified' => $row[4] ?? 0,
                'subscribed_at' => $row[5],
                'verified_at' => $row[6],
                'unsubscribed_at' => $row[7],
                'ip_address' => $row[8]
            ];
        }
        
        // Get statistics
        $stats = $this->getStatistics();
        
        // Return response with stats
        return $this->response->setJSON([
            'draw' => $result['draw'],
            'recordsTotal' => $result['recordsTotal'],
            'recordsFiltered' => $result['recordsFiltered'],
            'data' => $data,
            'stats' => $stats
        ]);
    }
    
    /**
     * Get statistics for dashboard cards
     */
    private function getStatistics()
    {
        $subscriberModel = new NewsletterSubscriberModel();
        
        $total = $subscriberModel->countAll();
        $active = $subscriberModel->where('status', 'active')->countAllResults();
        $verified = $subscriberModel->where('is_verified', 1)->countAllResults();
        
        // Get new subscribers this month
        $thisMonth = date('Y-m-01');
        $newThisMonth = $subscriberModel->where('subscribed_at >=', $thisMonth)->countAllResults();
        
        return [
            'total' => $total,
            'active' => $active,
            'verified' => $verified,
            'new_this_month' => $newThisMonth
        ];
    }
    
    /**
     * Get single subscriber details
     */
    public function getSubscriber($id)
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
        
        $subscriberModel = new NewsletterSubscriberModel();
        $subscriber = $subscriberModel->find($id);
        
        if (!$subscriber) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Subscriber not found'
            ]);
        }
        
        // Format dates
        $subscriber['subscribed_at'] = isset($subscriber['subscribed_at']) && $subscriber['subscribed_at'] != '-0001-11-30 00:00:00' 
            ? date('F d, Y h:i:s A', strtotime($subscriber['subscribed_at'])) 
            : 'N/A';
            
        $subscriber['verified_at'] = isset($subscriber['verified_at']) && $subscriber['verified_at'] != '-0001-11-30 00:00:00' 
            ? date('F d, Y h:i:s A', strtotime($subscriber['verified_at'])) 
            : null;
            
        $subscriber['unsubscribed_at'] = isset($subscriber['unsubscribed_at']) && $subscriber['unsubscribed_at'] != '-0001-11-30 00:00:00' 
            ? date('F d, Y h:i:s A', strtotime($subscriber['unsubscribed_at'])) 
            : null;
        
        return $this->response->setJSON([
            'status' => 'success',
            'data' => $subscriber
        ]);
    }
    
    /**
     * Update subscriber status
     */
    public function updateStatus($id)
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
        
        $newStatus = $this->request->getPost('status');
        $validStatuses = ['active', 'inactive', 'pending'];
        
        if (!in_array($newStatus, $validStatuses)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid status value'
            ]);
        }
        
        $subscriberModel = new NewsletterSubscriberModel();
        $subscriber = $subscriberModel->find($id);
        
        if (!$subscriber) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Subscriber not found'
            ]);
        }
        
        $updateData = ['status' => $newStatus];
        
        // If setting to inactive, record unsubscribed date
        if ($newStatus === 'inactive' && $subscriber['status'] !== 'inactive') {
            $updateData['unsubscribed_at'] = date('Y-m-d H:i:s');
        }
        
        // If setting back to active from inactive, clear unsubscribed date
        if ($newStatus === 'active' && $subscriber['status'] === 'inactive') {
            $updateData['unsubscribed_at'] = null;
        }
        
        $updated = $subscriberModel->update($id, $updateData);
        
        if ($updated) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Subscriber status updated successfully'
            ]);
        }
        
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Failed to update subscriber status'
        ]);
    }
    
    /**
     * Delete subscriber
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
        
        $subscriberModel = new NewsletterSubscriberModel();
        $subscriber = $subscriberModel->find($id);
        
        if ($subscriber) {
            $deleted = $subscriberModel->delete($id);
            
            if ($deleted) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Subscriber deleted successfully'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Failed to delete subscriber'
                ]);
            }
        }
        
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Subscriber not found'
        ]);
    }
    
    /**
     * Export subscribers to CSV or Excel
     */
    public function export()
    {
        // Check if user is logged in
        if (!$this->session->get('AdminLoggedIn')) {
            return redirect()->to('/admin/login');
        }
        
        $format = $this->request->getGet('format') ?? 'csv';
        $status = $this->request->getGet('status');
        $verified = $this->request->getGet('verified');
        $dateRange = $this->request->getGet('date_range');
        
        $subscriberModel = new NewsletterSubscriberModel();
        
        // Build query
        $builder = $subscriberModel->select('subscriber_id, email, name, status, is_verified, subscribed_at, verified_at, ip_address');
        
        if ($status && $status !== '') {
            $builder->where('status', $status);
        }
        
        if ($verified !== null && $verified !== '') {
            $builder->where('is_verified', $verified);
        }
        
        if ($dateRange && strpos($dateRange, 'to') !== false) {
            $dates = explode(' to ', $dateRange);
            if (count($dates) == 2) {
                $startDate = trim($dates[0]);
                $endDate = trim($dates[1]);
                $builder->where('DATE(subscribed_at) >=', $startDate);
                $builder->where('DATE(subscribed_at) <=', $endDate);
            }
        }
        
        $subscribers = $builder->orderBy('subscriber_id', 'DESC')->findAll();
        
        // Prepare data for export
        $exportData = [];
        $exportData[] = [
            'ID',
            'Email Address',
            'Full Name',
            'Status',
            'Verified',
            'Subscribed Date',
            'Verified Date',
            'IP Address'
        ];
        
        foreach ($subscribers as $subscriber) {
            $exportData[] = [
                $subscriber['subscriber_id'],
                $subscriber['email'],
                $subscriber['name'] ?? '',
                ucfirst($subscriber['status'] ?? 'Pending'),
                $subscriber['is_verified'] == 1 ? 'Yes' : 'No',
                $subscriber['subscribed_at'] ?? '',
                $subscriber['verified_at'] ?? '',
                $subscriber['ip_address'] ?? ''
            ];
        }
        
        if ($format === 'excel') {
            // For Excel, we'll use CSV but with .xls extension and Excel compatible encoding
            $filename = 'newsletter_subscribers_' . date('Y-m-d') . '.xls';
            $this->response->setContentType('application/vnd.ms-excel');
            $this->response->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"');
            
            $output = fopen('php://output', 'w');
            foreach ($exportData as $row) {
                fputcsv($output, $row, "\t");
            }
            fclose($output);
        } else {
            // CSV export
            $filename = 'newsletter_subscribers_' . date('Y-m-d') . '.csv';
            $this->response->setContentType('text/csv');
            $this->response->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"');
            
            $output = fopen('php://output', 'w');
            foreach ($exportData as $row) {
                fputcsv($output, $row);
            }
            fclose($output);
        }
        
        return null; // Response already sent
    }
}