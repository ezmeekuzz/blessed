<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use App\Models\GridTemplatesModel;

class EditTemplateController extends SessionController
{
    public function index($id)
    {
        // Check if user is logged in
        if (!$this->session->get('AdminLoggedIn')) {
            return redirect()->to('/admin/login');
        }
        
        $templatesModel = new GridTemplatesModel();
        $template = $templatesModel->find($id);
        
        if (!$template) {
            return redirect()->to('/admin/templates-masterlist')->with('error', 'Template not found.');
        }
        
        $data = [
            'title' => 'The Blessed Manifest | Edit Grid Template',
            'activeMenu' => 'templates',
            'template' => $template
        ];
        
        return view('pages/admin/edit-template', $data);
    }
    
    public function update($id)
    {
        // Check if user is logged in
        if (!$this->session->get('AdminLoggedIn')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized'
            ]);
        }
        
        // Check if it's an AJAX request
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request method.'
            ]);
        }
        
        $templatesModel = new GridTemplatesModel();
        
        // Find existing template
        $existingTemplate = $templatesModel->find($id);
        if (!$existingTemplate) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Template not found'
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
        if (!json_decode($layoutJson)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid JSON format for layout.'
            ]);
        }
        
        // Prepare data
        $data = [
            'name' => $this->request->getPost('name'),
            'layout_json' => $layoutJson,
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0
        ];
        
        // Update database
        if ($templatesModel->update($id, $data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Template updated successfully!',
                'redirect' => base_url('admin/templates-masterlist')
            ]);
        }
        
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to update template. Please try again.'
        ]);
    }
}