<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductsModel;
use App\Models\SizesModel;
use App\Models\ColorsModel;
use App\Models\DesignsModel;
use App\Models\StickersModel;
use App\Models\ClipArtsModel;
use App\Models\FontsModel;
use App\Models\GridTemplatesModel;

class CustomizeDesignController extends BaseController
{
    protected $productsModel;
    protected $sizesModel;
    protected $colorsModel;
    protected $designsModel;
    protected $stickersModel;
    protected $clipArtsModel;
    protected $fontsModel;
    protected $gridTemplatesModel;

    public function __construct()
    {
        $this->productsModel = new ProductsModel();
        $this->sizesModel = new SizesModel();
        $this->colorsModel = new ColorsModel();
        $this->designsModel = new DesignsModel();
        $this->stickersModel = new StickersModel();
        $this->clipArtsModel = new ClipArtsModel();
        $this->fontsModel = new FontsModel();
        $this->gridTemplatesModel = new GridTemplatesModel();
    }

    public function index($slug = null)
    {
        // Get product details
        $product = $this->productsModel
            ->select('products.*, product_categories.categoryname')
            ->join('product_categories', 'product_categories.product_category_id = products.product_category_id', 'left')
            ->where('products.slug', $slug)
            ->first();

        if (!$product) {
            return redirect()->to('/products')->with('error', 'Product not found');
        }

        // Get product sizes
        $sizes = $this->sizesModel
            ->where('product_id', $product['product_id'])
            ->orderBy('size', 'ASC')
            ->findAll();

        // Get product colors
        $colors = $this->colorsModel
            ->where('product_id', $product['product_id'])
            ->findAll();

        // Get templates (for design tab)
        $templates = $this->_getTemplates();

        // Get stickers
        $stickers = $this->stickersModel
            ->where('is_active', 1)
            ->findAll();

        // Get clip arts
        $clipArts = $this->clipArtsModel
            ->where('is_active', 1)
            ->findAll();

        // Get fonts
        $fonts = $this->fontsModel
            ->where('status', 'active')
            ->findAll();

        // Get grid templates
        $gridTemplates = $this->gridTemplatesModel
            ->findAll();

        // Get existing user designs
        $userDesigns = [];
        if (session()->has('user_user_id')) {
            $userDesigns = $this->designsModel
                ->where('user_id', session()->get('user_user_id'))
                ->where('product_id', $product['product_id'])
                ->orderBy('created_at', 'DESC')
                ->findAll();
        }

        $data = [
            'title' => 'Customize Design - ' . ($product['product_name'] ?? 'Product'),
            'activeMenu' => 'customize',
            'product' => $product,
            'sizes' => $sizes,
            'colors' => $colors,
            'templates' => $templates,
            'stickers' => $stickers,
            'clipArts' => $clipArts,
            'fonts' => $fonts,
            'gridTemplates' => $gridTemplates,
            'userDesigns' => $userDesigns,
            'defaultSize' => $this->_getDefaultSize($sizes),
            'defaultColor' => $this->_getDefaultColor($colors)
        ];

        return view('pages/customize-design', $data);
    }

    /**
     * Save design to database
     */
    public function saveDesign()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        $userId = session()->get('user_user_id');
        if (!$userId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Please login to save your design']);
        }

        $postData = $this->request->getJSON(true);
        
        $designData = [
            'user_id' => $userId,
            'product_id' => $postData['product_id'] ?? null,
            'design_name' => $postData['design_name'] ?? 'Untitled Design',
            'design_data' => json_encode($postData['design_data'] ?? []),
            'size_id' => $postData['size_id'] ?? null,
            'color_id' => $postData['color_id'] ?? null,
            'preview_image' => $postData['preview_image'] ?? null,
            'status' => 'draft'
        ];

        // Check if updating existing design
        if (!empty($postData['design_id'])) {
            $result = $this->designsModel->update($postData['design_id'], $designData);
            $designId = $postData['design_id'];
        } else {
            $result = $this->designsModel->insert($designData);
            $designId = $this->designsModel->getInsertID();
        }

        if ($result) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Design saved successfully',
                'design_id' => $designId
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to save design'
        ]);
    }

    /**
     * Load saved design
     */
    public function loadDesign($designId)
    {
        $userId = session()->get('user_user_id');
        
        $design = $this->designsModel
            ->where('design_id', $designId)
            ->where('user_id', $userId)
            ->first();

        if (!$design) {
            return $this->response->setJSON(['success' => false, 'message' => 'Design not found']);
        }

        return $this->response->setJSON([
            'success' => true,
            'design' => [
                'design_id' => $design['design_id'],
                'design_name' => $design['design_name'],
                'design_data' => json_decode($design['design_data'], true),
                'size_id' => $design['size_id'],
                'color_id' => $design['color_id'],
                'preview_image' => $design['preview_image']
            ]
        ]);
    }

    /**
     * Delete saved design
     */
    public function deleteDesign()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        $userId = session()->get('user_user_id');
        $designId = $this->request->getPost('design_id');

        if (!$userId || !$designId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid parameters']);
        }

        $result = $this->designsModel
            ->where('design_id', $designId)
            ->where('user_id', $userId)
            ->delete();

        if ($result) {
            return $this->response->setJSON(['success' => true, 'message' => 'Design deleted']);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Failed to delete design']);
    }

    /**
     * Get stickers by category
     */
    public function getStickers($category = null)
    {
        $stickers = $this->stickersModel
            ->where('is_active', 1)
            ->when($category, function($query, $category) {
                return $query->like('tags', $category);
            })
            ->findAll();

        return $this->response->setJSON($stickers);
    }

    /**
     * Get clip arts by category
     */
    public function getClipArts($category = null)
    {
        $clipArts = $this->clipArtsModel
            ->where('is_active', 1)
            ->when($category, function($query, $category) {
                return $query->like('tags', $category);
            })
            ->findAll();

        return $this->response->setJSON($clipArts);
    }

    /**
     * Get fonts
     */
    public function getFonts()
    {
        $fonts = $this->fontsModel
            ->where('status', 'active')
            ->findAll();

        return $this->response->setJSON($fonts);
    }

    /**
     * Upload design preview image (AJAX with file upload)
     */
    public function uploadPreview()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false]);
        }

        $file = $this->request->getFile('preview_image');
        if (!$file || !$file->isValid()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid file']);
        }

        $newName = 'design_preview_' . time() . '_' . uniqid() . '.png';
        $file->move(FCPATH . 'uploads/designs/', $newName);

        if ($file->hasMoved()) {
            return $this->response->setJSON([
                'success' => true,
                'path' => '/uploads/designs/' . $newName
            ]);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Failed to upload']);
    }

    /**
     * Generate preview image from canvas data (using Imagemagick or GD)
     */
    public function generatePreview()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false]);
        }

        $imageData = $this->request->getPost('canvas_data');
        if (!$imageData) {
            return $this->response->setJSON(['success' => false]);
        }

        // Remove the data:image/png;base64, prefix
        $imageData = str_replace('data:image/png;base64,', '', $imageData);
        $imageData = str_replace(' ', '+', $imageData);
        $imageData = base64_decode($imageData);

        $fileName = 'preview_' . time() . '_' . uniqid() . '.png';
        $filePath = FCPATH . 'uploads/designs/' . $fileName;
        
        file_put_contents($filePath, $imageData);

        return $this->response->setJSON([
            'success' => true,
            'path' => '/uploads/designs/' . $fileName
        ]);
    }

    /**
     * Get product price with selected size
     */
    public function getProductPrice()
    {
        $sizeId = $this->request->getGet('size_id');
        
        $size = $this->sizesModel->find($sizeId);
        
        if ($size) {
            $price = $size['price'];
            if ($size['discount_type'] === 'percentage' && $size['discount_percentage'] > 0) {
                $price = $price - ($price * $size['discount_percentage'] / 100);
            } elseif ($size['discount_amount'] > 0) {
                $price = $price - $size['discount_amount'];
            }
            
            return $this->response->setJSON([
                'success' => true,
                'price' => $price,
                'original_price' => $size['price'],
                'size' => $size['size'] . ' ' . $size['unit_of_measure']
            ]);
        }

        return $this->response->setJSON(['success' => false]);
    }

    /**
     * Add design to cart
     */
    public function addToCart()
    {
        $userId = session()->get('user_user_id');
        
        if (!$userId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please login to add to cart',
                'redirect' => '/login'
            ]);
        }

        $postData = $this->request->getPost();
        
        // Store design data in session for cart
        $cart = session()->get('design_cart') ?? [];
        
        $cartItem = [
            'id' => uniqid(),
            'product_id' => $postData['product_id'],
            'design_id' => $postData['design_id'] ?? null,
            'design_data' => $postData['design_data'] ?? null,
            'preview_image' => $postData['preview_image'] ?? null,
            'size_id' => $postData['size_id'],
            'color_id' => $postData['color_id'] ?? null,
            'quantity' => $postData['quantity'] ?? 1,
            'price' => $postData['price'] ?? 0
        ];
        
        $cart[] = $cartItem;
        session()->set('design_cart', $cart);
        
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Added to cart',
            'cart_count' => count($cart)
        ]);
    }

    /**
     * Get template designs (from database or static)
     */
    private function _getTemplates()
    {
        // You can store templates in a database table
        // For now, return static array
        return [
            [
                'id' => 1,
                'name' => 'Classic Prayer',
                'image' => '/images/templates/prayer-template.jpg',
                'tags' => ['prayer', 'faith', 'classic']
            ],
            [
                'id' => 2,
                'name' => 'Blessings',
                'image' => '/images/templates/blessings-template.jpg',
                'tags' => ['blessing', 'inspirational']
            ],
            [
                'id' => 3,
                'name' => 'Scripture Verse',
                'image' => '/images/templates/scripture-template.jpg',
                'tags' => ['bible', 'scripture', 'verse']
            ]
        ];
    }

    private function _getDefaultSize($sizes)
    {
        foreach ($sizes as $size) {
            if ($size['is_default'] == 1) {
                return $size;
            }
        }
        return $sizes[0] ?? null;
    }

    private function _getDefaultColor($colors)
    {
        foreach ($colors as $color) {
            if ($color['is_default'] == 1) {
                return $color;
            }
        }
        return $colors[0] ?? null;
    }
}