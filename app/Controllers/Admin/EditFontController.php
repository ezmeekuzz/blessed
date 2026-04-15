<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use App\Models\FontsModel;

class EditFontController extends SessionController
{
    public function index($id)
    {
        // Check if user is logged in
        if (!$this->session->get('AdminLoggedIn')) {
            return redirect()->to('/admin/login');
        }
        
        $fontsModel = new FontsModel();
        $font = $fontsModel->find($id);
        
        if (!$font) {
            return redirect()->to('/admin/font-masterlist')->with('error', 'Font not found.');
        }
        
        $data = [
            'title' => 'The Blessed Manifest | Edit Font',
            'activeMenu' => 'fonts',
            'font' => $font
        ];
        
        return view('pages/admin/edit-font', $data);
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
        
        $fontsModel = new FontsModel();
        
        // Find existing font
        $existingFont = $fontsModel->find($id);
        if (!$existingFont) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Font not found'
            ]);
        }
        
        // Validation rules
        $rules = [
            'font_name' => 'required|min_length[2]|max_length[100]',
            'source_type' => 'required|in_list[local,external]',
            'status' => 'required|in_list[active,inactive]'
        ];
        
        // Conditional validation based on source_type
        $sourceType = $this->request->getPost('source_type');
        if ($sourceType === 'external') {
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
        $filePath = $existingFont['file_path'];
        $removeFile = $this->request->getPost('remove_file') == 1;
        
        if ($sourceType === 'local') {
            $file = $this->request->getFile('font_file');
            
            // If remove file is checked, delete existing file
            if ($removeFile && !empty($existingFont['file_path'])) {
                $oldFilePath = FCPATH . $existingFont['file_path'];
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
                $filePath = null;
            }
            
            // If new file is uploaded
            if ($file && $file->isValid() && !$file->hasMoved()) {
                // Delete old file if exists
                if (!empty($existingFont['file_path']) && !$removeFile) {
                    $oldFilePath = FCPATH . $existingFont['file_path'];
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
                
                // Upload new file
                $fontName = $this->request->getPost('font_name');
                $fontName = preg_replace('/[^a-zA-Z0-9]/', '_', strtolower($fontName));
                $newFileName = $fontName . '_' . time() . '.' . $file->getExtension();
                
                $uploadPath = FCPATH . 'uploads/fonts/';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                
                if ($file->move($uploadPath, $newFileName)) {
                    $filePath = 'uploads/fonts/' . $newFileName;
                }
            } elseif ($removeFile) {
                $filePath = null;
            }
        } else {
            // For external fonts, ensure file_path is null
            if (!empty($existingFont['file_path'])) {
                $oldFilePath = FCPATH . $existingFont['file_path'];
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }
            $filePath = null;
        }
        
        // Prepare data
        $data = [
            'font_name' => $this->request->getPost('font_name'),
            'source_type' => $sourceType,
            'file_path' => $filePath,
            'font_link' => $sourceType === 'external' ? $this->request->getPost('font_link') : null,
            'status' => $this->request->getPost('status'),
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0
        ];
        
        // Update database
        if ($fontsModel->update($id, $data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Font updated successfully!',
                'redirect' => base_url('admin/font-masterlist')
            ]);
        }
        
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to update font. Please try again.'
        ]);
    }
}