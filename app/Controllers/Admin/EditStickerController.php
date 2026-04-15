<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use App\Models\StickersModel;

class EditStickerController extends SessionController
{
    protected $stickersModel;
    protected $validation;
    protected $session;
    protected $db;

    public function __construct()
    {
        $this->stickersModel = new StickersModel();
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->db = \Config\Database::connect();
    }

    public function index($id)
    {
        // Check if user is logged in
        if (!$this->session->get('AdminLoggedIn')) {
            return redirect()->to('/admin/login');
        }

        // Get sticker data
        $sticker = $this->stickersModel->find($id);
        
        if (!$sticker) {
            return redirect()->to('/admin/sticker-masterlist')->with('error', 'Sticker not found');
        }

        $data = [
            'title' => 'The Blessed Manifest | Edit Sticker',
            'activeMenu' => 'stickermasterlist',
            'sticker' => $sticker
        ];

        return view('pages/admin/edit-sticker', $data);
    }

    /**
     * Update sticker
     */
    public function update($id)
    {
        // Check if user is logged in
        if (!$this->session->get('AdminLoggedIn')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please login first'
            ]);
        }

        // Check if this is an AJAX request
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request method.'
            ]);
        }

        // Get existing sticker
        $sticker = $this->stickersModel->find($id);
        if (!$sticker) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Sticker not found'
            ]);
        }

        // Set validation rules
        $this->setValidationRules();

        if (!$this->validate($this->validation->getRules())) {
            return $this->response->setJSON([
                'success' => false,
                'message' => $this->getFormattedErrors()
            ]);
        }

        $sourceType = $this->request->getPost('source_type');
        $imagePath = $sticker['image_url']; // Keep existing by default
        
        // Handle based on source type
        if ($sourceType === 'local') {
            // Check if a new file was uploaded
            $newFile = $this->request->getFile('sticker_image');
            if ($newFile && $newFile->isValid() && !$newFile->hasMoved()) {
                // Delete old image file if it exists and is local
                $oldImageUrl = $sticker['image_url'];
                $isOldExternal = filter_var($oldImageUrl, FILTER_VALIDATE_URL) && 
                                  (strpos($oldImageUrl, 'http://') === 0 || strpos($oldImageUrl, 'https://') === 0);
                
                if (!$isOldExternal && !empty($oldImageUrl)) {
                    $oldFilePath = FCPATH . $oldImageUrl;
                    $oldFilePath = str_replace('/', DIRECTORY_SEPARATOR, $oldFilePath);
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
                
                // Upload new image
                $newImagePath = $this->uploadStickerImage();
                if ($newImagePath) {
                    $imagePath = $newImagePath;
                }
            }
        } else {
            // External URL - use the provided URL
            $imagePath = $this->request->getPost('image_url');
        }

        // Prepare data
        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'tags' => $this->request->getPost('tags'),
            'is_active' => $this->request->getPost('status') === 'active' ? 1 : 0,
            'image_url' => $imagePath
        ];

        // Update database
        if ($this->stickersModel->update($id, $data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Sticker updated successfully!',
                'sticker_id' => $id,
                'redirect' => base_url('admin/sticker-masterlist')
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to update sticker. Please try again.'
        ]);
    }

    /**
     * Set validation rules
     */
    private function setValidationRules()
    {
        $this->validation->setRules([
            'title' => [
                'label' => 'Title',
                'rules' => 'required|min_length[3]|max_length[255]',
                'errors' => [
                    'required' => 'Title is required',
                    'min_length' => 'Title must be at least 3 characters',
                    'max_length' => 'Title cannot exceed 255 characters'
                ]
            ],
            'description' => [
                'label' => 'Description',
                'rules' => 'permit_empty|max_length[1000]'
            ],
            'tags' => [
                'label' => 'Tags',
                'rules' => 'permit_empty|max_length[500]'
            ],
            'source_type' => [
                'label' => 'Source Type',
                'rules' => 'required|in_list[local,external]'
            ],
            'status' => [
                'label' => 'Status',
                'rules' => 'required|in_list[active,inactive]'
            ]
        ]);
    }

    /**
     * Upload sticker image
     * @return string|null Relative file path or null if upload fails
     */
    private function uploadStickerImage()
    {
        $file = $this->request->getFile('sticker_image');

        if (!$file || !$file->isValid()) {
            return null;
        }

        // Validate file
        $validationRule = [
            'sticker_image' => [
                'label' => 'Image File',
                'rules' => 'is_image[sticker_image]|max_size[sticker_image,5120]|mime_in[sticker_image,image/jpg,image/jpeg,image/png,image/gif,image/webp,image/svg+xml]',
                'errors' => [
                    'is_image' => 'The file must be an image',
                    'max_size' => 'The image size must not exceed 5MB',
                    'mime_in' => 'Only JPG, JPEG, PNG, GIF, WEBP, and SVG images are allowed'
                ]
            ]
        ];

        if (!$this->validate($validationRule)) {
            return null;
        }

        // Generate unique filename
        $title = $this->request->getPost('title');
        $titleSlug = preg_replace('/[^a-zA-Z0-9]/', '_', strtolower($title));
        $newFileName = $titleSlug . '_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $file->getExtension();

        // Upload directory
        $uploadPath = FCPATH . 'uploads/stickers/';

        // Create directory if not exists
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Move file to upload directory
        if ($file->move($uploadPath, $newFileName)) {
            return 'uploads/stickers/' . $newFileName;
        }

        return null;
    }

    /**
     * Get formatted error messages
     * @return string
     */
    private function getFormattedErrors()
    {
        $errors = $this->validation->getErrors();
        $errorMessages = [];
        foreach ($errors as $field => $error) {
            $errorMessages[] = $error;
        }
        return implode('<br>', $errorMessages);
    }
}