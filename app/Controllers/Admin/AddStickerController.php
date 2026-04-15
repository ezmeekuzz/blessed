<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use App\Models\StickersModel;

class AddStickerController extends SessionController
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

    public function index()
    {
        // Check if user is logged in
        if (!$this->session->get('AdminLoggedIn')) {
            return redirect()->to('/admin/login');
        }

        $data = [
            'title' => 'The Blessed Manifest | Add Sticker',
            'activeMenu' => 'addsticker'
        ];

        return view('pages/admin/add-sticker', $data);
    }

    /**
     * Handle sticker submission
     */
    public function store()
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

        // Set validation rules
        $this->setValidationRules();

        if (!$this->validate($this->validation->getRules())) {
            return $this->response->setJSON([
                'success' => false,
                'message' => $this->getFormattedErrors()
            ]);
        }

        // Handle file upload
        $imagePath = $this->uploadStickerImage();
        if (!$imagePath && $this->request->getPost('source_type') !== 'external') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to upload image. Please try again.'
            ]);
        }

        // Prepare data
        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'tags' => $this->request->getPost('tags'),
            'is_active' => $this->request->getPost('status') === 'active' ? 1 : 0,
            'image_url' => $imagePath ?? $this->request->getPost('image_url')
        ];

        // Save to database
        if ($this->stickersModel->insert($data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Sticker added successfully!',
                'sticker_id' => $this->stickersModel->getInsertID(),
                'redirect' => base_url('admin/sticker-masterlist')
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to add sticker. Please try again.'
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
     * @return string|null File path or null if upload fails
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