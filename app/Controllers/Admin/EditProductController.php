<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProductsModel;
use App\Models\SizesModel;
use App\Models\ColorsModel;
use App\Models\ProductImagesModel;
use App\Models\ProductCategoriesModel;

class EditProductController extends SessionController
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

    public function index($id)
    {
        // Check if user is logged in
        if (!$this->session->get('AdminLoggedIn')) {
            return redirect()->to('/admin/login');
        }
        
        // Get product details
        $product = $this->productsModel->find($id);
        if (!$product) {
            return redirect()->to('/admin/product-masterlist')->with('error', 'Product not found');
        }
        
        // Get categories
        $categories = $this->productCategoriesModel->where('status', 'active')->findAll();
        
        // Get sizes
        $sizes = $this->sizesModel->where('product_id', $id)->findAll();
        
        // Get colors
        $colors = $this->colorsModel->where('product_id', $id)->findAll();
        
        // Get images
        $images = $this->productImagesModel->where('product_id', $id)->findAll();
        
        $data = [
            'title' => 'The Blessed Manifest | Edit Product',
            'activeMenu' => 'productmasterlist',
            'product' => $product,
            'categories' => $categories,
            'sizes' => $sizes,
            'colors' => $colors,
            'images' => $images
        ];

        return view('pages/admin/edit-product', $data);
    }
    
    /**
     * Handle product update
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
            // 1. Update main product
            $this->updateProduct($id);
            
            // 2. Handle product images
            $this->handleProductImagesUpdate($id);
            
            // 3. Update sizes
            $this->updateSizes($id);
            
            // 4. Update colors
            $this->updateColors($id);
            
            // 5. Handle deleted images
            $this->handleDeletedImages($id);
            
            // 6. Handle deleted colors
            $this->handleDeletedColors($id);
            
            // Commit transaction
            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                throw new \Exception('Transaction failed - transStatus returned false');
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Product updated successfully!',
                'product_id' => $id,
                'redirect' => '/admin/product-masterlist'
            ]);

        } catch (\Exception $e) {
            $this->db->transRollback();
            
            // Log the full error
            log_message('error', 'Product update failed: ' . $e->getMessage());
            log_message('error', 'Stack trace: ' . $e->getTraceAsString());
            
            return $this->response->setJSON([
                'success' => false,
                'message' => $e->getMessage(), // Show actual error message
                'errors' => ['general' => $e->getMessage()]
            ]);
        }
    }
    
    private function updateProduct($id)
    {
        try {
            $slug = $this->request->getPost('slug');
            if (empty($slug)) {
                $slug = $this->generateUniqueSlug($this->request->getPost('product_name'), $id);
            } else {
                // Check if slug is unique (excluding current product)
                $existingProduct = $this->productsModel->where('slug', $slug)->where('product_id !=', $id)->first();
                if ($existingProduct) {
                    $slug = $this->generateUniqueSlug($slug, $id);
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

            log_message('debug', 'Updating product with data: ' . json_encode($data));
            
            if (!$this->productsModel->update($id, $data)) {
                $errors = $this->productsModel->errors();
                log_message('error', 'Product update failed: ' . json_encode($errors));
                throw new \Exception('Failed to update product: ' . json_encode($errors));
            }
            
            return true;
        } catch (\Exception $e) {
            log_message('error', 'Exception in updateProduct: ' . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Handle product images update
     */
    private function handleProductImagesUpdate($productId)
    {
        $files = $this->request->getFiles();
        
        // Create product directory if it doesn't exist
        $productDir = FCPATH . 'uploads/products/' . $productId . '/';
        if (!is_dir($productDir)) {
            mkdir($productDir, 0777, true);
        }
        
        // Handle new image uploads
        if (isset($files['product_images_files']) && !empty($files['product_images_files'])) {
            $uploadedFiles = $files['product_images_files'];
            
            if (!is_array($uploadedFiles)) {
                $uploadedFiles = [$uploadedFiles];
            }
            
            foreach ($uploadedFiles as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $extension = strtolower($file->getExtension());
                    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                    
                    if (in_array($extension, $allowedExtensions)) {
                        $newFileName = 'product_' . time() . '_' . bin2hex(random_bytes(8)) . '.' . $extension;
                        
                        if ($file->move($productDir, $newFileName)) {
                            $imagePath = 'uploads/products/' . $productId . '/' . $newFileName;
                            $this->productImagesModel->insert([
                                'product_id' => $productId,
                                'file_path' => $imagePath
                            ]);
                            log_message('info', 'Saved new product image: ' . $imagePath);
                        }
                    }
                }
            }
        }
    }
    
    /**
     * Update sizes
     */
    private function updateSizes($productId)
    {
        $sizes = $this->request->getPost('sizes');
        
        if (empty($sizes) || !is_array($sizes)) {
            throw new \Exception('At least one size is required');
        }
        
        // Get existing size IDs
        $existingSizes = $this->sizesModel->where('product_id', $productId)->findAll();
        $existingSizeIds = array_column($existingSizes, 'size_id');
        $updatedSizeIds = [];
        
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
            
            // Check if this is an existing size or new one
            if (isset($sizeData['size_id']) && !empty($sizeData['size_id'])) {
                // Update existing size
                $sizeId = $sizeData['size_id'];
                $this->sizesModel->update($sizeId, $sizeRecord);
                $updatedSizeIds[] = $sizeId;
            } else {
                // Insert new size
                $this->sizesModel->insert($sizeRecord);
            }
        }
        
        // Delete sizes that were removed
        $sizesToDelete = array_diff($existingSizeIds, $updatedSizeIds);
        if (!empty($sizesToDelete)) {
            $this->sizesModel->whereIn('size_id', $sizesToDelete)->delete();
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
     * Update colors
     */
    private function updateColors($productId)
    {
        $colors = $this->request->getPost('colors');
        
        if (empty($colors) || !is_array($colors)) {
            throw new \Exception('At least one color is required');
        }
        
        // Get existing color IDs
        $existingColors = $this->colorsModel->where('product_id', $productId)->findAll();
        $existingColorIds = array_column($existingColors, 'color_id');
        $updatedColorIds = [];
        
        $defaultColorValue = $this->request->getPost('default_color');
        $hasDefault = false;
        
        // Create color images directory
        $colorDir = FCPATH . 'uploads/products/colors/' . $productId . '/';
        if (!is_dir($colorDir)) {
            mkdir($colorDir, 0777, true);
        }
        
        foreach ($colors as $index => $colorData) {
            // Get color hex
            $colorHex = $colorData['hex'] ?? null;
            if (empty($colorHex)) {
                continue;
            }
            
            if (!str_starts_with($colorHex, '#')) {
                $colorHex = '#' . $colorHex;
            }
            
            $isDefault = ($defaultColorValue !== null && (string)$defaultColorValue === (string)$index);
            if ($isDefault) {
                $hasDefault = true;
            }
            
            // Handle front image
            $frontImagePath = null;
            $frontFile = $this->request->getFile("front_image_{$index}");
            
            if ($frontFile && $frontFile->isValid() && !$frontFile->hasMoved()) {
                $extension = strtolower($frontFile->getExtension());
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                
                if (in_array($extension, $allowedExtensions)) {
                    $newName = 'front_' . time() . '_' . bin2hex(random_bytes(8)) . '.' . $extension;
                    if ($frontFile->move($colorDir, $newName)) {
                        $frontImagePath = 'uploads/products/colors/' . $productId . '/' . $newName;
                    }
                }
            } else {
                // Keep existing image if no new file uploaded
                $frontImagePath = $colorData['existing_front_image'] ?? null;
            }
            
            // Handle back image
            $backImagePath = null;
            $backFile = $this->request->getFile("back_image_{$index}");
            
            if ($backFile && $backFile->isValid() && !$backFile->hasMoved()) {
                $extension = strtolower($backFile->getExtension());
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                
                if (in_array($extension, $allowedExtensions)) {
                    $newName = 'back_' . time() . '_' . bin2hex(random_bytes(8)) . '.' . $extension;
                    if ($backFile->move($colorDir, $newName)) {
                        $backImagePath = 'uploads/products/colors/' . $productId . '/' . $newName;
                    }
                }
            } else {
                // Keep existing image if no new file uploaded
                $backImagePath = $colorData['existing_back_image'] ?? null;
            }
            
            $colorRecord = [
                'product_id' => $productId,
                'color_hex' => $colorHex,
                'front_image' => $frontImagePath,
                'back_image' => $backImagePath,
                'is_default' => $isDefault ? 1 : 0
            ];
            
            // Check if this is an existing color or new one
            if (isset($colorData['color_id']) && !empty($colorData['color_id'])) {
                $colorId = $colorData['color_id'];
                $this->colorsModel->update($colorId, $colorRecord);
                $updatedColorIds[] = $colorId;
            } else {
                // Insert new color
                $this->colorsModel->insert($colorRecord);
            }
        }
        
        // Delete colors that were removed
        $colorsToDelete = array_diff($existingColorIds, $updatedColorIds);
        if (!empty($colorsToDelete)) {
            // Delete associated images first
            $colorsToDeleteData = $this->colorsModel->whereIn('color_id', $colorsToDelete)->findAll();
            foreach ($colorsToDeleteData as $color) {
                if (!empty($color['front_image']) && file_exists(FCPATH . $color['front_image'])) {
                    unlink(FCPATH . $color['front_image']);
                }
                if (!empty($color['back_image']) && file_exists(FCPATH . $color['back_image'])) {
                    unlink(FCPATH . $color['back_image']);
                }
            }
            $this->colorsModel->whereIn('color_id', $colorsToDelete)->delete();
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
     * Handle deleted images
     */
    private function handleDeletedImages($productId)
    {
        $deletedImages = $this->request->getPost('deleted_images');
        
        if (!empty($deletedImages)) {
            $deletedImagesArray = explode(',', $deletedImages);
            
            foreach ($deletedImagesArray as $imageId) {
                $image = $this->productImagesModel->find($imageId);
                if ($image && $image['product_id'] == $productId) {
                    // Delete file from server
                    $filePath = FCPATH . $image['file_path'];
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                    // Delete from database
                    $this->productImagesModel->delete($imageId);
                }
            }
        }
    }
    
    /**
     * Handle deleted colors
     */
    private function handleDeletedColors($productId)
    {
        $deletedColors = $this->request->getPost('deleted_colors');
        
        if (!empty($deletedColors)) {
            $deletedColorsArray = explode(',', $deletedColors);
            
            foreach ($deletedColorsArray as $colorId) {
                $color = $this->colorsModel->find($colorId);
                if ($color && $color['product_id'] == $productId) {
                    // Delete image files
                    if (!empty($color['front_image']) && file_exists(FCPATH . $color['front_image'])) {
                        unlink(FCPATH . $color['front_image']);
                    }
                    if (!empty($color['back_image']) && file_exists(FCPATH . $color['back_image'])) {
                        unlink(FCPATH . $color['back_image']);
                    }
                    // Delete from database
                    $this->colorsModel->delete($colorId);
                }
            }
        }
    }
    
    /**
     * Generate unique slug for update
     */
    private function generateUniqueSlug($name, $excludeId = null)
    {
        $slug = url_title($name, '-', true);
        $originalSlug = $slug;
        $counter = 1;
        
        $query = $this->productsModel->where('slug', $slug);
        if ($excludeId) {
            $query->where('product_id !=', $excludeId);
        }
        
        while ($query->first()) {
            $slug = $originalSlug . '-' . $counter;
            $query = $this->productsModel->where('slug', $slug);
            if ($excludeId) {
                $query->where('product_id !=', $excludeId);
            }
            $counter++;
        }
        
        return $slug;
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
            ]
        ]);
    }
}