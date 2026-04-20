<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ContactMessagesModel;
use Hermawan\DataTables\DataTable;

class MessagesController extends SessionController
{
    protected $db;
    
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    
    /**
     * Display the contact messages page
     */
    public function index()
    {
        // Check if user is logged in
        if (!$this->session->get('AdminLoggedIn')) {
            return redirect()->to('/admin/login');
        }
        
        $data = [
            'title' => 'Contact Messages | Admin Dashboard',
            'activeMenu' => 'messages'
        ];
        return view('pages/admin/messages', $data);
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
        $builder = $db->table('contact_messages')
                    ->select('
                        contact_id,
                        name,
                        email,
                        subject,
                        message,
                        created_at,
                        phone,
                        ip_address,
                        is_read
                    ')
                    ->orderBy('contact_id', 'DESC');
        
        // Apply filters
        $status = $this->request->getPost('status');
        if ($status && $status !== '') {
            if ($status === 'unread') {
                $builder->where('is_read', 0);
            } elseif ($status === 'read') {
                $builder->where('is_read', 1);
            }
        }
        
        $dateRange = $this->request->getPost('date_range');
        if ($dateRange && strpos($dateRange, 'to') !== false) {
            $dates = explode(' to ', $dateRange);
            if (count($dates) == 2) {
                $startDate = trim($dates[0]);
                $endDate = trim($dates[1]);
                $builder->where('DATE(created_at) >=', $startDate);
                $builder->where('DATE(created_at) <=', $endDate);
            }
        }
        
        // Get DataTable response
        $response = DataTable::of($builder)->toJson();
        $json = $response->getBody();
        $result = json_decode($json, true);
        
        // The data from DataTable is in $result['data']
        // Each row is an array of values in order of SELECT columns
        $data = [];
        foreach ($result['data'] as $row) {
            $data[] = [
                'contact_id' => $row[0],
                'name' => $row[1],
                'email' => $row[2],
                'subject' => $row[3],
                'message' => $row[4],
                'created_at' => $row[5],
                'phone' => $row[6],
                'ip_address' => $row[7],
                'is_read' => $row[8],
                'status' => ($row[8] == 0) ? 'unread' : 'read'
            ];
        }
        
        // Get statistics
        $stats = $this->getStatistics();
        
        // Return in the format DataTables expects
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
        $db = db_connect();
        
        // Total messages
        $total = $db->table('contact_messages')->countAllResults();
        
        // Unread messages
        $unread = $db->table('contact_messages')->where('is_read', 0)->countAllResults();
        
        // Today's messages
        $today = date('Y-m-d');
        $todayCount = $db->table('contact_messages')->where('DATE(created_at)', $today)->countAllResults();
        
        return [
            'total' => $total,
            'unread' => $unread,
            'today' => $todayCount
        ];
    }
    
    /**
     * Get single message details
     */
    public function getMessage($id)
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
        
        $messagesModel = new ContactMessagesModel();
        $message = $messagesModel->find($id);
        
        if (!$message) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Message not found'
            ]);
        }
        
        // Mark as read if it's unread
        if ($message['is_read'] == 0) {
            $messagesModel->update($id, ['is_read' => 1]);
            $message['is_read'] = 1;
        }
        
        // Prepare data for view
        $messageData = [
            'contact_id' => $message['contact_id'],
            'name' => htmlspecialchars($message['name']),
            'email' => htmlspecialchars($message['email']),
            'phone' => htmlspecialchars($message['phone'] ?? 'Not provided'),
            'subject' => htmlspecialchars($message['subject']),
            'message' => nl2br(htmlspecialchars($message['message'])),
            'ip_address' => $message['ip_address'] ?? 'Not recorded',
            'is_read' => $message['is_read'],
            'status' => ($message['is_read'] == 0) ? 'unread' : 'read',
            'created_at' => isset($message['created_at']) ? date('F d Y, h:i:s A', strtotime($message['created_at'])) : 'N/A'
        ];
        
        return $this->response->setJSON([
            'status' => 'success',
            'data' => $messageData
        ]);
    }
    
    /**
     * Delete a message
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
        
        $messagesModel = new ContactMessagesModel();
        
        // Find the message by ID
        $message = $messagesModel->find($id);
        
        if ($message) {
            // Delete the message record
            $deleted = $messagesModel->delete($id);
            
            if ($deleted) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Message deleted successfully'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Failed to delete message'
                ]);
            }
        }
        
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Message not found'
        ]);
    }
    
    /**
     * Bulk mark messages as read
     */
    public function bulkMarkRead()
    {
        // Check if user is logged in
        if (!$this->session->get('AdminLoggedIn')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized'
            ]);
        }
        
        $ids = $this->request->getPost('ids');
        
        if (empty($ids) || !is_array($ids)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'No messages selected'
            ]);
        }
        
        $db = db_connect();
        $db->transStart();
        
        foreach ($ids as $id) {
            $db->table('contact_messages')
               ->where('contact_id', $id)
               ->where('is_read', 0)
               ->update(['is_read' => 1]);
        }
        
        $db->transComplete();
        
        if ($db->transStatus() === true) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => count($ids) . ' message(s) marked as read'
            ]);
        }
        
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Failed to update messages'
        ]);
    }
    
    /**
     * Bulk delete messages
     */
    public function bulkDelete()
    {
        // Check if user is logged in
        if (!$this->session->get('AdminLoggedIn')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized'
            ]);
        }
        
        $ids = $this->request->getPost('ids');
        
        if (empty($ids) || !is_array($ids)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'No messages selected'
            ]);
        }
        
        $messagesModel = new ContactMessagesModel();
        $deleted = $messagesModel->whereIn('contact_id', $ids)->delete();
        
        if ($deleted) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => count($ids) . ' message(s) deleted successfully'
            ]);
        }
        
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Failed to delete messages'
        ]);
    }
    
    /**
     * Get unread count (for sidebar badge)
     */
    public function getUnreadCount()
    {
        if (!$this->session->get('AdminLoggedIn')) {
            return $this->response->setJSON(['count' => 0]);
        }
        
        $db = db_connect();
        $count = $db->table('contact_messages')->where('is_read', 0)->countAllResults();
        
        return $this->response->setJSON(['count' => $count]);
    }
}