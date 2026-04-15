<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProductsModel;
use App\Models\SizesModel;
use App\Models\ColorsModel;
use App\Models\ProductImagesModel;
use App\Models\ProductCategoriesModel;

class AddProductController extends SessionController
{
    protected $productsModel;
    protected $sizesModel;
    protected $colorsModel;
    protected $productImagesModel;
    protected $productCategoriesModel;
    protected $validation;
    protected $session;
    protected $db;

    public function __construct()
    {
        $this->productsModel = new ProductsModel();
        $this->sizesModel = new SizesModel();
        $this->colorsModel = new ColorsModel();
        $this->productImagesModel = new ProductImagesModel();
        $this->productCategoriesModel = new ProductCategoriesModel();
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        // Check if user is logged in - FIXED: Use consistent session key
        if (!$this->session->get('AdminLoggedIn')) {
            return redirect()->to('/admin/login');
        }
        
        // Get categories for the dropdown
        $categories = $this->productCategoriesModel->where('status', 'active')->findAll();
        
        $data = [
            'title' => 'The Blessed Manifest | Add Product',
            'activeMenu' => 'addproduct',
            'categories' => $categories
        ];

        return view('pages/admin/add-product', $data);
    }
    
    /**
    * Handle product submission
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
        
        // Set validation rules
        $this->setValidationRules();

        if (!$this->validate($this->validation->getRules())) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => $this->validation->getErrors()
            ]);
        }

        // Start database transaction
        $this->db->transStart();

        try {
            // 1. Insert main product
            $productId = $this->insertProduct();
            if (!$productId) {
                throw new \Exception('Failed to create product');
            }

            // 2. Handle product images directly from uploaded files
            $this->handleProductImagesDirect($productId);

            // 3. Insert sizes
            $this->insertSizes($productId);

            // 4. Insert colors with their images directly
            $this->insertColorsDirect($productId);

            // Commit transaction
            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                throw new \Exception('Transaction failed');
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Product created successfully!',
                'product_id' => $productId,
                'redirect' => '/admin/product-masterlist'
            ]);

        } catch (\Exception $e) {
            $this->db->transRollback();
            
            return $this->response->setJSON([
                'success' => false,
                'message' => $e->getMessage(),
                'errors' => ['general' => $e->getMessage()]
            ]);
        }
    }

    /**
     * Handle product images directly from uploaded files
     */
    private function handleProductImagesDirect($productId)
    {
        $files = $this->request->getFiles();
        
        if (!isset($files['product_images_files']) || empty($files['product_images_files'])) {
            log_message('info', 'No product images to process');
            return;
        }

        $uploadedFiles = $files['product_images_files'];
        
        // Ensure it's an array
        if (!is_array($uploadedFiles)) {
            $uploadedFiles = [$uploadedFiles];
        }

        log_message('info', 'Processing ' . count($uploadedFiles) . ' product images');

        // Create product directory in public folder
        $productDir = FCPATH . 'uploads/products/' . $productId . '/';
        if (!is_dir($productDir)) {
            mkdir($productDir, 0777, true);
        }

        foreach ($uploadedFiles as $file) {
            if ($file->isValid() && !$file->hasMoved()) {
                // Get file extension and validate it's an image
                $extension = strtolower($file->getExtension());
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                
                if (!in_array($extension, $allowedExtensions)) {
                    log_message('error', 'Invalid file type: ' . $extension);
                    continue;
                }
                
                // Generate unique filename
                $newFileName = 'product_' . time() . '_' . bin2hex(random_bytes(8)) . '.' . $extension;
                
                // Move file
                if ($file->move($productDir, $newFileName)) {
                    // Save to database
                    $imagePath = 'uploads/products/' . $productId . '/' . $newFileName;
                    $this->productImagesModel->insert([
                        'product_id' => $productId,
                        'file_path' => $imagePath
                    ]);
                    log_message('info', 'Saved product image: ' . $imagePath);
                } else {
                    log_message('error', 'Failed to move image: ' . $file->getName());
                }
            }
        }
    }

    /**
     * Insert colors with direct image upload
     */
    private function insertColorsDirect($productId)
    {
        $colors = $this->request->getPost('colors');
        
        if (empty($colors) || !is_array($colors)) {
            throw new \Exception('At least one color is required');
        }

        $defaultColorValue = $this->request->getPost('default_color');
        $hasDefault = false;
        
        // Create color images directory with product ID subfolder
        $colorDir = FCPATH . 'uploads/products/colors/' . $productId . '/';
        if (!is_dir($colorDir)) {
            mkdir($colorDir, 0777, true);
        }

        foreach ($colors as $index => $colorData) {
            // Get color hex
            $colorHex = $colorData['hex'] ?? null;
            if (empty($colorHex)) {
                log_message('error', 'Color hex is empty for index: ' . $index);
                continue;
            }
            
            // Ensure color hex starts with #
            if (!str_starts_with($colorHex, '#')) {
                $colorHex = '#' . $colorHex;
            }

            $isDefault = ($defaultColorValue !== null && (string)$defaultColorValue === (string)$index);
            if ($isDefault) {
                $hasDefault = true;
            }
            
            // Handle front image upload using flat naming structure
            $frontImagePath = null;
            $frontFile = $this->request->getFile("front_image_{$index}");
            
            if ($frontFile && $frontFile->isValid() && !$frontFile->hasMoved()) {
                $extension = strtolower($frontFile->getExtension());
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                
                if (in_array($extension, $allowedExtensions)) {
                    $newName = 'front_' . time() . '_' . bin2hex(random_bytes(8)) . '.' . $extension;
                    if ($frontFile->move($colorDir, $newName)) {
                        $frontImagePath = 'uploads/products/colors/' . $productId . '/' . $newName;
                        log_message('info', 'Saved front image: ' . $frontImagePath);
                    } else {
                        log_message('error', 'Failed to move front image: ' . $frontFile->getName());
                    }
                } else {
                    log_message('error', 'Invalid file extension for front image: ' . $extension);
                }
            } else {
                if ($frontFile) {
                    log_message('error', 'Front file invalid - isValid: ' . ($frontFile->isValid() ? 'true' : 'false'));
                }
            }
            
            // Handle back image upload using flat naming structure
            $backImagePath = null;
            $backFile = $this->request->getFile("back_image_{$index}");
            
            if ($backFile && $backFile->isValid() && !$backFile->hasMoved()) {
                $extension = strtolower($backFile->getExtension());
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                
                if (in_array($extension, $allowedExtensions)) {
                    $newName = 'back_' . time() . '_' . bin2hex(random_bytes(8)) . '.' . $extension;
                    if ($backFile->move($colorDir, $newName)) {
                        $backImagePath = 'uploads/products/colors/' . $productId . '/' . $newName;
                        log_message('info', 'Saved back image: ' . $backImagePath);
                    } else {
                        log_message('error', 'Failed to move back image: ' . $backFile->getName());
                    }
                } else {
                    log_message('error', 'Invalid file extension for back image: ' . $extension);
                }
            } else {
                if ($backFile) {
                    log_message('error', 'Back file invalid - isValid: ' . ($backFile->isValid() ? 'true' : 'false'));
                }
            }

            // Prepare color record
            $colorRecord = [
                'product_id' => $productId,
                'color_hex' => $colorHex,
                'front_image' => $frontImagePath,
                'back_image' => $backImagePath,
                'is_default' => $isDefault ? 1 : 0
            ];
            
            log_message('info', 'Attempting to save color: ' . json_encode($colorRecord));

            // Insert color record
            if (!$this->colorsModel->insert($colorRecord)) {
                $errors = $this->colorsModel->errors();
                log_message('error', 'Color insert failed: ' . json_encode($errors));
                throw new \Exception('Failed to save color: ' . $colorHex . ' - ' . json_encode($errors));
            }
            
            log_message('info', 'Successfully saved color with ID: ' . $this->colorsModel->getInsertID());
        }

        // If no default was set, set the first color as default
        if (!$hasDefault && $this->colorsModel->where('product_id', $productId)->countAllResults() > 0) {
            $firstColor = $this->colorsModel->where('product_id', $productId)->orderBy('color_id', 'ASC')->first();
            if ($firstColor) {
                $this->colorsModel->update($firstColor['color_id'], ['is_default' => 1]);
            }
        }
    }

    /**
     * Upload color variant image (Alternative method if you want to upload separately)
     */
    public function uploadColorImage()
    {
        // Check if user is logged in
        if (!$this->session->get('AdminLoggedIn')) {
            return $this->response->setJSON([
                'success' => false,
                'error' => 'Please login first'
            ]);
        }
        
        $validationRule = [
            'image' => [
                'label' => 'Image File',
                'rules' => 'uploaded[image]|is_image[image]|max_size[image,2048]|ext_in[image,jpg,jpeg,png,gif,webp]',
                'errors' => [
                    'uploaded' => 'Please select a file to upload',
                    'is_image' => 'The file must be an image',
                    'max_size' => 'The image size must not exceed 2MB',
                    'ext_in' => 'Only JPG, JPEG, PNG, GIF, and WEBP images are allowed'
                ]
            ]
        ];

        if (!$this->validate($validationRule)) {
            return $this->response->setJSON([
                'success' => false,
                'error' => $this->validator->getError('image')
            ]);
        }

        $file = $this->request->getFile('image');
        
        if (!$file->isValid()) {
            return $this->response->setJSON([
                'success' => false,
                'error' => 'Invalid file upload'
            ]);
        }

        // Get product_id from request
        $productId = $this->request->getPost('product_id');
        
        // Create color images directory with product ID subfolder
        if ($productId) {
            $colorDir = FCPATH . 'uploads/products/colors/' . $productId . '/';
        } else {
            $colorDir = FCPATH . 'uploads/products/colors/temp/';
        }
        
        if (!is_dir($colorDir)) {
            mkdir($colorDir, 0777, true);
        }

        $newName = 'color_' . time() . '_' . bin2hex(random_bytes(8)) . '.' . $file->getExtension();
        $file->move($colorDir, $newName);

        if ($file->hasMoved()) {
            $filePath = ($productId) 
                ? 'uploads/products/colors/' . $productId . '/' . $newName
                : 'uploads/products/colors/temp/' . $newName;
            
            return $this->response->setJSON([
                'success' => true,
                'filename' => $filePath
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'error' => 'Failed to move uploaded file'
        ]);
    }

    /**
     * Set validation rules
     */
    private function setValidationRules()
    {
        $this->validation->setRules([
            'product_name' => [
                'label' => 'Product Name',
                'rules' => 'required|min_length[3]|max_length[255]',
                'errors' => [
                    'required' => 'Product name is required',
                    'min_length' => 'Product name must be at least 3 characters',
                    'max_length' => 'Product name cannot exceed 255 characters'
                ]
            ],
            'slug' => [
                'label' => 'Slug',
                'rules' => 'permit_empty|alpha_dash|max_length[255]',
                'errors' => [
                    'alpha_dash' => 'Slug can only contain letters, numbers, dashes, and underscores',
                    'max_length' => 'Slug cannot exceed 255 characters'
                ]
            ],
            'product_category_id' => [
                'label' => 'Category',
                'rules' => 'required|is_natural_no_zero',
                'errors' => [
                    'required' => 'Please select a category',
                    'is_natural_no_zero' => 'Please select a valid category'
                ]
            ],
            'description' => [
                'label' => 'Description',
                'rules' => 'permit_empty|max_length[5000]'
            ],
            'tags' => [
                'label' => 'Tags',
                'rules' => 'permit_empty|max_length[500]'
            ],
            'is_featured' => [
                'label' => 'Featured',
                'rules' => 'permit_empty|in_list[0,1,on]'
            ],
            'is_in_stock' => [
                'label' => 'In Stock',
                'rules' => 'permit_empty|in_list[0,1,on]'
            ]
        ]);
    }

    /**
     * Insert main product
     */
    private function insertProduct()
    {
        $slug = $this->request->getPost('slug');
        if (empty($slug)) {
            $slug = $this->generateUniqueSlug($this->request->getPost('product_name'));
        } else {
            // Check if slug is unique
            if ($this->productsModel->where('slug', $slug)->first()) {
                $slug = $this->generateUniqueSlug($slug);
            }
        }

        // Get tags and convert to string if it's an array
        $tags = $this->request->getPost('tags');
        if (is_array($tags)) {
            $tags = implode(',', $tags);
        }

        $data = [
            'product_category_id' => $this->request->getPost('product_category_id'),
            'product_name' => $this->request->getPost('product_name'),
            'slug' => $slug,
            'description' => $this->request->getPost('description'),
            'tags' => $tags,
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0
        ];

        $this->productsModel->insert($data);
        return $this->productsModel->getInsertID();
    }

    /**
     * Generate unique slug
     */
    private function generateUniqueSlug($name)
    {
        $slug = url_title($name, '-', true);
        $originalSlug = $slug;
        $counter = 1;

        while ($this->productsModel->where('slug', $slug)->first()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Insert sizes
     */
    private function insertSizes($productId)
    {
        $sizes = $this->request->getPost('sizes');
        
        if (empty($sizes) || !is_array($sizes)) {
            throw new \Exception('At least one size is required');
        }

        $defaultSizeValue = $this->request->getPost('default_size');
        $hasDefault = false;

        foreach ($sizes as $index => $sizeData) {
            // Skip if size name or price is empty
            if (empty($sizeData['size']) || empty($sizeData['price'])) {
                continue;
            }

            $price = floatval($sizeData['price']);
            $discount = isset($sizeData['discount']) ? floatval($sizeData['discount']) : 0;
            $discountAmount = ($price * $discount) / 100;
            $discountType = isset($sizeData['discount_type']) ? $sizeData['discount_type'] : 'percentage';
            
            $isDefault = ($defaultSizeValue !== null && (string)$defaultSizeValue === (string)$index);
            if ($isDefault) {
                $hasDefault = true;
            }

            $sizeRecord = [
                'product_id' => $productId,
                'size' => $sizeData['size'],
                'unit_of_measure' => $sizeData['unit'] ?? '',
                'price' => $price,
                'discount_percentage' => ($discountType === 'percentage') ? $discount : 0,
                'discount_amount' => ($discountType === 'fixed') ? $discount : $discountAmount,
                'is_default' => $isDefault ? 1 : 0,
                'discount_type' => $discountType
            ];

            if (!$this->sizesModel->insert($sizeRecord)) {
                throw new \Exception('Failed to save size: ' . $sizeData['size']);
            }
        }

        // If no default was set, set the first size as default
        if (!$hasDefault && $this->sizesModel->where('product_id', $productId)->countAllResults() > 0) {
            $firstSize = $this->sizesModel->where('product_id', $productId)->orderBy('size_id', 'ASC')->first();
            if ($firstSize) {
                $this->sizesModel->update($firstSize['size_id'], ['is_default' => 1]);
            }
        }
    }

    /**
     * Get categories for AJAX
     */
    public function getCategories()
    {
        $categories = $this->productCategoriesModel->where('status', 'active')->findAll();
        return $this->response->setJSON($categories);
    }
}