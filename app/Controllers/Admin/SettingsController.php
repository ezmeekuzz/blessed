<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SettingsModel;

class SettingsController extends SessionController
{
    protected $settingsModel;
    
    public function __construct()
    {
        //parent::__construct();
        $this->settingsModel = new SettingsModel();
    }
    
    public function index()
    {
        // Get settings from database
        $settings = $this->settingsModel->find(1);
        
        // If no settings exist, create default record with initial values
        if (!$settings) {
            $defaultSettings = [
                'site_name' => 'The Blessed Manifest',
                'site_tagline' => '',
                'site_description' => '',
                'site_logo' => '',
                'site_favicon' => '',
                'timezone' => 'UTC',
                'date_format' => 'Y-m-d',
                'default_language' => 'en',
                'currency' => 'USD',
                'currency_symbol_position' => 'left',
                'decimal_separator' => '.',
                'primary_color' => '#4e73df',
                'secondary_color' => '#1cc88a',
                'allow_registration' => 1,
                'email_verification' => 0,
                'admin_email' => '',
                'email_from' => '',
                'email_from_name' => 'The Blessed Manifest',
                'use_smtp' => 0,
                'smtp_host' => '',
                'smtp_port' => 587,
                'smtp_user' => '',
                'smtp_pass' => '',
                'smtp_encryption' => 'tls'
            ];
            
            $this->settingsModel->insert($defaultSettings);
            $settings = $this->settingsModel->find(1);
        }
        
        $data = [
            'title' => 'The Blessed Manifest | Settings',
            'activeMenu' => 'settings',
            'settings' => $settings
        ];

        return view('pages/admin/settings', $data);
    }
    
    public function update()
    {
        // Validate input
        $rules = [
            'site_name' => 'permit_empty|min_length[3]|max_length[100]',
            'site_tagline' => 'permit_empty|max_length[200]',
            'site_description' => 'permit_empty|max_length[500]',
            'timezone' => 'permit_empty',
            'date_format' => 'permit_empty',
            'default_language' => 'permit_empty',
            'currency' => 'permit_empty|max_length[3]',
            'currency_symbol_position' => 'permit_empty',
            'decimal_separator' => 'permit_empty|max_length[1]',
            'admin_email' => 'permit_empty|valid_email',
            'email_from' => 'permit_empty|valid_email',
            'email_from_name' => 'permit_empty|max_length[100]',
            'smtp_host' => 'permit_empty',
            'smtp_port' => 'permit_empty|integer',
            'smtp_user' => 'permit_empty',
            'smtp_encryption' => 'permit_empty',
            'primary_color' => 'permit_empty|regex_match[/^#[a-fA-F0-9]{6}$/]',
            'secondary_color' => 'permit_empty|regex_match[/^#[a-fA-F0-9]{6}$/]',
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }
        
        // Get current settings to check existing files
        $currentSettings = $this->settingsModel->find(1);
        
        // Handle file uploads for logo and favicon
        $logoPath = $this->handleFileUpload('site_logo', 'logos', ['jpg', 'jpeg', 'png', 'svg', 'webp'], 2048);
        $faviconPath = $this->handleFileUpload('site_favicon', 'favicons', ['ico', 'png', 'jpg', 'jpeg'], 1024);
        
        // Prepare data to save
        $settingsData = $this->request->getPost();
        
        // Remove non-database fields
        unset($settingsData['remove_logo'], $settingsData['remove_favicon']);
        
        // Override file paths if new files were uploaded
        if ($logoPath) {
            // Delete old logo if exists
            if (!empty($currentSettings['site_logo']) && file_exists(WRITEPATH . '../public/' . $currentSettings['site_logo'])) {
                unlink(WRITEPATH . '../public/' . $currentSettings['site_logo']);
            }
            $settingsData['site_logo'] = $logoPath;
        }
        
        if ($faviconPath) {
            // Delete old favicon if exists
            if (!empty($currentSettings['site_favicon']) && file_exists(WRITEPATH . '../public/' . $currentSettings['site_favicon'])) {
                unlink(WRITEPATH . '../public/' . $currentSettings['site_favicon']);
            }
            $settingsData['site_favicon'] = $faviconPath;
        }
        
        // Handle removal flags
        if ($this->request->getPost('remove_logo')) {
            if (!empty($currentSettings['site_logo']) && file_exists(WRITEPATH . '../public/' . $currentSettings['site_logo'])) {
                unlink(WRITEPATH . '../public/' . $currentSettings['site_logo']);
            }
            $settingsData['site_logo'] = '';
        }
        
        if ($this->request->getPost('remove_favicon')) {
            if (!empty($currentSettings['site_favicon']) && file_exists(WRITEPATH . '../public/' . $currentSettings['site_favicon'])) {
                unlink(WRITEPATH . '../public/' . $currentSettings['site_favicon']);
            }
            $settingsData['site_favicon'] = '';
        }
        
        // Convert checkbox values to proper boolean/int
        $checkboxFields = ['allow_registration', 'email_verification', 'use_smtp'];
        foreach ($checkboxFields as $field) {
            $settingsData[$field] = $this->request->getPost($field) ? 1 : 0;
        }
        
        // Handle SMTP password - only update if provided
        if (empty($settingsData['smtp_pass'])) {
            unset($settingsData['smtp_pass']);
        }
        
        // Update settings
        if ($this->settingsModel->update(1, $settingsData)) {
            return redirect()->to('/admin/settings')
                ->with('success', 'Settings updated successfully!');
        }
        
        return redirect()->back()
            ->withInput()
            ->with('error', 'Failed to update settings. Please try again.');
    }
    
    private function handleFileUpload($fieldName, $subDir, $allowedTypes, $maxSize)
    {
        $file = $this->request->getFile($fieldName);
        
        // Check if file was uploaded
        if (!$file || !$file->isValid() || $file->getError() !== UPLOAD_ERR_OK) {
            return null;
        }
        
        // Validate file extension
        $extension = strtolower($file->getExtension());
        if (!in_array($extension, $allowedTypes)) {
            return null;
        }
        
        // Validate file size (KB to bytes)
        if ($file->getSize() > $maxSize * 1024) {
            return null;
        }
        
        // Generate unique name and move file
        $newName = $file->getRandomName();
        $uploadPath = ROOTPATH . 'public/uploads/' . $subDir;
        
        // Create directory if not exists
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }
        
        if ($file->move($uploadPath, $newName)) {
            return 'uploads/' . $subDir . '/' . $newName;
        }
        
        return null;
    }
}