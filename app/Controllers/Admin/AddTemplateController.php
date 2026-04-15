<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use App\Models\GridTemplatesModel;

class AddTemplateController extends SessionController
{
    public function index()
    {
        // Check if user is logged in
        if (!$this->session->get('AdminLoggedIn')) {
            return redirect()->to('/admin/login');
        }
        
        $data = [
            'title' => 'The Blessed Manifest | Add Grid Template',
            'activeMenu' => 'addtemplate'
        ];
        
        return view('pages/admin/add-template', $data);
    }
    
    public function insert()
    {
        // Check if this is an AJAX request
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request method.'
            ]);
        }
        
        $gridTemplatesModel = new GridTemplatesModel();
        
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
            'layout_json' => $layoutJson
        ];
        
        // Save to database
        if ($gridTemplatesModel->insert($data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Grid template added successfully!',
                'template_id' => $gridTemplatesModel->insertID(),
                'redirect' => base_url('admin/templates-masterlist')
            ]);
        }
        
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to add template. Please try again.'
        ]);
    }
}