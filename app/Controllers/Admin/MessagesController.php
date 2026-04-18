<?php
// File: app/Controllers/Admin/MessagesController.php
// Contact Messages Controller - Adjusted for your existing model

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
                        priority,
                        status,
                        created_at,
                        phone,
                        ip_address
                    ')
                    ->orderBy('contact_id', 'DESC');
        
        // Apply filters
        $status = $this->request->getPost('status');
        if ($status && $status !== '') {
            $builder->where('status', $status);
        }
        
        $priority = $this->request->getPost('priority');
        if ($priority && $priority !== '') {
            $builder->where('priority', $priority);
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
        
        // Transform data to ensure proper format
        $data = [];
        if (isset($result['data']) && is_array($result['data'])) {
            foreach ($result['data'] as $row) {
                $data[] = [
                    'contact_id' => $row[0] ?? $row['contact_id'] ?? null,
                    'name' => $row[1] ?? $row['name'] ?? '',
                    'email' => $row[2] ?? $row['email'] ?? '',
                    'subject' => $row[3] ?? $row['subject'] ?? '',
                    'message' => $row[4] ?? $row['message'] ?? '',
                    'priority' => $row[5] ?? $row['priority'] ?? 'medium',
                    'status' => $row[6] ?? $row['status'] ?? 'unread',
                    'created_at' => $row[7] ?? $row['created_at'] ?? null,
                    'phone' => $row[8] ?? $row['phone'] ?? null,
                    'ip_address' => $row[9] ?? $row['ip_address'] ?? null
                ];
            }
        }
        
        // Get statistics
        $stats = $this->getStatistics();
        
        return $this->response->setJSON([
            'draw' => $result['draw'] ?? 1,
            'recordsTotal' => $result['recordsTotal'] ?? 0,
            'recordsFiltered' => $result['recordsFiltered'] ?? 0,
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
        $unread = $db->table('contact_messages')->where('status', 'unread')->countAllResults();
        
        // Replied messages
        $replied = $db->table('contact_messages')->where('status', 'replied')->countAllResults();
        
        // Today's messages
        $today = date('Y-m-d');
        $todayCount = $db->table('contact_messages')->where('DATE(created_at)', $today)->countAllResults();
        
        return [
            'total' => $total,
            'unread' => $unread,
            'replied' => $replied,
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
        
        $messageModel = new ContactMessagesModel();
        $message = $messageModel->find($id);
        
        if (!$message) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Message not found'
            ]);
        }
        
        // Mark as read if it's unread
        if ($message['status'] === 'unread') {
            $messageModel->update($id, ['status' => 'read']);
            $message['status'] = 'read';
        }
        
        // Format date
        $message['formatted_date'] = date('F d, Y h:i:s A', strtotime($message['created_at']));
        
        return $this->response->setJSON([
            'status' => 'success',
            'data' => $message
        ]);
    }
    
    /**
     * Reply to a message
     */
    public function reply($id)
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
        
        $replyMessage = $this->request->getPost('reply_message');
        $ccMe = $this->request->getPost('cc_me');
        
        if (empty($replyMessage)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Reply message cannot be empty'
            ]);
        }
        
        $messageModel = new ContactMessagesModel();
        $message = $messageModel->find($id);
        
        if (!$message) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Message not found'
            ]);
        }
        
        // Send email reply
        $email = \Config\Services::email();
        
        // Configure email - Update these settings as needed
        $email->setFrom('noreply@yourdomain.com', 'Admin Support');
        $email->setTo($message['email']);
        
        if (!empty($ccMe)) {
            $email->setCC($ccMe);
        }
        
        $email->setSubject('Re: ' . $message['subject']);
        
        // Build email body
        $body = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #667eea; color: white; padding: 20px; text-align: center; }
                .content { padding: 20px; background: #f9f9f9; }
                .footer { text-align: center; padding: 20px; font-size: 12px; color: #666; }
                .original-message { background: #e9ecef; padding: 15px; margin-top: 20px; border-left: 4px solid #667eea; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>Response to Your Inquiry</h2>
                </div>
                <div class='content'>
                    <p>Dear " . htmlspecialchars($message['name']) . ",</p>
                    <p>" . nl2br(htmlspecialchars($replyMessage)) . "</p>
                    <p>Best regards,<br>Support Team</p>
                    
                    <div class='original-message'>
                        <strong>Your original message:</strong><br>
                        " . nl2br(htmlspecialchars($message['message'])) . "
                    </div>
                </div>
                <div class='footer'>
                    <p>This is an automated response. Please do not reply to this email.</p>
                </div>
            </div>
        </body>
        </html>
        ";
        
        $email->setMessage($body);
        $email->setMailType('html');
        
        $sent = $email->send();
        
        if ($sent) {
            // Update message status to replied
            $messageModel->update($id, [
                'status' => 'replied',
                'replied_at' => date('Y-m-d H:i:s'),
                'replied_by' => $this->session->get('AdminID')
            ]);
            
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Reply sent successfully'
            ]);
        } else {
            // Get email error if available
            $error = $email->printDebugger(['headers']);
            log_message('error', 'Email send failed: ' . $error);
            
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to send email. Please check email configuration.'
            ]);
        }
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
        
        $messageModel = new ContactMessagesModel();
        $message = $messageModel->find($id);
        
        if ($message) {
            $deleted = $messageModel->delete($id);
            
            if ($deleted) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Message deleted successfully'
                ]);
            }
        }
        
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Message not found or could not be deleted'
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
               ->where('status', 'unread')
               ->update(['status' => 'read']);
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
        
        $messageModel = new ContactMessagesModel();
        $deleted = $messageModel->whereIn('contact_id', $ids)->delete();
        
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
     * Get unread count (for sidebar badge - optional)
     */
    public function getUnreadCount()
    {
        if (!$this->session->get('AdminLoggedIn')) {
            return $this->response->setJSON(['count' => 0]);
        }
        
        $db = db_connect();
        $count = $db->table('contact_messages')->where('status', 'unread')->countAllResults();
        
        return $this->response->setJSON(['count' => $count]);
    }
}