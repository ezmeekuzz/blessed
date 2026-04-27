<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductsModel;
use App\Models\ProductCategoriesModel;
use App\Models\ProductImagesModel;
use App\Models\SizesModel;
use App\Models\ColorsModel;

class ProductDetailsController extends BaseController
{
    public function index($slug = null)
    {
        $productsModel = new ProductsModel();

        $product = $productsModel
            ->select('products.*, product_categories.categoryname')
            ->join('product_categories', 'product_categories.product_category_id = products.product_category_id', 'left')
            ->where('products.slug', $slug)
            ->first();

        $data = [
            'title' => 'The Blessed Manifest',
            'activeMenu' => 'products',
            'product' => $product
        ];

        return view('pages/product-details', $data);
    }

    public function getData()
    {
        $productsModel = new ProductsModel();

        $productId = $this->request->getGET('product_id');

        $product = $productsModel
            ->select('products.*, product_categories.categoryname')
            ->join('product_categories', 'product_categories.product_category_id = products.product_category_id', 'left')
            ->where('products.product_id', $productId)
            ->first();

        return $this->response->setJSON($product);
    }

    public function otherProducts()
    {
        $productsModel = new ProductsModel();
        $productId = $this->request->getGET('product_id');
        
        if (!$productId) {
            return $this->response->setJSON(['error' => true, 'message' => 'Product ID required']);
        }
        
        // Get current product's category
        $currentProduct = $productsModel->find($productId);
        
        if (!$currentProduct) {
            return $this->response->setJSON([]);
        }
        
        // Get products from same category, excluding current product
        $products = $productsModel
            ->select('products.*, product_categories.categoryname')
            ->join('product_categories', 'product_categories.product_category_id = products.product_category_id', 'left')
            ->join('sizes', 'sizes.product_id = products.product_id AND sizes.is_default = 1', 'left')
            ->where('products.product_category_id', $currentProduct['product_category_id'])
            ->where('products.product_id !=', $productId)
            ->orderBy('RAND()') // Randomize for variety
            ->limit(6) // Limit to 6 products
            ->findAll();
        
        return $this->response->setJSON($products);
    }

    public function getProductColorImages()
    {
        $colorsModel = new ColorsModel();
        
        $productId = $this->request->getGET('product_id');
        $colorId = $this->request->getGET('color_id');
        
        if (!$productId) {
            return $this->response->setJSON([
                'error' => true,
                'message' => 'Product ID is required'
            ])->setStatusCode(400);
        }
        
        $colorsQuery = $colorsModel
            ->select('colors.*')
            ->where('colors.product_id', $productId);
        
        if ($colorId) {
            $colorsQuery->where('colors.color_id', $colorId);
        } else {
            $colorsQuery->where('colors.is_default', 1);
        }
        
        $colors = $colorsQuery->findAll();
        
        if (empty($colors)) {
            return $this->response->setJSON([
                'error' => true,
                'message' => 'No images found'
            ])->setStatusCode(404);
        }
        
        // Return single object if only one, or array if multiple
        return $this->response->setJSON(count($colors) === 1 ? $colors[0] : $colors);
    }

    public function getProductColors()
    {
        $colorsModel = new ColorsModel();
        
        $productId = $this->request->getGET('product_id');
        
        if (!$productId) {
            return $this->response->setJSON([
                'error' => true,
                'message' => 'Product ID is required'
            ])->setStatusCode(400);
        }
        
        $colors = $colorsModel
            ->select('colors.*')
            ->where('colors.product_id', $productId)
            ->findAll();
            
        // Return single object if only one, or array if multiple
        return $this->response->setJSON($colors);
    }

    public function getProductSizes()
    {
        $sizesModel = new SizesModel();
        
        $productId = $this->request->getGET('product_id');
        
        if (!$productId) {
            return $this->response->setJSON([
                'error' => true,
                'message' => 'Product ID is required'
            ])->setStatusCode(400);
        }
        
        $sizes = $sizesModel
            ->select('sizes.*')
            ->where('sizes.product_id', $productId)
            ->orderBy('size', 'asc')
            ->findAll();
            
        // Return single object if only one, or array if multiple
        return $this->response->setJSON($sizes);
    }

    /**
     * Check if user is logged in
     */
    public function checkLoginStatus()
    {
        $isLoggedIn = session()->has('user_user_id') && session()->get('user_usertype') == 'Regular User';
        
        return $this->response->setJSON([
            'logged_in' => $isLoggedIn,
            'user_id' => $isLoggedIn ? session()->get('user_user_id') : null
        ]);
    }

    /**
     * Get complete product details for accordion
     */
    public function getCompleteProductDetails()
    {
        $productId = $this->request->getGET('product_id');
        
        if (!$productId) {
            return $this->response->setJSON([
                'error' => true,
                'message' => 'Product ID is required'
            ])->setStatusCode(400);
        }
        
        $productsModel = new ProductsModel();
        $sizesModel = new SizesModel();
        $colorsModel = new ColorsModel();
        
        // Get product basic info
        $product = $productsModel
            ->select('products.*, product_categories.categoryname')
            ->join('product_categories', 'product_categories.product_category_id = products.product_category_id', 'left')
            ->where('products.product_id', $productId)
            ->first();
        
        if (!$product) {
            return $this->response->setJSON([
                'error' => true,
                'message' => 'Product not found'
            ])->setStatusCode(404);
        }
        
        // Get all sizes for this product
        $sizes = $sizesModel
            ->where('product_id', $productId)
            ->orderBy('size', 'asc')
            ->findAll();
        
        // Get all colors for this product
        $colors = $colorsModel
            ->where('product_id', $productId)
            ->findAll();
        
        // Get default size and price
        $defaultSize = $sizesModel
            ->where('product_id', $productId)
            ->where('is_default', 1)
            ->first();
        
        // Prepare complete product details
        $completeDetails = [
            'product_id' => $product['product_id'],
            'product_name' => $product['product_name'],
            'slug' => $product['slug'],
            'categoryname' => $product['categoryname'] ?? 'Uncategorized',
            'description' => $product['description'] ?? '',
            'tags' => $product['tags'] ?? '',
            'is_featured' => $product['is_featured'] ?? 0,
            
            // Product Specifications
            'specifications' => $this->getProductSpecifications($product),
            
            // Sizes Information
            'sizes' => array_map(function($size) {
                return [
                    'size' => $size['size'],
                    'unit_of_measure' => $size['unit_of_measure'],
                    'price' => $size['price'],
                    'discount_percentage' => $size['discount_percentage'] ?? 0,
                    'discount_amount' => $size['discount_amount'] ?? 0,
                    'is_default' => $size['is_default'],
                    'final_price' => $this->calculateFinalPrice($size)
                ];
            }, $sizes),
            
            // Colors Information
            'colors' => array_map(function($color) {
                return [
                    'color_hex' => $color['color_hex'],
                    'front_image' => $color['front_image'],
                    'back_image' => $color['back_image'],
                    'is_default' => $color['is_default']
                ];
            }, $colors),
            
            // Shipping Information
            'shipping' => [
                'processing_time' => '1-2 business days',
                'standard_delivery' => '5-7 business days',
                'express_delivery' => '2-3 business days',
                'free_shipping_threshold' => 50.00,
                'shipping_cost' => 12.99,
                'international_shipping' => true
            ],
            
            // Return Policy
            'returns' => [
                'return_period' => '30 days',
                'condition' => 'Unused, original packaging',
                'refund_method' => 'Original payment method',
                'restocking_fee' => 0
            ],
            
            // Materials & Care
            'materials_care' => [
                'material' => 'High-quality ceramic',
                'finish' => 'Glossy finish for vibrant colors',
                'dishwasher_safe' => true,
                'microwave_safe' => true,
                'capacity' => '11 oz (325 ml)',
                'dimensions' => '3.5" height x 3.2" diameter',
                'weight' => '0.85 lbs'
            ],
            
            // Customization Options
            'customization' => [
                'file_types' => ['JPG', 'PNG', 'PDF', 'SVG', 'AI', 'EPS'],
                'max_file_size' => '20MB',
                'resolution' => '300 DPI recommended',
                'min_dimensions' => '1000 x 1000 pixels',
                'preview_available' => true,
                'templates_available' => true,
                'text_customization' => true
            ],
            
            // Bulk Pricing (if applicable)
            'bulk_pricing' => $this->getBulkPricing($defaultSize['price'] ?? 0),
            
            // Related Products Info
            'related_products_count' => $this->getRelatedProductsCount($product['product_category_id'], $productId)
        ];
        
        return $this->response->setJSON($completeDetails);
    }
    
    /**
     * Get product specifications
     */
    private function getProductSpecifications($product)
    {
        $specs = [];
        
        if ($product['tags']) {
            $specs['Tags'] = $product['tags'];
        }
        
        $specs['Category'] = $product['categoryname'] ?? 'Uncategorized';
        $specs['Product ID'] = $product['product_id'];
        
        if ($product['is_featured']) {
            $specs['Featured Product'] = 'Yes';
        }
        
        return $specs;
    }
    
    /**
     * Calculate final price with discount
     */
    private function calculateFinalPrice($size)
    {
        $price = $size['price'];
        
        if ($size['discount_type'] === 'percentage' && $size['discount_percentage'] > 0) {
            $price = $price - ($price * $size['discount_percentage'] / 100);
        } elseif ($size['discount_amount'] > 0) {
            $price = $price - $size['discount_amount'];
        }
        
        return max(0, $price);
    }
    
    /**
     * Get bulk pricing tiers
     */
    private function getBulkPricing($basePrice)
    {
        return [
            ['quantity' => '2-5', 'discount' => '5%', 'price' => $basePrice * 0.95],
            ['quantity' => '6-10', 'discount' => '10%', 'price' => $basePrice * 0.90],
            ['quantity' => '11-20', 'discount' => '15%', 'price' => $basePrice * 0.85],
            ['quantity' => '20+', 'discount' => '20%', 'price' => $basePrice * 0.80]
        ];
    }
    
    /**
     * Get count of related products
     */
    private function getRelatedProductsCount($categoryId, $currentProductId)
    {
        $productsModel = new ProductsModel();
        
        return $productsModel
            ->where('product_category_id', $categoryId)
            ->where('product_id !=', $currentProductId)
            ->countAllResults();
    }
}