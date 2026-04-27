<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use App\Models\GridTemplatesModel;
use App\Models\LayoutTemplatesModel;

class AddLayoutTemplateController extends SessionController
{
    private $uploadPath;
    
    public function __construct()
    {
        //parent::__construct();
        $this->uploadPath = FCPATH . 'uploads/layout_images/';
        
        if (!is_dir($this->uploadPath)) {
            mkdir($this->uploadPath, 0777, true);
        }
    }
    
    public function index()
    {
        if (!$this->session->get('AdminLoggedIn')) {
            return redirect()->to('/admin/login');
        }
        
        $gridTemplatesModel = new GridTemplatesModel();
        $gridTemplates = $gridTemplatesModel->findAll();
        
        $data = [
            'title' => 'The Blessed Manifest | Create Layout Template',
            'activeMenu' => 'addlayouttemplate',
            'gridTemplates' => $gridTemplates,
            'isEdit' => false
        ];

        return view('pages/admin/add-layout-template', $data);
    }
    
    public function edit($id = null)
    {
        if (!$this->session->get('AdminLoggedIn')) {
            return redirect()->to('/admin/login');
        }
        
        $layoutTemplatesModel = new LayoutTemplatesModel();
        $layout = $layoutTemplatesModel->getLayoutWithGrid($id);
        
        if (!$layout) {
            return redirect()->to('/admin/layout-templates-masterlist')->with('error', 'Layout not found.');
        }
        
        $gridTemplatesModel = new GridTemplatesModel();
        $gridTemplates = $gridTemplatesModel->findAll();
        
        $data = [
            'title' => 'The Blessed Manifest | Edit Layout Template',
            'activeMenu' => 'addlayouttemplate',
            'gridTemplates' => $gridTemplates,
            'layout' => $layout,
            'isEdit' => true
        ];
        
        return view('pages/admin/add-layout-template', $data);
    }
    
    private function saveBase64Image($base64String, $filename)
    {
        try {
            if (preg_match('/^data:image\/(\w+);base64,/', $base64String, $type)) {
                $base64String = substr($base64String, strpos($base64String, ',') + 1);
                $type = strtolower($type[1]);
                
                $allowedTypes = ['jpeg', 'jpg', 'png', 'gif', 'webp'];
                if (!in_array($type, $allowedTypes)) {
                    return false;
                }
                
                if ($type == 'jpeg') $type = 'jpg';
                $filename = $filename . '.' . $type;
            } else {
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeType = finfo_buffer($finfo, base64_decode($base64String));
                finfo_close($finfo);
                
                $extension = '';
                switch ($mimeType) {
                    case 'image/jpeg': $extension = 'jpg'; break;
                    case 'image/png': $extension = 'png'; break;
                    case 'image/gif': $extension = 'gif'; break;
                    case 'image/webp': $extension = 'webp'; break;
                    default: return false;
                }
                $filename = $filename . '.' . $extension;
            }
            
            $decoded = base64_decode($base64String);
            if ($decoded === false || $decoded === null) {
                return false;
            }
            
            $filePath = $this->uploadPath . $filename;
            $bytesWritten = file_put_contents($filePath, $decoded);
            
            if ($bytesWritten !== false) {
                return base_url('uploads/layout_images/' . $filename);
            }
            
            return false;
        } catch (\Exception $e) {
            log_message('error', 'Failed to save base64 image: ' . $e->getMessage());
            return false;
        }
    }
    
    private function isNameExists($name, $excludeId = null)
    {
        $layoutTemplatesModel = new LayoutTemplatesModel();
        
        if ($excludeId) {
            $exists = $layoutTemplatesModel
                ->where('name', $name)
                ->where('layout_template_id !=', $excludeId)
                ->first();
        } else {
            $exists = $layoutTemplatesModel
                ->where('name', $name)
                ->first();
        }
        
        return !empty($exists);
    }
    
    public function save()
    {
        if (!$this->session->get('AdminLoggedIn')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Session expired. Please login again.',
                'redirect' => '/admin/login'
            ]);
        }
        
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request method.'
            ]);
        }
        
        $layoutTemplatesModel = new LayoutTemplatesModel();
        
        $name = trim($this->request->getPost('name'));
        $gridTemplateId = $this->request->getPost('grid_template_id');
        $imagesDataJson = $this->request->getPost('images_data');
        
        if (empty($name)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Layout name is required.'
            ]);
        }
        
        if (strlen($name) < 3) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Layout name must be at least 3 characters.'
            ]);
        }
        
        if ($this->isNameExists($name)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'A layout template with the name "' . esc($name) . '" already exists.'
            ]);
        }
        
        if (empty($gridTemplateId)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please select a grid template.'
            ]);
        }
        
        $decodedImages = json_decode($imagesDataJson, true);
        if (!$decodedImages || !isset($decodedImages['images'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid images data format.'
            ]);
        }
        
        $savedImages = [];
        $imageIndex = 0;
        
        foreach ($decodedImages['images'] as $cellId => $image) {
            if (isset($image['base64']) && !empty($image['base64']) && strpos($image['base64'], 'data:image') === 0) {
                $timestamp = time();
                $random = uniqid();
                $cleanName = preg_replace('/[^a-zA-Z0-9]/', '_', pathinfo($image['name'], PATHINFO_FILENAME));
                $filename = $timestamp . '_' . $random . '_' . $cleanName;
                $imageUrl = $this->saveBase64Image($image['base64'], $filename);
                
                if ($imageUrl) {
                    $savedImages[$cellId] = [
                        'id' => uniqid(),
                        'url' => $imageUrl,
                        'name' => $image['name'],
                        'transform' => $image['transform'] ?? [
                            'left' => 0,
                            'top' => 0,
                            'scaleX' => 1,
                            'scaleY' => 1,
                            'angle' => 0
                        ]
                    ];
                } else {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Failed to save image: ' . $image['name']
                    ]);
                }
                $imageIndex++;
            } elseif (isset($image['url']) && !empty($image['url'])) {
                $savedImages[$cellId] = [
                    'id' => $image['id'] ?? uniqid(),
                    'url' => $image['url'],
                    'name' => $image['name'],
                    'transform' => $image['transform'] ?? [
                        'left' => 0,
                        'top' => 0,
                        'scaleX' => 1,
                        'scaleY' => 1,
                        'angle' => 0
                    ]
                ];
            }
        }
        
        $data = [
            'name' => $name,
            'grid_template_id' => $gridTemplateId,
            'images_data' => json_encode(['images' => $savedImages])
        ];
        
        if ($layoutTemplatesModel->insert($data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Layout template saved successfully! ' . count($savedImages) . ' image(s) saved.',
                'layout_id' => $layoutTemplatesModel->insertID(),
                'redirect' => base_url('admin/layout-templates-masterlist')
            ]);
        }
        
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to save layout template: ' . implode(', ', $layoutTemplatesModel->errors())
        ]);
    }
    
    public function update($id = null)
    {
        if (!$this->session->get('AdminLoggedIn')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Session expired. Please login again.',
                'redirect' => '/admin/login'
            ]);
        }
        
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request method.'
            ]);
        }
        
        if (!$id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid layout ID.'
            ]);
        }
        
        $layoutTemplatesModel = new LayoutTemplatesModel();
        
        $existingLayout = $layoutTemplatesModel->find($id);
        $oldImagesData = json_decode($existingLayout['images_data'], true);
        $oldImages = isset($oldImagesData['images']) ? $oldImagesData['images'] : [];
        
        $name = trim($this->request->getPost('name'));
        $gridTemplateId = $this->request->getPost('grid_template_id');
        $imagesDataJson = $this->request->getPost('images_data');
        
        if (empty($name)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Layout name is required.'
            ]);
        }
        
        if (strlen($name) < 3) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Layout name must be at least 3 characters.'
            ]);
        }
        
        if ($this->isNameExists($name, $id)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'A layout template with the name "' . esc($name) . '" already exists.'
            ]);
        }
        
        if (empty($gridTemplateId)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please select a grid template.'
            ]);
        }
        
        $decodedImages = json_decode($imagesDataJson, true);
        if (!$decodedImages || !isset($decodedImages['images'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid images data format.'
            ]);
        }
        
        $newImageUrls = [];
        $savedImages = [];
        $imageIndex = 0;
        
        foreach ($decodedImages['images'] as $cellId => $image) {
            if (isset($image['base64']) && !empty($image['base64']) && strpos($image['base64'], 'data:image') === 0) {
                $timestamp = time();
                $random = uniqid();
                $cleanName = preg_replace('/[^a-zA-Z0-9]/', '_', pathinfo($image['name'], PATHINFO_FILENAME));
                $filename = $timestamp . '_' . $random . '_' . $cleanName;
                $imageUrl = $this->saveBase64Image($image['base64'], $filename);
                
                if ($imageUrl) {
                    $savedImages[$cellId] = [
                        'id' => uniqid(),
                        'url' => $imageUrl,
                        'name' => $image['name'],
                        'transform' => $image['transform'] ?? [
                            'left' => 0,
                            'top' => 0,
                            'scaleX' => 1,
                            'scaleY' => 1,
                            'angle' => 0
                        ]
                    ];
                    $newImageUrls[] = $imageUrl;
                } else {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Failed to save image: ' . $image['name']
                    ]);
                }
                $imageIndex++;
            } elseif (isset($image['url']) && !empty($image['url'])) {
                $savedImages[$cellId] = [
                    'id' => $image['id'] ?? uniqid(),
                    'url' => $image['url'],
                    'name' => $image['name'],
                    'transform' => $image['transform'] ?? [
                        'left' => 0,
                        'top' => 0,
                        'scaleX' => 1,
                        'scaleY' => 1,
                        'angle' => 0
                    ]
                ];
                $newImageUrls[] = $image['url'];
            }
        }
        
        $data = [
            'name' => $name,
            'grid_template_id' => $gridTemplateId,
            'images_data' => json_encode(['images' => $savedImages])
        ];
        
        if ($layoutTemplatesModel->update($id, $data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Layout template updated successfully! ' . count($savedImages) . ' image(s) saved.',
                'redirect' => base_url('admin/layout-templates-masterlist')
            ]);
        }
        
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to update layout template.'
        ]);
    }
    
    public function checkName()
    {
        if (!$this->session->get('AdminLoggedIn')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Session expired.'
            ]);
        }
        
        $name = trim($this->request->getGet('name'));
        $excludeId = $this->request->getGet('exclude_id');
        
        if (empty($name)) {
            return $this->response->setJSON(['exists' => false]);
        }
        
        $exists = $this->isNameExists($name, $excludeId);
        
        return $this->response->setJSON([
            'exists' => $exists,
            'message' => $exists ? 'This name is already taken.' : 'Name is available.'
        ]);
    }
}