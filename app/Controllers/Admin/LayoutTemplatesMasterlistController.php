<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\LayoutTemplatesModel;

class LayoutTemplatesMasterlistController extends SessionController
{
    protected $db;
    protected $uploadPath;
    
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->uploadPath = FCPATH . 'uploads/layout_images/';
    }
    
    public function index()
    {
        // Check if user is logged in
        if (!$this->session->get('AdminLoggedIn')) {
            return redirect()->to('/admin/login');
        }
        
        $data = [
            'title' => 'The Blessed Manifest | Layout Templates Masterlist',
            'activeMenu' => 'layouttemplates'
        ];
        return view('pages/admin/layout-templates-masterlist', $data);
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
        
        // Get request parameters for DataTables
        $draw = $this->request->getPost('draw') ?? 1;
        $start = $this->request->getPost('start') ?? 0;
        $length = $this->request->getPost('length') ?? 25;
        $search = $this->request->getPost('search')['value'] ?? '';
        $orderColumn = $this->request->getPost('order')[0]['column'] ?? 0;
        $orderDir = $this->request->getPost('order')[0]['dir'] ?? 'desc';
        
        $db = db_connect();
        $builder = $db->table('layout_templates');
        $builder->select('layout_templates.*, grid_templates.name as grid_name, grid_templates.layout_json as grid_layout');
        $builder->join('grid_templates', 'grid_templates.grid_template_id = layout_templates.grid_template_id');
        
        // Get total count (without filters)
        $totalRecords = $builder->countAllResults(false);
        
        // Apply search
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('layout_templates.name', $search)
                    ->orLike('grid_templates.name', $search)
                    ->groupEnd();
        }
        
        // Get filtered count (with search applied)
        $filteredRecords = $builder->countAllResults(false);
        
        // Apply ordering
        $columns = ['layout_template_id', 'name', 'grid_name', 'grid_template_id', 'created_at', 'updated_at'];
        if (isset($columns[$orderColumn])) {
            $builder->orderBy($columns[$orderColumn], $orderDir);
        } else {
            $builder->orderBy('layout_template_id', 'desc');
        }
        
        // Apply pagination
        $builder->limit($length, $start);
        
        // Execute query
        $query = $builder->get();
        $results = $query->getResultArray();
        
        // Process data and calculate image counts
        $data = [];
        foreach ($results as $row) {
            $imageCount = 0;
            $imagesDataRaw = $row['images_data'] ?? '';
            
            if (!empty($imagesDataRaw)) {
                $imagesData = json_decode($imagesDataRaw, true);
                if ($imagesData) {
                    // Check for images under 'images' key (from AddLayoutTemplateController save method)
                    if (isset($imagesData['images']) && is_array($imagesData['images'])) {
                        $imageCount = count($imagesData['images']);
                    } 
                    // Check for images directly in the array
                    elseif (is_array($imagesData)) {
                        // Exclude metadata keys
                        if (!isset($imagesData['placed_at']) && !isset($imagesData['total_images'])) {
                            $imageCount = count($imagesData);
                        }
                    }
                }
            }
            
            $data[] = [
                'layout_template_id' => $row['layout_template_id'],
                'name' => $row['name'],
                'images_data' => $row['images_data'],
                'grid_template_id' => $row['grid_template_id'],
                'created_at' => $row['created_at'],
                'updated_at' => $row['updated_at'],
                'grid_name' => $row['grid_name'],
                'grid_layout' => $row['grid_layout'],
                'image_count' => $imageCount
            ];
        }
        
        return $this->response->setJSON([
            'draw' => intval($draw),
            'recordsTotal' => intval($totalRecords),
            'recordsFiltered' => intval($filteredRecords),
            'data' => $data
        ]);
    }
    
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
        
        $layoutTemplatesModel = new LayoutTemplatesModel();
        $template = $layoutTemplatesModel->getLayoutWithGrid($id);
        
        if (!$template) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Layout template not found'
            ]);
        }
        
        // Parse images data correctly
        $imagesData = json_decode($template['images_data'], true);
        
        // Get images array (handle both structures)
        $images = [];
        if ($imagesData) {
            if (isset($imagesData['images']) && is_array($imagesData['images'])) {
                $images = $imagesData['images'];
            } elseif (is_array($imagesData)) {
                $images = $imagesData;
            }
        }
        
        $imageCount = count($images);
        
        // Parse grid layout
        $gridLayout = json_decode($template['grid_layout'], true);
        
        // Prepare data for view
        $templateData = [
            'layout_template_id' => $template['layout_template_id'],
            'name' => htmlspecialchars($template['name']),
            'grid_name' => htmlspecialchars($template['grid_name']),
            'grid_template_id' => $template['grid_template_id'],
            'images_data' => $template['images_data'],
            'images' => $images,
            'image_count' => $imageCount,
            'grid_layout' => $gridLayout,
            'created_at' => isset($template['created_at']) ? date('F d Y, h:i:s A', strtotime($template['created_at'])) : 'N/A',
            'updated_at' => isset($template['updated_at']) ? date('F d Y, h:i:s A', strtotime($template['updated_at'])) : null
        ];
        
        return $this->response->setJSON([
            'status' => 'success',
            'data' => $templateData
        ]);
    }
    
    /**
     * Delete image file from the server
     * @param string $imageUrl
     * @return bool
     */
    private function deleteImageFile($imageUrl)
    {
        if (empty($imageUrl)) {
            return false;
        }
        
        $filename = basename($imageUrl);
        $filePath = $this->uploadPath . $filename;
        
        if (file_exists($filePath) && is_file($filePath)) {
            return unlink($filePath);
        }
        
        return false;
    }
    
    /**
     * Delete all images associated with a layout
     * @param array $images
     * @return int Number of deleted images
     */
    private function deleteLayoutImages($images)
    {
        $deletedCount = 0;
        
        foreach ($images as $image) {
            if (isset($image['url']) && !empty($image['url'])) {
                if ($this->deleteImageFile($image['url'])) {
                    $deletedCount++;
                }
            }
        }
        
        return $deletedCount;
    }
    
    /**
     * Delete layout template and its associated images
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
        
        $layoutTemplatesModel = new LayoutTemplatesModel();
        
        // Find the template by ID
        $template = $layoutTemplatesModel->find($id);
        
        if (!$template) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Layout template not found'
            ]);
        }
        
        // Parse images data to get all image URLs
        $imagesData = json_decode($template['images_data'], true);
        $images = [];
        
        if ($imagesData) {
            if (isset($imagesData['images']) && is_array($imagesData['images'])) {
                $images = $imagesData['images'];
            } elseif (is_array($imagesData)) {
                $images = $imagesData;
            }
        }
        
        // Delete all associated image files
        $deletedImagesCount = $this->deleteLayoutImages($images);
        
        // Delete the template record
        $deleted = $layoutTemplatesModel->delete($id);
        
        if ($deleted) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Layout template deleted successfully. ' . $deletedImagesCount . ' image(s) removed from server.'
            ]);
        }
        
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Failed to delete layout template'
        ]);
    }
    
    /**
     * Duplicate layout template (also duplicates images? No, references same images)
     */
    public function duplicate($id)
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
        
        $layoutTemplatesModel = new LayoutTemplatesModel();
        
        // Find the template by ID
        $template = $layoutTemplatesModel->find($id);
        
        if ($template) {
            // Create duplicate data (images are referenced, not duplicated)
            $duplicateData = [
                'name' => $template['name'] . ' (Copy)',
                'grid_template_id' => $template['grid_template_id'],
                'images_data' => $template['images_data'] // Reference same images
            ];
            
            // Insert duplicate
            $inserted = $layoutTemplatesModel->insert($duplicateData);
            
            if ($inserted) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Layout template duplicated successfully'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Failed to duplicate layout template'
                ]);
            }
        }
        
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Layout template not found'
        ]);
    }
}