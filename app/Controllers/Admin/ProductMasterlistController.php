<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProductsModel;
use App\Models\ProductCategoriesModel;
use App\Models\SizesModel;
use App\Models\ColorsModel;
use App\Models\ProductImagesModel;
use Hermawan\DataTables\DataTable;

class ProductMasterlistController extends SessionController
{
    protected $db;
    
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    
    public function index()
    {
        // Check if user is logged in
        if (!$this->session->get('AdminLoggedIn')) {
            return redirect()->to('/admin/login');
        }
        
        $data = [
            'title' => 'The Blessed Manifest | Product Masterlist',
            'activeMenu' => 'productmasterlist'
        ];
        return view('pages/admin/product-masterlist', $data);
    }
    
    public function getData()
    {
        // Check if user is logged in
        if (!$this->session->get('AdminLoggedIn')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized'
            ]);
        }
        
        $db = db_connect();
        $builder = $db->table('products')
                    ->select('
                        products.product_id, 
                        products.product_name, 
                        products.slug, 
                        products.description, 
                        products.product_category_id, 
                        products.tags, 
                        products.is_featured,
                        products.created_at,
                        products.updated_at,
                        product_categories.categoryname
                    ')
                    ->join('product_categories', 'product_categories.product_category_id = products.product_category_id', 'left')
                    ->orderBy('products.product_id', 'DESC');

        // Get DataTable response
        $response = DataTable::of($builder)->toJson();
        $json = $response->getBody();
        $result = json_decode($json, true);

        // Transform data
        $data = [];
        foreach ($result['data'] as $row) {
            // Get product images count
            $imageModel = new ProductImagesModel();
            $imageCount = $imageModel->where('product_id', $row[0])->countAllResults();
            
            // Get first image for thumbnail
            $firstImage = $imageModel->where('product_id', $row[0])->first();
            $thumbnail = $firstImage ? base_url($firstImage['file_path']) : base_url('assets/images/no-image.png');
            
            // Get sizes info
            $sizeModel = new SizesModel();
            $sizes = $sizeModel->where('product_id', $row[0])->findAll();
            $priceRange = '';
            if (!empty($sizes)) {
                $prices = array_column($sizes, 'price');
                $minPrice = min($prices);
                $maxPrice = max($prices);
                if ($minPrice == $maxPrice) {
                    $priceRange = '$' . number_format($minPrice, 2);
                } else {
                    $priceRange = '$' . number_format($minPrice, 2) . ' - $' . number_format($maxPrice, 2);
                }
            }
            
            // Get colors count
            $colorModel = new ColorsModel();
            $colorCount = $colorModel->where('product_id', $row[0])->countAllResults();
            
            // Process tags
            $tagsArray = [];
            $tagsHtml = '';
            if (!empty($row[5])) {
                $tagsArray = explode(',', $row[5]);
                $tagsArray = array_map('trim', $tagsArray);
                foreach ($tagsArray as $tag) {
                    $tagsHtml .= '<span class="badge badge-info mr-1 mb-1">' . htmlspecialchars($tag) . '</span>';
                }
            }
            
            $data[] = [
                'product_id' => $row[0],
                'product_name' => $row[1],
                'slug' => $row[2],
                'description' => $row[3],
                'product_category_id' => $row[4],
                'tags' => $row[5],
                'is_featured' => $row[6],
                'created_at' => $row[7] ? date('F d Y, h:i:s A', strtotime($row[7])) : 'N/A',
                'updated_at' => $row[8] ? date('F d Y, h:i:s A', strtotime($row[8])) : 'N/A',
                'categoryname' => $row[9] ?? 'Uncategorized',
                'image_count' => $imageCount,
                'thumbnail' => $thumbnail,
                'price_range' => $priceRange,
                'color_count' => $colorCount,
                'tags_array' => $tagsArray,
                'tags_html' => $tagsHtml,
                'is_featured_badge' => $row[6] == 1 ? '<span class="badge badge-success">Featured</span>' : '<span class="badge badge-secondary">Standard</span>',
                'excerpt' => strlen(strip_tags($row[3])) > 100 ? substr(strip_tags($row[3]), 0, 100) . '...' : strip_tags($row[3])
            ];
        }

        $result['data'] = $data;
        return $this->response->setJSON($result);
    }
    
    /**
     * Get single product for viewing
     */
    public function getProduct($id)
    {
        // Check if user is logged in
        if (!$this->session->get('AdminLoggedIn')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized'
            ]);
        }
        
        // Check if it's an AJAX request
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid request'
            ]);
        }
        
        $productModel = new ProductsModel();
        $product = $productModel->find($id);
        
        if (!$product) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Product not found'
            ]);
        }
        
        // Get category details
        $categoryModel = new ProductCategoriesModel();
        $category = $categoryModel->find($product['product_category_id']);
        
        // Get sizes
        $sizeModel = new SizesModel();
        $sizes = $sizeModel->where('product_id', $id)->findAll();
        
        // Get colors
        $colorModel = new ColorsModel();
        $colors = $colorModel->where('product_id', $id)->findAll();
        
        // Get images
        $imageModel = new ProductImagesModel();
        $images = $imageModel->where('product_id', $id)->findAll();
        
        // Process tags
        $tagsArray = [];
        $tagsHtml = '';
        if (!empty($product['tags'])) {
            $tagsArray = explode(',', $product['tags']);
            $tagsArray = array_map('trim', $tagsArray);
            foreach ($tagsArray as $tag) {
                $tagsHtml .= '<span class="badge badge-info mr-1">' . htmlspecialchars($tag) . '</span>';
            }
        }
        
        // Process sizes for display
        $sizesHtml = '';
        if (!empty($sizes)) {
            $sizesHtml = '<table class="table table-sm table-bordered">';
            $sizesHtml .= '<thead><tr><th>Size</th><th>Unit</th><th>Price</th><th>Discount</th><th>Default</th></tr></thead><tbody>';
            foreach ($sizes as $size) {
                $discountText = '';
                if ($size['discount_percentage'] > 0) {
                    $discountText = $size['discount_percentage'] . '% off';
                } elseif ($size['discount_amount'] > 0) {
                    $discountText = '$' . number_format($size['discount_amount'], 2) . ' off';
                } else {
                    $discountText = 'No discount';
                }
                $sizesHtml .= '<tr>';
                $sizesHtml .= '<td>' . htmlspecialchars($size['size']) . '</td>';
                $sizesHtml .= '<td>' . htmlspecialchars($size['unit_of_measure']) . '</td>';
                $sizesHtml .= '<td>$' . number_format($size['price'], 2) . '</td>';
                $sizesHtml .= '<td>' . $discountText . '</td>';
                $sizesHtml .= '<td>' . ($size['is_default'] ? '<span class="badge badge-success">Yes</span>' : '<span class="badge badge-secondary">No</span>') . '</td>';
                $sizesHtml .= '</tr>';
            }
            $sizesHtml .= '</tbody></table>';
        } else {
            $sizesHtml = '<p class="text-muted">No sizes available</p>';
        }
        
        // Process colors for display with correct image paths
        $colorsHtml = '';
        if (!empty($colors)) {
            $colorsHtml = '<div class="row">';
                foreach ($colors as $color) {
                    $colorsHtml .= '<div class="col-md-4 mb-3">';
                    $colorsHtml .= '<div class="card">';
                    $colorsHtml .= '<div class="card-body p-3">';
                    $colorsHtml .= '<div class="text-center mb-2">';
                    $colorsHtml .= '<div style="width: 50px; height: 50px; background-color: ' . htmlspecialchars($color['color_hex']) . '; border-radius: 50%; margin: 0 auto 10px; border: 2px solid #ddd;"></div>';
                    $colorsHtml .= '<div><strong>' . htmlspecialchars($color['color_hex']) . '</strong></div>';
                    $colorsHtml .= '<div class="small mt-1">' . ($color['is_default'] ? '<span class="badge badge-success">Default Color</span>' : '') . '</div>';
                    $colorsHtml .= '</div>';
                    
                    // Images side by side with labels inside
                    $colorsHtml .= '<div class="d-flex justify-content-around align-items-center mt-2">';
                    
                    // Front Image (Left)
                    $colorsHtml .= '<div class="text-center" style="flex: 1;">';
                    if ($color['front_image'] && file_exists(FCPATH . $color['front_image'])) {
                        $colorsHtml .= '<img src="' . base_url($color['front_image']) . '" style="height: 70px; width: 70px; object-fit: cover;" class="img-thumbnail rounded" alt="Front image">';
                        $colorsHtml .= '<div class="small text-muted mt-1">Front</div>';
                    } else {
                        $colorsHtml .= '<div class="border rounded d-flex align-items-center justify-content-center bg-light" style="height: 60px; width: 60px;">';
                        $colorsHtml .= '<i class="fas fa-image text-muted"></i>';
                        $colorsHtml .= '</div>';
                        $colorsHtml .= '<div class="small text-muted mt-1">Front</div>';
                    }
                    $colorsHtml .= '</div>';
                    
                    // Back Image (Right)
                    $colorsHtml .= '<div class="text-center" style="flex: 1;">';
                    if ($color['back_image'] && file_exists(FCPATH . $color['back_image'])) {
                        $colorsHtml .= '<img src="' . base_url($color['back_image']) . '" style="height: 70px; width: 70px; object-fit: cover;" class="img-thumbnail rounded" alt="Back image">';
                        $colorsHtml .= '<div class="small text-muted mt-1">Back</div>';
                    } else {
                        $colorsHtml .= '<div class="border rounded d-flex align-items-center justify-content-center bg-light" style="height: 60px; width: 60px;">';
                        $colorsHtml .= '<i class="fas fa-image text-muted"></i>';
                        $colorsHtml .= '</div>';
                        $colorsHtml .= '<div class="small text-muted mt-1">Back</div>';
                    }
                    $colorsHtml .= '</div>';
                    
                    $colorsHtml .= '</div>'; // Close d-flex
                    $colorsHtml .= '</div></div></div>'; // Close card-body, card, col
                }
            $colorsHtml .= '</div>';
        } else {
            $colorsHtml = '<p class="text-muted">No color variants available</p>';
        }
        
        // Process images for display
        $imagesHtml = '';
        if (!empty($images)) {
            $imagesHtml = '<div class="row">';
            foreach ($images as $image) {
                if (file_exists(FCPATH . $image['file_path'])) {
                    $imagesHtml .= '<div class="col-md-3 mb-3">';
                    $imagesHtml .= '<img src="' . base_url($image['file_path']) . '" class="img-fluid img-thumbnail" style="height: 150px; object-fit: cover; width: 100%;">';
                    $imagesHtml .= '</div>';
                }
            }
            $imagesHtml .= '</div>';
        } else {
            $imagesHtml = '<p class="text-muted">No product images available</p>';
        }
        
        // Prepare data for view
        $productData = [
            'product_id' => $product['product_id'],
            'product_name' => htmlspecialchars($product['product_name']),
            'slug' => $product['slug'],
            'description' => nl2br(htmlspecialchars($product['description'])),
            'categoryname' => $category ? htmlspecialchars($category['categoryname']) : 'Uncategorized',
            'tags' => $product['tags'],
            'tags_array' => $tagsArray,
            'tags_html' => $tagsHtml,
            'is_featured' => $product['is_featured'],
            'is_featured_badge' => $product['is_featured'] == 1 ? '<span class="badge badge-success">Featured Product</span>' : '<span class="badge badge-secondary">Standard Product</span>',
            'created_at' => date('F d Y, h:i:s A', strtotime($product['created_at'])),
            'updated_at' => date('F d Y, h:i:s A', strtotime($product['updated_at'])),
            'sizes' => $sizes,
            'sizes_html' => $sizesHtml,
            'colors' => $colors,
            'colors_html' => $colorsHtml,
            'images' => $images,
            'images_html' => $imagesHtml,
            'color_count' => count($colors),
            'image_count' => count($images),
            'size_count' => count($sizes)
        ];
        
        return $this->response->setJSON([
            'status' => 'success',
            'data' => $productData
        ]);
    }
    
    /**
     * Delete product
     */
    public function delete($id)
    {
        // Check if user is logged in
        if (!$this->session->get('AdminLoggedIn')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized'
            ]);
        }
        
        // Check if it's an AJAX request
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid request'
            ]);
        }
        
        $productModel = new ProductsModel();
        
        // Find the product by ID
        $product = $productModel->find($id);
        
        if ($product) {
            // Start transaction using db_connect()
            $db = db_connect();
            $db->transStart();
            
            try {
                // Delete product images and files
                $imageModel = new ProductImagesModel();
                $images = $imageModel->where('product_id', $id)->findAll();
                foreach ($images as $image) {
                    // Delete file from server
                    $filePath = FCPATH . $image['file_path'];
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }
                $imageModel->where('product_id', $id)->delete();
                
                // Delete entire product directory and all its contents
                $productDir = FCPATH . 'uploads/products/' . $id;
                if (is_dir($productDir)) {
                    $this->deleteDirectory($productDir);
                    log_message('info', 'Deleted product directory: ' . $productDir);
                }
                
                // Delete entire colors directory and all its contents
                $colorDir = FCPATH . 'uploads/products/colors/' . $id;
                if (is_dir($colorDir)) {
                    $this->deleteDirectory($colorDir);
                    log_message('info', 'Deleted colors directory: ' . $colorDir);
                }
                
                // Delete sizes
                $sizeModel = new SizesModel();
                $sizeModel->where('product_id', $id)->delete();
                
                // Delete colors and their images
                $colorModel = new ColorsModel();
                $colors = $colorModel->where('product_id', $id)->findAll();
                foreach ($colors as $color) {
                    // Delete individual color images if they exist (additional safety)
                    if (!empty($color['front_image']) && file_exists(FCPATH . $color['front_image'])) {
                        unlink(FCPATH . $color['front_image']);
                    }
                    if (!empty($color['back_image']) && file_exists(FCPATH . $color['back_image'])) {
                        unlink(FCPATH . $color['back_image']);
                    }
                }
                $colorModel->where('product_id', $id)->delete();
                
                // Delete the product record
                $deleted = $productModel->delete($id);
                
                if ($deleted) {
                    $db->transComplete();
                    
                    if ($db->transStatus() === false) {
                        throw new \Exception('Transaction failed');
                    }
                    
                    return $this->response->setJSON([
                        'status' => 'success',
                        'message' => 'Product deleted successfully'
                    ]);
                } else {
                    throw new \Exception('Failed to delete product');
                }
            } catch (\Exception $e) {
                $db->transRollback();
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ]);
            }
        }
        
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Product not found'
        ]);
    }

    /**
     * Recursively delete a directory and all its contents
     * 
     * @param string $dir Directory path
     * @return bool
     */
    private function deleteDirectory($dir)
    {
        if (!is_dir($dir)) {
            return false;
        }
        
        // Get all files and directories in the directory
        $items = scandir($dir);
        
        foreach ($items as $item) {
            // Skip current and parent directory links
            if ($item == '.' || $item == '..') {
                continue;
            }
            
            $path = $dir . DIRECTORY_SEPARATOR . $item;
            
            // If it's a directory, recursively delete it
            if (is_dir($path)) {
                $this->deleteDirectory($path);
            } 
            // If it's a file, delete it
            else {
                if (file_exists($path)) {
                    unlink($path);
                    log_message('debug', 'Deleted file: ' . $path);
                }
            }
        }
        
        // Delete the now-empty directory
        return rmdir($dir);
    }
    
    /**
     * Toggle featured status
     */
    public function toggleFeatured($id)
    {
        // Check if user is logged in
        if (!$this->session->get('AdminLoggedIn')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized'
            ]);
        }
        
        // Check if it's an AJAX request
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid request'
            ]);
        }
        
        $productModel = new ProductsModel();
        $product = $productModel->find($id);
        
        if ($product) {
            $newStatus = $product['is_featured'] == 1 ? 0 : 1;
            $productModel->update($id, ['is_featured' => $newStatus]);
            
            return $this->response->setJSON([
                'status' => 'success',
                'message' => $newStatus == 1 ? 'Product marked as featured' : 'Product removed from featured',
                'is_featured' => $newStatus
            ]);
        }
        
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Product not found'
        ]);
    }
}