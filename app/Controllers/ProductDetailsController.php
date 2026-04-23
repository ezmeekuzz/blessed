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
    /**
     * Display product details page
     * @param string $slug Product slug
     */
    public function index($slug = null)
    {
        if (!$slug) {
            return redirect()->to('/products');
        }

        $productsModel = new ProductsModel();
        $imagesModel = new ProductImagesModel();
        $categoriesModel = new ProductCategoriesModel();
        $sizesModel = new SizesModel();
        $colorsModel = new ColorsModel();

        $product = $productsModel
            ->select('products.*, product_categories.categoryname')
            ->join('product_categories', 'product_categories.product_category_id = products.product_category_id', 'left')
            ->where('products.slug', $slug)
            ->first();

        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Product not found');
        }

        // Get product images
        $productImages = $imagesModel
            ->where('product_id', $product['product_id'])
            ->findAll();
        $images = array_column($productImages, 'file_path');

        // If no images found, use placeholder
        if (empty($images)) {
            $images = ['images/placeholder-product.png'];
        }

        // Get sizes with pricing
        $sizes = $sizesModel
            ->where('product_id', $product['product_id'])
            ->orderBy('CAST(size AS UNSIGNED)', 'ASC')
            ->findAll();
        
        // Calculate final prices for each size
        foreach ($sizes as &$size) {
            $size['final_price'] = (float)$size['price'];
            $size['discount_label'] = null;
            $size['discount_amount_saved'] = 0;

            if ($size['discount_type'] == 'percentage' && $size['discount_percentage'] > 0) {
                $size['discount_amount_saved'] = $size['price'] * $size['discount_percentage'] / 100;
                $size['final_price'] = $size['price'] - $size['discount_amount_saved'];
                $size['discount_label'] = $size['discount_percentage'] . '% OFF';
            } elseif ($size['discount_type'] == 'fixed' && $size['discount_amount'] > 0) {
                $size['discount_amount_saved'] = $size['discount_amount'];
                $size['final_price'] = $size['price'] - $size['discount_amount'];
                $size['discount_label'] = '$' . number_format($size['discount_amount'], 2) . ' OFF';
            }

            $size['final_price'] = max(0, (float)$size['final_price']);
            $size['price'] = (float)$size['price'];
        }

        // Get colors with images
        $colors = $colorsModel
            ->where('product_id', $product['product_id'])
            ->orderBy('is_default', 'DESC')
            ->findAll();

        // Get default size and color
        $defaultSize = null;
        $defaultColor = null;
        
        foreach ($sizes as $size) {
            if ($size['is_default'] == 1) {
                $defaultSize = $size;
                break;
            }
        }
        
        foreach ($colors as $color) {
            if ($color['is_default'] == 1) {
                $defaultColor = $color;
                break;
            }
        }
        
        // If no default, use first item
        if (!$defaultSize && !empty($sizes)) {
            $defaultSize = $sizes[0];
        }
        if (!$defaultColor && !empty($colors)) {
            $defaultColor = $colors[0];
        }

        // Get default price from default size
        $defaultPrice = $defaultSize ? $defaultSize['final_price'] : 0;
        $originalPrice = $defaultSize ? $defaultSize['price'] : 0;
        $hasDiscount = $defaultSize && ($defaultSize['discount_percentage'] > 0 || $defaultSize['discount_amount'] > 0);

        // Get related products from same category
        $relatedProducts = $productsModel
            ->select('products.product_id, products.product_name, products.slug')
            ->where('products.product_category_id', $product['product_category_id'])
            ->where('products.product_id !=', $product['product_id'])
            ->limit(4)
            ->findAll();

        // Get related products images and pricing
        $relatedProductIds = array_column($relatedProducts, 'product_id');
        $relatedImages = [];
        $relatedPricing = [];

        if (!empty($relatedProductIds)) {
            // Get images
            $relatedImagesData = $imagesModel->whereIn('product_id', $relatedProductIds)->findAll();
            foreach ($relatedImagesData as $img) {
                if (!isset($relatedImages[$img['product_id']])) {
                    $relatedImages[$img['product_id']] = [];
                }
                $relatedImages[$img['product_id']][] = $img['file_path'];
            }

            // Get pricing from sizes
            $allSizes = $sizesModel->whereIn('product_id', $relatedProductIds)->findAll();
            foreach ($allSizes as $size) {
                if (!isset($relatedPricing[$size['product_id']]) || $size['is_default'] == 1) {
                    $finalPrice = (float)$size['price'];
                    if ($size['discount_type'] == 'percentage' && $size['discount_percentage'] > 0) {
                        $finalPrice = $size['price'] - ($size['price'] * $size['discount_percentage'] / 100);
                    } elseif ($size['discount_type'] == 'fixed' && $size['discount_amount'] > 0) {
                        $finalPrice = $size['price'] - $size['discount_amount'];
                    }
                    $relatedPricing[$size['product_id']] = [
                        'original_price' => (float)$size['price'],
                        'price' => max(0, (float)$finalPrice),
                        'has_discount' => ($size['discount_percentage'] > 0 || $size['discount_amount'] > 0),
                        'discount_percentage' => $size['discount_percentage']
                    ];
                }
            }
        }

        $data = [
            'title' => $product['product_name'] . ' - The Blessed Manifest',
            'activeMenu' => 'products',
            'product' => $product,
            'images' => $images,
            'sizes' => $sizes,
            'colors' => $colors,
            'defaultSize' => $defaultSize,
            'defaultColor' => $defaultColor,
            'defaultPrice' => $defaultPrice,
            'originalPrice' => $originalPrice,
            'hasDiscount' => $hasDiscount,
            'relatedProducts' => $relatedProducts,
            'relatedImages' => $relatedImages,
            'relatedPricing' => $relatedPricing,
            'shippingEstimate' => $this->getShippingEstimate(),
            'shippingCost' => 12.99
        ];

        return view('pages/product-details', $data);
    }

    /**
     * Get product variations (sizes and colors) via AJAX
     */
    public function getVariations()
    {
        $productId = $this->request->getGet('product_id');
        $sizeId = $this->request->getGet('size_id');
        $colorId = $this->request->getGet('color_id');
        
        $sizesModel = new SizesModel();
        $colorsModel = new ColorsModel();
        
        $response = [];
        
        // Get sizes
        $sizes = $sizesModel->where('product_id', $productId)->orderBy('CAST(size AS UNSIGNED)', 'ASC')->findAll();
        foreach ($sizes as &$size) {
            $size['final_price'] = (float)$size['price'];
            if ($size['discount_type'] == 'percentage' && $size['discount_percentage'] > 0) {
                $size['final_price'] = $size['price'] - ($size['price'] * $size['discount_percentage'] / 100);
            } elseif ($size['discount_type'] == 'fixed' && $size['discount_amount'] > 0) {
                $size['final_price'] = $size['price'] - $size['discount_amount'];
            }
            $size['final_price'] = max(0, (float)$size['final_price']);
            $size['price'] = (float)$size['price'];
        }
        
        // Get colors
        $colors = $colorsModel->where('product_id', $productId)->orderBy('is_default', 'DESC')->findAll();
        
        // Get selected size details
        $selectedSize = null;
        if ($sizeId) {
            $selectedSize = $sizesModel->find($sizeId);
            if ($selectedSize) {
                $selectedSize['final_price'] = (float)$selectedSize['price'];
                if ($selectedSize['discount_type'] == 'percentage' && $selectedSize['discount_percentage'] > 0) {
                    $selectedSize['final_price'] = $selectedSize['price'] - ($selectedSize['price'] * $selectedSize['discount_percentage'] / 100);
                } elseif ($selectedSize['discount_type'] == 'fixed' && $selectedSize['discount_amount'] > 0) {
                    $selectedSize['final_price'] = $selectedSize['price'] - $selectedSize['discount_amount'];
                }
                $selectedSize['final_price'] = max(0, (float)$selectedSize['final_price']);
                $selectedSize['price'] = (float)$selectedSize['price'];
            }
        }
        
        // Get selected color images
        $selectedColor = null;
        $frontImage = null;
        $backImage = null;
        
        if ($colorId) {
            $selectedColor = $colorsModel->find($colorId);
            if ($selectedColor) {
                $frontImage = $selectedColor['front_image'] ? base_url($selectedColor['front_image']) : null;
                $backImage = $selectedColor['back_image'] ? base_url($selectedColor['back_image']) : null;
            }
        }
        
        // If no selected color but colors exist, get default
        if (!$selectedColor && !empty($colors)) {
            $defaultColor = $colors[0];
            $frontImage = $defaultColor['front_image'] ? base_url($defaultColor['front_image']) : null;
            $backImage = $defaultColor['back_image'] ? base_url($defaultColor['back_image']) : null;
        }
        
        $response = [
            'success' => true,
            'sizes' => $sizes,
            'colors' => $colors,
            'selected_size' => $selectedSize,
            'selected_color' => $selectedColor,
            'front_image' => $frontImage,
            'back_image' => $backImage
        ];
        
        return $this->response->setJSON($response);
    }

    /**
     * Add to cart AJAX endpoint
     */
    public function addToCart()
    {
        $productId = $this->request->getPost('product_id');
        $sizeId = $this->request->getPost('size_id');
        $colorId = $this->request->getPost('color_id');
        $quantity = $this->request->getPost('quantity') ?? 1;
        
        $productsModel = new ProductsModel();
        $sizesModel = new SizesModel();
        $colorsModel = new ColorsModel();
        
        // Get product details
        $product = $productsModel->find($productId);
        if (!$product) {
            return $this->response->setJSON(['success' => false, 'message' => 'Product not found']);
        }
        
        // Get size details
        $size = $sizesModel->find($sizeId);
        if (!$size) {
            return $this->response->setJSON(['success' => false, 'message' => 'Size not found']);
        }
        
        // Calculate price with discount
        $price = (float)$size['price'];
        $discountAmount = 0;
        
        if ($size['discount_type'] == 'percentage' && $size['discount_percentage'] > 0) {
            $discountAmount = $price * $size['discount_percentage'] / 100;
            $price = $price - $discountAmount;
        } elseif ($size['discount_type'] == 'fixed' && $size['discount_amount'] > 0) {
            $discountAmount = $size['discount_amount'];
            $price = $price - $discountAmount;
        }
        $price = max(0, $price);
        
        // Get color details if provided
        $color = null;
        $colorHex = null;
        if ($colorId) {
            $color = $colorsModel->find($colorId);
            if ($color) {
                $colorHex = $color['color_hex'];
            }
        }
        
        // Build cart item
        $cartItem = [
            'product_id' => $productId,
            'product_name' => $product['product_name'],
            'slug' => $product['slug'],
            'size_id' => $sizeId,
            'size' => $size['size'],
            'unit_of_measure' => $size['unit_of_measure'],
            'color_id' => $colorId,
            'color_hex' => $colorHex,
            'quantity' => (int)$quantity,
            'price' => round($price, 2),
            'original_price' => (float)$size['price'],
            'discount_percentage' => $size['discount_percentage'],
            'discount_amount' => $discountAmount
        ];
        
        // Initialize cart session if not exists
        $cart = session()->get('cart') ?? [];
        
        // Check if item already exists
        $itemKey = $productId . '_' . $sizeId . '_' . ($colorId ?? '0');
        if (isset($cart[$itemKey])) {
            $cart[$itemKey]['quantity'] += $quantity;
        } else {
            $cart[$itemKey] = $cartItem;
        }
        
        session()->set('cart', $cart);
        
        // Calculate cart total
        $cartTotal = 0;
        $cartCount = 0;
        foreach ($cart as $item) {
            $cartTotal += $item['price'] * $item['quantity'];
            $cartCount += $item['quantity'];
        }
        
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Product added to cart successfully!',
            'cart_count' => $cartCount,
            'cart_total' => round($cartTotal, 2)
        ]);
    }

    /**
     * Get shipping estimate based on location
     */
    private function getShippingEstimate()
    {
        $estimates = [
            'United States' => ['min_days' => 3, 'max_days' => 7],
            'Canada' => ['min_days' => 5, 'max_days' => 10],
            'United Kingdom' => ['min_days' => 6, 'max_days' => 12],
            'Australia' => ['min_days' => 7, 'max_days' => 14]
        ];

        $defaultCountry = 'United States';
        $estimate = $estimates[$defaultCountry];

        return [
            'country' => $defaultCountry,
            'min_days' => $estimate['min_days'],
            'max_days' => $estimate['max_days']
        ];
    }

    /**
     * Helper function to get color name from hex
     */
    private function getColorNameFromHex($hex)
    {
        $colors = [
            '#FFFFFF' => 'White',
            '#000000' => 'Black',
            '#FF0000' => 'Red',
            '#00FF00' => 'Green',
            '#0000FF' => 'Blue',
            '#FFFF00' => 'Yellow',
            '#FFC0CB' => 'Pink',
            '#800080' => 'Purple',
            '#FFA500' => 'Orange',
            '#808080' => 'Gray',
            '#A52A2A' => 'Brown',
            '#FF69B4' => 'Hot Pink',
            '#00FFFF' => 'Cyan',
            '#FF4500' => 'Orange Red'
        ];

        return $colors[strtoupper($hex)] ?? 'Custom';
    }
}