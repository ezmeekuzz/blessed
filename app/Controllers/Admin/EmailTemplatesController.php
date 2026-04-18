<?php
// File: app/Controllers/Admin/EmailTemplatesController.php
// Email Templates Controller - FIXED STATS

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\EmailTemplatesModel;

class EmailTemplatesController extends SessionController
{
    protected $db;
    protected $emailTemplatesModel;
    
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->emailTemplatesModel = new EmailTemplatesModel();
    }
    
    /**
     * Display the email templates page
     */
    public function index()
    {
        if (!$this->session->get('AdminLoggedIn')) {
            return redirect()->to('/admin/login');
        }
        
        $data = [
            'title' => 'Email Templates | Admin Dashboard',
            'activeMenu' => 'emailtemplates'
        ];
        return view('pages/admin/email-templates', $data);
    }
    
    /**
     * Get all templates
     */
    public function getList()
    {
        if (!$this->session->get('AdminLoggedIn')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }
        
        $templates = $this->emailTemplatesModel
            ->select('template_id, name, description, category, subject, preheader, content, is_active, used_count, created_at')
            ->orderBy('is_active', 'DESC')
            ->orderBy('name', 'ASC')
            ->findAll();
        
        return $this->response->setJSON([
            'status' => 'success',
            'data' => $templates
        ]);
    }
    
    /**
     * Get single template
     */
    public function getTemplate($id)
    {
        if (!$this->session->get('AdminLoggedIn')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }
        
        $template = $this->emailTemplatesModel->find($id);
        
        if (!$template) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Template not found']);
        }
        
        return $this->response->setJSON([
            'status' => 'success',
            'data' => $template
        ]);
    }
    
    /**
     * Save template (create or update)
     */
    public function save()
    {
        if (!$this->session->get('AdminLoggedIn')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }
        
        $templateId = $this->request->getPost('template_id');
        $name = trim($this->request->getPost('name'));
        $description = $this->request->getPost('description');
        $category = $this->request->getPost('category');
        $subject = trim($this->request->getPost('subject'));
        $preheader = $this->request->getPost('preheader');
        $content = $this->request->getPost('content');
        $isActive = $this->request->getPost('is_active') ?? 0;
        
        if (empty($name) || empty($subject) || empty($content)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Name, subject, and content are required']);
        }
        
        $data = [
            'name' => $name,
            'description' => $description,
            'category' => $category,
            'subject' => $subject,
            'preheader' => $preheader,
            'content' => $content,
            'is_active' => $isActive,
        ];
        
        if ($templateId) {
            // Update existing template
            $this->emailTemplatesModel->update($templateId, $data);
            $message = 'Template updated successfully';
        } else {
            // Create new template
            $data['used_count'] = 0;
            $this->emailTemplatesModel->insert($data);
            $message = 'Template created successfully';
        }
        
        return $this->response->setJSON([
            'status' => 'success',
            'message' => $message
        ]);
    }
    
    /**
     * Delete template
     */
    public function delete($id)
    {
        if (!$this->session->get('AdminLoggedIn')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }
        
        $deleted = $this->emailTemplatesModel->delete($id);
        
        if ($deleted) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Template deleted successfully'
            ]);
        }
        
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Template not found or could not be deleted'
        ]);
    }
    
    /**
     * Toggle template active status
     */
    public function toggleStatus($id)
    {
        if (!$this->session->get('AdminLoggedIn')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }
        
        $isActive = $this->request->getPost('is_active');
        
        $updated = $this->emailTemplatesModel->update($id, ['is_active' => $isActive]);
        
        if ($updated) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => $isActive == 1 ? 'Template activated' : 'Template deactivated'
            ]);
        }
        
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Failed to update status'
        ]);
    }
    
    /**
     * Duplicate template
     */
    public function duplicate($id)
    {
        if (!$this->session->get('AdminLoggedIn')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }
        
        $original = $this->emailTemplatesModel->find($id);
        
        if (!$original) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Template not found']);
        }
        
        $newData = [
            'name' => $original['name'] . ' (Copy)',
            'description' => $original['description'],
            'category' => $original['category'],
            'subject' => $original['subject'],
            'preheader' => $original['preheader'],
            'content' => $original['content'],
            'is_active' => 0,
            'used_count' => 0,
        ];
        
        $this->emailTemplatesModel->insert($newData);
        
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Template duplicated successfully'
        ]);
    }
    
    /**
     * Get statistics - FIXED
     */
    public function getStats()
    {
        if (!$this->session->get('AdminLoggedIn')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }
        
        try {
            // Total templates
            $total = $this->emailTemplatesModel->countAll();
            
            // Active templates
            $active = $this->emailTemplatesModel
                ->where('is_active', 1)
                ->countAllResults();
            
            // Unique categories - using query builder directly
            $categories = $this->db->table('email_templates')
                ->select('DISTINCT category')
                ->get()
                ->getResultArray();
            $categoryCount = count($categories);
            
            // Most used template - get the highest used_count
            $mostUsed = $this->emailTemplatesModel
                ->select('used_count')
                ->orderBy('used_count', 'DESC')
                ->first();
            
            $mostUsedCount = $mostUsed ? (int)$mostUsed['used_count'] : 0;
            
            $stats = [
                'total' => (int)$total,
                'active' => (int)$active,
                'categories' => (int)$categoryCount,
                'most_used' => (int)$mostUsedCount
            ];
            
            log_message('debug', 'Stats data: ' . json_encode($stats));
            
            return $this->response->setJSON([
                'status' => 'success',
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error getting stats: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => [
                    'total' => 0,
                    'active' => 0,
                    'categories' => 0,
                    'most_used' => 0
                ]
            ]);
        }
    }
    
    /**
     * Increment template usage count (called when template is used)
     */
    public function incrementUsage($id)
    {
        if (!$this->session->get('AdminLoggedIn')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }
        
        // Get current count and increment
        $template = $this->emailTemplatesModel->find($id);
        if ($template) {
            $newCount = ($template['used_count'] ?? 0) + 1;
            $this->emailTemplatesModel->update($id, ['used_count' => $newCount]);
        }
        
        return $this->response->setJSON(['status' => 'success']);
    }
    
    /**
     * Render template with variables
     * Public method that can be called from other controllers
     */
    public function renderTemplate($templateId, $variables = [])
    {
        $template = $this->emailTemplatesModel
            ->where('template_id', $templateId)
            ->where('is_active', 1)
            ->first();
        
        if (!$template) {
            return null;
        }
        
        // Increment usage count
        $this->incrementUsage($templateId);
        
        // Replace variables in subject and content
        $subject = $template['subject'];
        $content = $template['content'];
        $preheader = $template['preheader'] ?? '';
        
        // Default variables
        $defaultVars = [
            '{site_name}' => $this->getSiteName(),
            '{site_url}' => base_url(),
            '{current_year}' => date('Y'),
            '{unsubscribe_link}' => base_url('unsubscribe'),
            '{view_online}' => '#'
        ];
        
        $allVars = array_merge($defaultVars, $variables);
        
        foreach ($allVars as $key => $value) {
            $subject = str_replace($key, $value, $subject);
            $content = str_replace($key, $value, $content);
            $preheader = str_replace($key, $value, $preheader);
        }
        
        return [
            'subject' => $subject,
            'preheader' => $preheader,
            'content' => $content,
            'from_email' => $template['from_email'] ?? null
        ];
    }
    
    private function getSiteName()
    {
        // Check if settings table exists
        if ($this->db->tableExists('settings')) {
            $setting = $this->db->table('settings')
                ->select('value')
                ->where('key', 'site_name')
                ->get()
                ->getRowArray();
            
            return $setting ? $setting['value'] : 'My Website';
        }
        
        return 'My Website';
    }
}