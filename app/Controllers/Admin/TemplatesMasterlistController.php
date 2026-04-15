<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\GridTemplatesModel;
use Hermawan\DataTables\DataTable;

class TemplatesMasterlistController extends SessionController
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
            'title' => 'The Blessed Manifest | Templates Masterlist',
            'activeMenu' => 'templates'
        ];
        return view('pages/admin/templates-masterlist', $data);
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
        $builder = $db->table('grid_templates')
                    ->select('
                        grid_template_id, 
                        name, 
                        layout_json, 
                        is_featured,
                        created_at,
                        updated_at
                    ')
                    ->orderBy('grid_template_id', 'DESC');

        // Get DataTable response
        $response = DataTable::of($builder)->toJson();
        $json = $response->getBody();
        $result = json_decode($json, true);

        // The data from DataTable is in $result['data']
        // Each row is an array of values in order of SELECT columns
        $data = [];
        foreach ($result['data'] as $row) {
            $data[] = [
                'grid_template_id' => $row[0],
                'name' => $row[1],
                'layout_json' => $row[2],
                'is_featured' => $row[3],
                'created_at' => $row[4],
                'updated_at' => $row[5]
            ];
        }

        // Return in the format DataTables expects
        return $this->response->setJSON([
            'draw' => $result['draw'],
            'recordsTotal' => $result['recordsTotal'],
            'recordsFiltered' => $result['recordsFiltered'],
            'data' => $data
        ]);
    }
    
    /**
     * Get single template for viewing
     */
    public function getTemplate($id)
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
        
        $templatesModel = new GridTemplatesModel();
        $template = $templatesModel->find($id);
        
        if (!$template) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Template not found'
            ]);
        }
        
        // Prepare data for view
        $templateData = [
            'grid_template_id' => $template['grid_template_id'],
            'name' => htmlspecialchars($template['name']),
            'layout_json' => $template['layout_json'],
            'is_featured' => $template['is_featured'] ?? 0,
            'created_at' => isset($template['created_at']) ? date('F d Y, h:i:s A', strtotime($template['created_at'])) : 'N/A',
            'updated_at' => isset($template['updated_at']) ? date('F d Y, h:i:s A', strtotime($template['updated_at'])) : null
        ];
        
        return $this->response->setJSON([
            'status' => 'success',
            'data' => $templateData
        ]);
    }
    
    /**
     * Delete template
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
        
        $templatesModel = new GridTemplatesModel();
        
        // Find the template by ID
        $template = $templatesModel->find($id);
        
        if ($template) {
            // Delete the template record
            $deleted = $templatesModel->delete($id);
            
            if ($deleted) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Template deleted successfully'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Failed to delete template'
                ]);
            }
        }
        
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Template not found'
        ]);
    }
    
    /**
     * Toggle featured status
     */
    public function toggleFeatured($id)
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
        
        $templatesModel = new GridTemplatesModel();
        $template = $templatesModel->find($id);
        
        if ($template) {
            $newStatus = isset($template['is_featured']) && $template['is_featured'] == 1 ? 0 : 1;
            $templatesModel->update($id, ['is_featured' => $newStatus]);
            
            return $this->response->setJSON([
                'status' => 'success',
                'message' => $newStatus == 1 ? 'Template marked as featured' : 'Template removed from featured',
                'is_featured' => $newStatus
            ]);
        }
        
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Template not found'
        ]);
    }
}