<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\FontsModel;

class AddFontController extends SessionController
{
    public function index()
    {
        $data = [
            'title' => 'The Blessed Manifest | Add Font',
            'activeMenu' => 'addfont'
        ];

        return view('pages/admin/add-font', $data);
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
        
        $fontsModel = new FontsModel();
        
        // Validation rules
        $rules = [
            'font_name' => 'required|min_length[2]|max_length[100]',
            'source_type' => 'required|in_list[local,external]',
            'status' => 'required|in_list[active,inactive]'
        ];
        
        // Conditional validation based on source_type
        if ($this->request->getPost('source_type') === 'local') {
            $rules['font_file'] = 'uploaded[font_file]|max_size[font_file,10240]|ext_in[font_file,ttf,otf,woff,woff2,eot]';
        } elseif ($this->request->getPost('source_type') === 'external') {
            $rules['font_link'] = 'required|valid_url|max_length[500]';
        }
        
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
        
        // Handle file upload for local fonts
        $filePath = null;
        if ($this->request->getPost('source_type') === 'local') {
            $filePath = $this->uploadFontFile();
            if (!$filePath) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to upload font file. Please try again.'
                ]);
            }
        }
        
        // Prepare data
        $data = [
            'font_name' => $this->request->getPost('font_name'),
            'source_type' => $this->request->getPost('source_type'),
            'file_path' => $filePath,
            'font_link' => $this->request->getPost('source_type') === 'external' ? $this->request->getPost('font_link') : null,
            'status' => $this->request->getPost('status'),
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        // Save to database
        if ($fontsModel->insert($data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Font added successfully!',
                'font_id' => $fontsModel->insertID(),
                'redirect' => base_url('admin/font-masterlist')
            ]);
        }
        
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to add font. Please try again.'
        ]);
    }
    
    /**
     * Upload font file
     * @return string|null File path or null if upload fails
     */
    private function uploadFontFile()
    {
        $file = $this->request->getFile('font_file');
        
        if (!$file || !$file->isValid()) {
            return null;
        }
        
        // Generate unique filename
        $fontName = $this->request->getPost('font_name');
        $fontName = preg_replace('/[^a-zA-Z0-9]/', '_', strtolower($fontName));
        $newFileName = $fontName . '_' . time() . '.' . $file->getExtension();
        
        // Upload directory
        $uploadPath = FCPATH . 'uploads/fonts/';
        
        // Create directory if not exists
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }
        
        // Move file to upload directory
        if ($file->move($uploadPath, $newFileName)) {
            return 'uploads/fonts/' . $newFileName;
        }
        
        return null;
    }
}