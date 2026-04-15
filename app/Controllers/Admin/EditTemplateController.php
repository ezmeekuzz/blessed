<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use App\Models\GridTemplatesModel;

class EditTemplateController extends SessionController
{
    public function index($id = null)
    {
        // Check if user is logged in
        if (!$this->session->get('AdminLoggedIn')) {
            return redirect()->to('/admin/login');
        }
        
        $gridTemplatesModel = new GridTemplatesModel();
        $template = $gridTemplatesModel->find($id);
        
        if (!$template) {
            return redirect()->to('/admin/templates-masterlist')->with('error', 'Template not found');
        }
        
        $data = [
            'title' => 'The Blessed Manifest | Edit Grid Template',
            'activeMenu' => 'templates',
            'template' => $template
        ];
        
        return view('pages/admin/edit-template', $data);
    }
    
    public function update($id = null)
    {
        // Check if this is an AJAX request
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request method.'
            ]);
        }
        
        $gridTemplatesModel = new GridTemplatesModel();
        
        // Check if template exists
        $existingTemplate = $gridTemplatesModel->find($id);
        if (!$existingTemplate) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Template not found.'
            ]);
        }
        
        // Validation rules
        $rules = [
            'name' => 'required|min_length[3]|max_length[200]',
            'layout_json' => 'required'
        ];
        
        if (!$this->validate($rules)) {
            $errors = $this->validator->getErrors();
            $errorMessages = [];
            foreach ($errors as $field => $error) {
                $errorMessages[] = $error;
            }
            
            return $this->response->setJSON([
                'success' => false,
                'message' => implode('<br>', $errorMessages)
            ]);
        }
        
        // Validate JSON format
        $layoutJson = $this->request->getPost('layout_json');
        $decodedJson = json_decode($layoutJson);
        if (!$decodedJson) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid JSON format for layout.'
            ]);
        }
        
        // Validate layout structure
        if (!isset($decodedJson->rows) || !is_array($decodedJson->rows)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid layout structure. Must contain "rows" array.'
            ]);
        }
        
        // Prepare data
        $data = [
            'name' => $this->request->getPost('name'),
            'layout_json' => $layoutJson
        ];
        
        // Update database
        if ($gridTemplatesModel->update($id, $data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Grid template updated successfully!',
                'redirect' => base_url('admin/templates-masterlist')
            ]);
        }
        
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to update template. Please try again.'
        ]);
    }
    
    /**
     * Get template data for AJAX preview
     */
    public function getTemplateData($id = null)
    {
        // Check if user is logged in
        if (!$this->session->get('AdminLoggedIn')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized'
            ]);
        }
        
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request'
            ]);
        }
        
        $gridTemplatesModel = new GridTemplatesModel();
        $template = $gridTemplatesModel->find($id);
        
        if (!$template) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Template not found'
            ]);
        }
        
        return $this->response->setJSON([
            'success' => true,
            'data' => [
                'grid_template_id' => $template['grid_template_id'],
                'name' => $template['name'],
                'layout_json' => $template['layout_json'],
                'is_featured' => $template['is_featured'] ?? 0
            ]
        ]);
    }
}