<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductsModel;
use App\Models\ProductCategoriesModel;
use App\Models\ProductImagesModel;
use App\Models\SizesModel;
use App\Models\ColorsModel;

class ProductsController extends BaseController
{
    public function index()
    {
        $productsModel = new ProductsModel();
        $categoriesModel = new ProductCategoriesModel();
        $imagesModel = new ProductImagesModel();
        $sizesModel = new SizesModel();
        $colorsModel = new ColorsModel();

        // Get all active categories
        $categories = $categoriesModel
            ->where('status', 'active')
            ->orderBy('categoryname', 'ASC')
            ->findAll();

        // Get all products
        $products = $productsModel
            ->select('products.*, product_categories.categoryname')
            ->join('product_categories', 'product_categories.product_category_id = products.product_category_id', 'left')
            ->orderBy('products.product_name', 'ASC')
            ->findAll();

        // Group images by product_id
        $allImages = $imagesModel->findAll();
        $productImages = [];
        foreach ($allImages as $image) {
            if (!isset($productImages[$image['product_id']])) {
                $productImages[$image['product_id']] = [];
            }
            $productImages[$image['product_id']][] = $image['file_path'];
        }

        // Get default sizes and colors for each product
        $allSizes = $sizesModel->findAll();
        $allColors = $colorsModel->findAll();
        
        $productSizes = [];
        $productColors = [];
        $productDefaultPrice = [];
        
        foreach ($allSizes as $size) {
            if (!isset($productSizes[$size['product_id']])) {
                $productSizes[$size['product_id']] = [];
            }
            $productSizes[$size['product_id']][] = $size;
            
            // Get default size price
            if ($size['is_default'] == 1) {
                $price = $size['price'];
                // Apply discount if any
                if ($size['discount_type'] == 'percentage' && $size['discount_percentage'] > 0) {
                    $price = $size['price'] - ($size['price'] * $size['discount_percentage'] / 100);
                } elseif ($size['discount_type'] == 'fixed' && $size['discount_amount'] > 0) {
                    $price = $size['price'] - $size['discount_amount'];
                }
                $productDefaultPrice[$size['product_id']] = [
                    'original_price' => $size['price'],
                    'final_price' => max(0, $price),
                    'discount_percentage' => $size['discount_percentage'],
                    'discount_amount' => $size['discount_amount']
                ];
            }
        }
        
        foreach ($allColors as $color) {
            if (!isset($productColors[$color['product_id']])) {
                $productColors[$color['product_id']] = [];
            }
            $productColors[$color['product_id']][] = $color;
        }

        // Prepare product data with images, sizes, colors and pricing
        $productsWithData = [];
        foreach ($products as $product) {
            $productId = $product['product_id'];
            $priceData = $productDefaultPrice[$productId] ?? [
                'original_price' => 0,
                'final_price' => 0,
                'discount_percentage' => 0,
                'discount_amount' => 0
            ];
            
            $productsWithData[] = [
                'product_id' => $productId,
                'product_name' => $product['product_name'],
                'slug' => $product['slug'],
                'description' => $product['description'],
                'tags' => $product['tags'],
                'is_featured' => $product['is_featured'],
                'product_category_id' => $product['product_category_id'],
                'categoryname' => $product['categoryname'] ?? 'Uncategorized',
                'images' => $productImages[$productId] ?? [],
                'sizes' => $productSizes[$productId] ?? [],
                'colors' => $productColors[$productId] ?? [],
                'original_price' => $priceData['original_price'],
                'price' => $priceData['final_price'],
                'discount_percentage' => $priceData['discount_percentage'],
                'has_discount' => $priceData['discount_percentage'] > 0 || $priceData['discount_amount'] > 0
            ];
        }

        $data = [
            'title' => 'The Blessed Manifest - Products',
            'activeMenu' => 'products',
            'categories' => $categories,
            'products' => $productsWithData,
            'totalResults' => count($productsWithData)
        ];

        return view('pages/products', $data);
    }

    /**
     * Filter products by category, price, etc.
     */
    public function filterByCategory()
    {
        $categoryId = $this->request->getGet('category_id');
        $sort = $this->request->getGet('sort') ?? 'most_popular';
        $minPrice = $this->request->getGet('min_price');
        $maxPrice = $this->request->getGet('max_price');
        
        $productsModel = new ProductsModel();
        $imagesModel = new ProductImagesModel();
        $sizesModel = new SizesModel();

        $builder = $productsModel
            ->select('products.*, product_categories.categoryname')
            ->join('product_categories', 'product_categories.product_category_id = products.product_category_id', 'left');

        if ($categoryId && $categoryId != 'all') {
            $builder->where('products.product_category_id', $categoryId);
        }

        // Price filtering (using sizes table)
        if ($minPrice !== null || $maxPrice !== null) {
            $subquery = $sizesModel->select('product_id')
                ->groupStart();
            if ($minPrice !== null) {
                $subquery->where('price >=', $minPrice);
            }
            if ($maxPrice !== null) {
                $subquery->where('price <=', $maxPrice);
            }
            $subquery->groupEnd();
            $productIdsWithPrice = $subquery->findColumn('product_id');
            
            if (!empty($productIdsWithPrice)) {
                $builder->whereIn('products.product_id', $productIdsWithPrice);
            }
        }

        // Apply sorting
        switch ($sort) {
            case 'price_asc':
                $builder->orderBy('products.product_name', 'ASC');
                break;
            case 'price_desc':
                $builder->orderBy('products.product_name', 'DESC');
                break;
            case 'most_popular':
            default:
                $builder->orderBy('products.is_featured', 'DESC')->orderBy('products.product_name', 'ASC');
                break;
        }

        $products = $builder->findAll();

        // Get images and pricing for all products
        $allImages = $imagesModel->findAll();
        $allSizes = $sizesModel->findAll();
        
        $productImages = [];
        foreach ($allImages as $image) {
            if (!isset($productImages[$image['product_id']])) {
                $productImages[$image['product_id']] = [];
            }
            $productImages[$image['product_id']][] = $image['file_path'];
        }
        
        // Calculate default pricing for each product
        $productPricing = [];
        foreach ($allSizes as $size) {
            if (!isset($productPricing[$size['product_id']]) || $size['is_default'] == 1) {
                $price = $size['price'];
                if ($size['discount_type'] == 'percentage' && $size['discount_percentage'] > 0) {
                    $price = $size['price'] - ($size['price'] * $size['discount_percentage'] / 100);
                } elseif ($size['discount_type'] == 'fixed' && $size['discount_amount'] > 0) {
                    $price = $size['price'] - $size['discount_amount'];
                }
                $productPricing[$size['product_id']] = [
                    'original_price' => $size['price'],
                    'price' => max(0, $price),
                    'discount_percentage' => $size['discount_percentage']
                ];
            }
        }

        $productsWithData = [];
        foreach ($products as $product) {
            $pricing = $productPricing[$product['product_id']] ?? [
                'original_price' => 0,
                'price' => 0,
                'discount_percentage' => 0
            ];
            
            $productsWithData[] = [
                'product_id' => $product['product_id'],
                'product_name' => $product['product_name'],
                'slug' => $product['slug'],
                'categoryname' => $product['categoryname'] ?? 'Uncategorized',
                'images' => $productImages[$product['product_id']] ?? [],
                'original_price' => $pricing['original_price'],
                'price' => $pricing['price'],
                'discount_percentage' => $pricing['discount_percentage']
            ];
        }

        return $this->response->setJSON([
            'success' => true,
            'products' => $productsWithData,
            'total' => count($productsWithData)
        ]);
    }

    /**
     * Search products
     */
    public function search()
    {
        $keyword = $this->request->getGet('q');
        
        $productsModel = new ProductsModel();
        $imagesModel = new ProductImagesModel();
        $sizesModel = new SizesModel();

        $products = $productsModel
            ->select('products.*, product_categories.categoryname')
            ->join('product_categories', 'product_categories.product_category_id = products.product_category_id', 'left')
            ->groupStart()
                ->like('products.product_name', $keyword)
                ->orLike('products.tags', $keyword)
                ->orLike('products.description', $keyword)
            ->groupEnd()
            ->findAll();

        $allImages = $imagesModel->findAll();
        $allSizes = $sizesModel->findAll();
        
        $productImages = [];
        foreach ($allImages as $image) {
            if (!isset($productImages[$image['product_id']])) {
                $productImages[$image['product_id']] = [];
            }
            $productImages[$image['product_id']][] = $image['file_path'];
        }
        
        // Calculate default pricing
        $productPricing = [];
        foreach ($allSizes as $size) {
            if (!isset($productPricing[$size['product_id']]) || $size['is_default'] == 1) {
                $price = $size['price'];
                if ($size['discount_type'] == 'percentage' && $size['discount_percentage'] > 0) {
                    $price = $size['price'] - ($size['price'] * $size['discount_percentage'] / 100);
                } elseif ($size['discount_type'] == 'fixed' && $size['discount_amount'] > 0) {
                    $price = $size['price'] - $size['discount_amount'];
                }
                $productPricing[$size['product_id']] = [
                    'original_price' => $size['price'],
                    'price' => max(0, $price)
                ];
            }
        }

        $productsWithData = [];
        foreach ($products as $product) {
            $pricing = $productPricing[$product['product_id']] ?? [
                'original_price' => 0,
                'price' => 0
            ];
            
            $productsWithData[] = [
                'product_id' => $product['product_id'],
                'product_name' => $product['product_name'],
                'slug' => $product['slug'],
                'categoryname' => $product['categoryname'] ?? 'Uncategorized',
                'images' => $productImages[$product['product_id']] ?? [],
                'original_price' => $pricing['original_price'],
                'price' => $pricing['price']
            ];
        }

        return $this->response->setJSON([
            'success' => true,
            'products' => $productsWithData,
            'total' => count($productsWithData),
            'keyword' => $keyword
        ]);
    }
}