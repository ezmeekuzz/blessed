<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use App\Models\GridTemplatesModel;
use App\Models\LayoutTemplatesModel;

class EditLayoutTemplateController extends SessionController
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
    
    public function index($id = null)
    {
        if (!$this->session->get('AdminLoggedIn')) {
            return redirect()->to('/admin/login');
        }
        
        if (!$id) {
            return redirect()->to('/admin/layout-templates-masterlist')->with('error', 'Invalid layout ID.');
        }
        
        $layoutTemplatesModel = new LayoutTemplatesModel();
        $layout = $layoutTemplatesModel->getLayoutWithGrid($id);
        
        if (!$layout) {
            return redirect()->to('/admin/layout-templates-masterlist')->with('error', 'Layout not found.');
        }
        
        $gridTemplatesModel = new GridTemplatesModel();
        $gridTemplates = $gridTemplatesModel->findAll();
        
        // Ensure images_data is properly parsed as array
        $imagesData = json_decode($layout['images_data'], true);
        if (!is_array($imagesData)) {
            $imagesData = ['images' => []];
        }
        if (!isset($imagesData['images'])) {
            $imagesData = ['images' => $imagesData];
        }
        
        // Ensure grid_layout is properly parsed
        $gridLayout = is_string($layout['grid_layout']) ? json_decode($layout['grid_layout'], true) : $layout['grid_layout'];
        
        $data = [
            'title' => 'The Blessed Manifest | Edit Layout Template',
            'activeMenu' => 'layouttemplates',
            'gridTemplates' => $gridTemplates,
            'layout' => [
                'layout_template_id' => $layout['layout_template_id'],
                'name' => $layout['name'],
                'grid_template_id' => $layout['grid_template_id'],
                'grid_name' => $layout['grid_name'],
                'grid_layout' => $gridLayout,
                'images_data' => $imagesData,
                'created_at' => $layout['created_at'],
                'updated_at' => $layout['updated_at']
            ],
            'isEdit' => true
        ];
        
        return view('pages/admin/edit-layout-template', $data);
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
        if (!$existingLayout) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Layout template not found.'
            ]);
        }
        
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
        
        // Delete old images that are no longer used
        foreach ($oldImages as $oldImage) {
            if (isset($oldImage['url']) && !in_array($oldImage['url'], $newImageUrls)) {
                $this->deleteImageFile($oldImage['url']);
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
}