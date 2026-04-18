<?php
// File: app/Controllers/Admin/SendNewsletterController.php
// Send Newsletter Controller

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;

class SendNewsletterController extends SessionController
{
    protected $db;
    
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    
    /**
     * Display the send newsletter page
     */
    public function index()
    {
        if (!$this->session->get('AdminLoggedIn')) {
            return redirect()->to('/admin/login');
        }
        
        $data = [
            'title' => 'Send Newsletter | Admin Dashboard',
            'activeMenu' => 'sendnewsletter'
        ];
        return view('pages/admin/send-newsletter', $data);
    }
    
    /**
     * Get statistics for dashboard
     */
    public function getStats()
    {
        if (!$this->session->get('AdminLoggedIn')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }
        
        $db = $this->db;
        
        // Total subscribers
        $totalSubscribers = $db->table('newsletter_subscribers')
            ->where('status', 'active')
            ->where('is_verified', 1)
            ->countAllResults();
        
        // Total sent campaigns
        $totalSent = $db->table('newsletter_campaigns')
            ->where('status', 'sent')
            ->countAllResults();
        
        // Scheduled campaigns
        $scheduledCount = $db->table('newsletter_campaigns')
            ->where('status', 'scheduled')
            ->where('scheduled_datetime >', date('Y-m-d H:i:s'))
            ->countAllResults();
        
        // Average open rate
        $result = $db->table('newsletter_campaigns')
            ->selectAvg('open_rate', 'avg_open')
            ->where('status', 'sent')
            ->get()
            ->getRow();
        
        $avgOpenRate = $result->avg_open ? round($result->avg_open) . '%' : '0%';
        
        return $this->response->setJSON([
            'status' => 'success',
            'data' => [
                'total_subscribers' => $totalSubscribers,
                'total_sent' => $totalSent,
                'scheduled_count' => $scheduledCount,
                'avg_open_rate' => $avgOpenRate
            ]
        ]);
    }
    
    /**
     * Get subscribers list
     */
    public function getSubscribers()
    {
        if (!$this->session->get('AdminLoggedIn')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }
        
        $subscribers = $this->db->table('newsletter_subscribers')
            ->select('subscriber_id, email, name')
            ->where('status', 'active')
            ->where('is_verified', 1)
            ->orderBy('subscriber_id', 'DESC')
            ->limit(500)
            ->get()
            ->getResultArray();
        
        return $this->response->setJSON([
            'status' => 'success',
            'data' => $subscribers
        ]);
    }
    
    /**
     * Get recipient count for a group
     */
    public function getRecipientCount()
    {
        if (!$this->session->get('AdminLoggedIn')) {
            return $this->response->setJSON(['count' => 0]);
        }
        
        $group = $this->request->getPost('group');
        $count = 0;
        
        switch($group) {
            case 'all':
                $count = $this->db->table('newsletter_subscribers')
                    ->where('status', 'active')
                    ->where('is_verified', 1)
                    ->countAllResults();
                break;
            case 'active':
                $count = $this->db->table('newsletter_subscribers')
                    ->where('status', 'active')
                    ->where('is_verified', 1)
                    ->countAllResults();
                break;
            case 'verified':
                $count = $this->db->table('newsletter_subscribers')
                    ->where('is_verified', 1)
                    ->countAllResults();
                break;
            case 'new_last_30':
                $count = $this->db->table('newsletter_subscribers')
                    ->where('subscribed_at >=', date('Y-m-d', strtotime('-30 days')))
                    ->countAllResults();
                break;
        }
        
        return $this->response->setJSON(['count' => $count]);
    }
    
    /**
     * Send newsletter
     */
    public function send()
    {
        if (!$this->session->get('AdminLoggedIn')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }
        
        $subject = $this->request->getPost('subject');
        $content = $this->request->getPost('content');
        $preheader = $this->request->getPost('preheader');
        $fromEmail = $this->request->getPost('from_email');
        $replyTo = $this->request->getPost('reply_to');
        $recipientGroup = $this->request->getPost('recipient_group');
        $scheduleType = $this->request->getPost('schedule_type');
        $scheduledDateTime = $this->request->getPost('scheduled_datetime');
        $customRecipients = $this->request->getPost('recipients');
        
        if (empty($subject) || empty($content)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Subject and content are required']);
        }
        
        // Get recipients
        $recipients = [];
        if ($recipientGroup === 'custom' && $customRecipients) {
            $recipientIds = json_decode($customRecipients, true);
            if (!empty($recipientIds)) {
                $recipients = $this->db->table('newsletter_subscribers')
                    ->select('email, name')
                    ->whereIn('subscriber_id', $recipientIds)
                    ->get()
                    ->getResultArray();
            }
        } else {
            $builder = $this->db->table('newsletter_subscribers');
            
            switch($recipientGroup) {
                case 'all':
                case 'active':
                    $builder->where('status', 'active')->where('is_verified', 1);
                    break;
                case 'verified':
                    $builder->where('is_verified', 1);
                    break;
                case 'new_last_30':
                    $builder->where('subscribed_at >=', date('Y-m-d', strtotime('-30 days')));
                    break;
            }
            
            $recipients = $builder->select('email, name')->get()->getResultArray();
        }
        
        if (empty($recipients)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'No recipients found']);
        }
        
        // Handle feature image upload
        $featureImage = $this->request->getFile('feature_image');
        $imagePath = null;
        if ($featureImage && $featureImage->isValid() && !$featureImage->hasMoved()) {
            $newName = $featureImage->getRandomName();
            $featureImage->move('uploads/newsletters', $newName);
            $imagePath = 'uploads/newsletters/' . $newName;
        }
        
        // Create campaign record
        $campaignData = [
            'subject' => $subject,
            'preheader' => $preheader,
            'content' => $content,
            'from_email' => $fromEmail,
            'reply_to' => $replyTo,
            'feature_image' => $imagePath,
            'recipient_group' => $recipientGroup,
            'recipients' => $recipientGroup === 'custom' ? json_encode(array_column($recipients, 'email')) : null,
            'recipient_count' => count($recipients),
            'status' => $scheduleType === 'draft' ? 'draft' : ($scheduleType === 'later' ? 'scheduled' : 'sent'),
            'scheduled_datetime' => $scheduleType === 'later' ? $scheduledDateTime : null,
            'created_by' => $this->session->get('AdminID')
        ];
        
        $this->db->table('newsletter_campaigns')->insert($campaignData);
        $campaignId = $this->db->insertID();
        
        if ($scheduleType === 'draft') {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Newsletter saved as draft successfully'
            ]);
        }
        
        if ($scheduleType === 'later') {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Newsletter scheduled successfully'
            ]);
        }
        
        // Send emails immediately
        $sentCount = 0;
        $failedCount = 0;
        
        $email = \Config\Services::email();
        
        foreach ($recipients as $recipient) {
            $personalizedContent = str_replace('[Subscriber Name]', $recipient['name'] ?? 'Valued Subscriber', $content);
            
            if ($imagePath) {
                $imageHtml = '<img src="' . base_url($imagePath) . '" style="max-width: 100%; margin-bottom: 20px;">';
                $personalizedContent = $imageHtml . $personalizedContent;
            }
            
            $emailBody = $this->buildEmailBody($subject, $preheader, $personalizedContent);
            
            $email->clear();
            $email->setFrom($fromEmail ?? 'noreply@yourdomain.com', 'Newsletter');
            $email->setTo($recipient['email']);
            if ($replyTo) {
                $email->setReplyTo($replyTo);
            }
            $email->setSubject($subject);
            $email->setMessage($emailBody);
            $email->setMailType('html');
            
            if ($email->send()) {
                $sentCount++;
                // Log sent email
                $this->db->table('newsletter_logs')->insert([
                    'campaign_id' => $campaignId,
                    'subscriber_email' => $recipient['email'],
                    'status' => 'sent',
                    'sent_at' => date('Y-m-d H:i:s')
                ]);
            } else {
                $failedCount++;
                $this->db->table('newsletter_logs')->insert([
                    'campaign_id' => $campaignId,
                    'subscriber_email' => $recipient['email'],
                    'status' => 'failed',
                    'error_message' => $email->printDebugger(['headers'])
                ]);
            }
        }
        
        // Update campaign with send stats
        $this->db->table('newsletter_campaigns')
            ->where('campaign_id', $campaignId)
            ->update([
                'sent_count' => $sentCount,
                'failed_count' => $failedCount,
                'sent_at' => date('Y-m-d H:i:s')
            ]);
        
        return $this->response->setJSON([
            'status' => 'success',
            'message' => "Newsletter sent to {$sentCount} recipients. Failed: {$failedCount}"
        ]);
    }
    
    /**
     * Save as draft
     */
    public function saveDraft()
    {
        if (!$this->session->get('AdminLoggedIn')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }
        
        $subject = $this->request->getPost('subject');
        $content = $this->request->getPost('content');
        $preheader = $this->request->getPost('preheader');
        $fromEmail = $this->request->getPost('from_email');
        $replyTo = $this->request->getPost('reply_to');
        $recipientGroup = $this->request->getPost('recipient_group');
        $customRecipients = $this->request->getPost('recipients');
        
        if (empty($subject)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Subject is required']);
        }
        
        // Handle feature image upload
        $featureImage = $this->request->getFile('feature_image');
        $imagePath = null;
        if ($featureImage && $featureImage->isValid() && !$featureImage->hasMoved()) {
            $newName = $featureImage->getRandomName();
            $featureImage->move('uploads/newsletters', $newName);
            $imagePath = 'uploads/newsletters/' . $newName;
        }
        
        $campaignData = [
            'subject' => $subject,
            'preheader' => $preheader,
            'content' => $content,
            'from_email' => $fromEmail,
            'reply_to' => $replyTo,
            'feature_image' => $imagePath,
            'recipient_group' => $recipientGroup,
            'recipients' => $recipientGroup === 'custom' ? $customRecipients : null,
            'status' => 'draft',
            'created_by' => $this->session->get('AdminID')
        ];
        
        $this->db->table('newsletter_campaigns')->insert($campaignData);
        
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Draft saved successfully'
        ]);
    }
    
    /**
     * Get campaign for editing
     */
    public function getCampaign($id)
    {
        if (!$this->session->get('AdminLoggedIn')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }
        
        $campaign = $this->db->table('newsletter_campaigns')
            ->where('campaign_id', $id)
            ->where('status', 'draft')
            ->get()
            ->getRowArray();
        
        if (!$campaign) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Campaign not found']);
        }
        
        return $this->response->setJSON([
            'status' => 'success',
            'data' => $campaign
        ]);
    }
    
    /**
     * Get all campaigns
     */
    public function getCampaigns()
    {
        if (!$this->session->get('AdminLoggedIn')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }
        
        $campaigns = $this->db->table('newsletter_campaigns')
            ->select('campaign_id, subject, recipient_count, sent_count, failed_count, open_rate, status, sent_at, scheduled_datetime')
            ->orderBy('campaign_id', 'DESC')
            ->limit(50)
            ->get()
            ->getResultArray();
        
        return $this->response->setJSON([
            'status' => 'success',
            'data' => $campaigns
        ]);
    }
    
    /**
     * Cancel scheduled campaign
     */
    public function cancel($id)
    {
        if (!$this->session->get('AdminLoggedIn')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }
        
        $updated = $this->db->table('newsletter_campaigns')
            ->where('campaign_id', $id)
            ->where('status', 'scheduled')
            ->update(['status' => 'cancelled']);
        
        if ($updated) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Campaign cancelled successfully'
            ]);
        }
        
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Campaign not found or cannot be cancelled'
        ]);
    }
    
    /**
     * Delete campaign
     */
    public function delete($id)
    {
        if (!$this->session->get('AdminLoggedIn')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }
        
        $deleted = $this->db->table('newsletter_campaigns')
            ->where('campaign_id', $id)
            ->whereIn('status', ['draft', 'cancelled'])
            ->delete();
        
        if ($deleted) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Campaign deleted successfully'
            ]);
        }
        
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Campaign not found or cannot be deleted'
        ]);
    }
    
    /**
     * Build email body HTML
     */
    private function buildEmailBody($subject, $preheader, $content)
    {
        return '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>' . htmlspecialchars($subject) . '</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    line-height: 1.6;
                    color: #333;
                    margin: 0;
                    padding: 0;
                    background-color: #f4f4f4;
                }
                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    padding: 20px;
                    background-color: #ffffff;
                }
                .header {
                    text-align: center;
                    padding: 20px 0;
                    border-bottom: 1px solid #e9ecef;
                }
                .content {
                    padding: 30px 20px;
                }
                .footer {
                    text-align: center;
                    padding: 20px;
                    font-size: 12px;
                    color: #6c757d;
                    border-top: 1px solid #e9ecef;
                }
                .preheader {
                    display: none;
                    font-size: 1px;
                    color: #f4f4f4;
                }
                @media only screen and (max-width: 600px) {
                    .container {
                        width: 100% !important;
                    }
                }
            </style>
        </head>
        <body>
            <div class="preheader">' . htmlspecialchars($preheader) . '</div>
            <div class="container">
                <div class="header">
                    <h2>Newsletter</h2>
                </div>
                <div class="content">
                    ' . $content . '
                </div>
                <div class="footer">
                    <p>You received this email because you subscribed to our newsletter.</p>
                    <p><a href="[UNSUBSCRIBE_LINK]">Unsubscribe</a> | <a href="[VIEW_ONLINE_LINK]">View Online</a></p>
                    <p>&copy; ' . date('Y') . ' Your Company. All rights reserved.</p>
                </div>
            </div>
        </body>
        </html>
        ';
    }
}