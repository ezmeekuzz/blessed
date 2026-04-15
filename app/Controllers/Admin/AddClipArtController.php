<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use App\Models\ClipArtsModel;

class AddClipArtController extends SessionController
{
    protected $clipArtsModel;
    protected $validation;
    protected $session;
    protected $db;

    public function __construct()
    {
        $this->clipArtsModel = new ClipArtsModel();
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
            'title' => 'The Blessed Manifest | Add Clip Art',
            'activeMenu' => 'addclipart'
        ];

        return view('pages/admin/add-clipart', $data);
    }

    /**
     * Handle clipart submission
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

        $sourceType = $this->request->getPost('source_type');
        $imagePath = null;
        
        // Handle based on source type
        if ($sourceType === 'local') {
            $imagePath = $this->uploadClipartImage();
            if (!$imagePath) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to upload image. Please try again.'
                ]);
            }
        } else {
            // External URL - store as is (full URL)
            $imagePath = $this->request->getPost('image_url');
        }

        // Prepare data
        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'tags' => $this->request->getPost('tags'),
            'is_active' => $this->request->getPost('status') === 'active' ? 1 : 0,
            'image_url' => $imagePath  // Store relative path for local, full URL for external
        ];

        // Save to database
        if ($this->clipArtsModel->insert($data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Clip art added successfully!',
                'clip_art_id' => $this->clipArtsModel->getInsertID(),
                'redirect' => base_url('admin/clipart-masterlist')
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to add clip art. Please try again.'
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
     * Upload clipart image
     * @return string|null Relative file path or null if upload fails
     */
    private function uploadClipartImage()
    {
        $file = $this->request->getFile('clipart_image');

        if (!$file || !$file->isValid()) {
            return null;
        }

        // Validate file
        $validationRule = [
            'clipart_image' => [
                'label' => 'Image File',
                'rules' => 'is_image[clipart_image]|max_size[clipart_image,5120]|mime_in[clipart_image,image/jpg,image/jpeg,image/png,image/gif,image/webp,image/svg+xml]',
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
        $uploadPath = FCPATH . 'uploads/cliparts/';

        // Create directory if not exists
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Move file to upload directory
        if ($file->move($uploadPath, $newFileName)) {
            // Return ONLY the relative path (no base_url)
            return 'uploads/cliparts/' . $newFileName;
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