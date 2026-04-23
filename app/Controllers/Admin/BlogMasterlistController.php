<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\BlogPostsModel;
use App\Models\BlogCategoriesModel;
use Hermawan\DataTables\DataTable;

class BlogMasterlistController extends SessionController
{
    public function index()
    {
        $data = [
            'title' => 'The Blessed Manifest | Blog Masterlist',
            'activeMenu' => 'blogmasterlist'
        ];
        return view('pages/admin/blog-masterlist', $data);
    }
    
    public function getData()
    {
        $db = db_connect();
        $builder = $db->table('blog_posts')
                    ->select('blog_posts.blog_post_id, blog_posts.title, blog_posts.slug, blog_posts.description, blog_posts.excerpt, blog_posts.blog_category_id, blog_posts.featured_image, blog_posts.tags, blog_posts.status, blog_posts.content, blog_posts.published_at, blog_posts.created_at, blog_posts.updated_at, blog_posts.view_count, blog_posts.meta_keywords, blog_posts.is_featured, blog_categories.categoryname')
                    ->join('blog_categories', 'blog_categories.blog_category_id = blog_posts.blog_category_id', 'left')
                    ->orderBy('blog_posts.blog_post_id', 'DESC');

        // Step 1: get Response object
        $response = DataTable::of($builder)->toJson();

        // Step 2: extract JSON string
        $json = $response->getBody();

        // Step 3: decode
        $result = json_decode($json, true);

        // Step 4: transform
        $data = [];
        foreach ($result['data'] as $row) {
            // Process tags - convert comma-separated string to array for better display
            $tagsArray = [];
            $tagsHtml = '';
            if (!empty($row[7])) { // tags is at index 7
                $tagsArray = explode(',', $row[7]);
                $tagsArray = array_map('trim', $tagsArray);
                // Limit tags to 3 for better display
                $displayTags = array_slice($tagsArray, 0, 3);
                $tagsHtml = '';
                foreach ($displayTags as $tag) {
                    $tagsHtml .= '<span class="badge badge-primary mr-1">' . htmlspecialchars($tag) . '</span>';
                }
                if (count($tagsArray) > 3) {
                    $tagsHtml .= '<span class="badge badge-secondary">+' . (count($tagsArray) - 3) . '</span>';
                }
            }
            
            // Featured badge
            $featuredBadge = '';
            if (isset($row[15]) && $row[15] == 1) {
                $featuredBadge = '<span class="badge badge-info ml-1"><i class="fas fa-star"></i> Featured</span>';
            }
            
            $data[] = [
                'blog_post_id' => $row[0],
                'title' => $row[1],
                'slug' => $row[2],
                'description' => $row[3],
                'excerpt' => $row[4] ?? substr(strip_tags($row[9] ?? ''), 0, 100),
                'blog_category_id' => $row[5],
                'featured_image' => $row[6],
                'tags' => $row[7],
                'tags_array' => $tagsArray,
                'tags_html' => $tagsHtml,
                'status' => $row[8],
                'status_badge' => $row[8] == 'published' ? '<span class="badge badge-success">Published</span>' : '<span class="badge badge-warning">Draft</span>',
                'content' => $row[9],
                'published_at' => $row[10] ? date('F d Y, h:i A', strtotime($row[10])) : 'Not published',
                'created_at' => date('F d Y, h:i A', strtotime($row[11])),
                'updated_at' => date('F d Y, h:i A', strtotime($row[12])),
                'view_count' => $row[13] ?? 0,
                'meta_keywords' => $row[14] ?? '',
                'is_featured' => $row[15] ?? 0,
                'featured_badge' => $featuredBadge,
                'categoryname' => $row[16] ?? 'Uncategorized',
                'excerpt_text' => strlen(strip_tags($row[4] ?? $row[9] ?? '')) > 100 ? substr(strip_tags($row[4] ?? $row[9] ?? ''), 0, 100) . '...' : strip_tags($row[4] ?? $row[9] ?? '')
            ];
        }

        // Step 5: replace data
        $result['data'] = $data;

        // Step 6: return clean JSON
        return $this->response->setJSON($result);
    }
    
    /**
     * Get single blog post for viewing
     */
    public function getBlog($id)
    {
        // Check if it's an AJAX request
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid request'
            ]);
        }
        
        $blogModel = new BlogPostsModel();
        $blog = $blogModel->find($id);
        
        if (!$blog) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Blog post not found'
            ]);
        }
        
        // Get category details
        $categoryModel = new BlogCategoriesModel();
        $category = $categoryModel->find($blog['blog_category_id']);
        
        // Process tags
        $tagsArray = [];
        $tagsHtml = '';
        if (!empty($blog['tags'])) {
            $tagsArray = explode(',', $blog['tags']);
            $tagsArray = array_map('trim', $tagsArray);
            foreach ($tagsArray as $tag) {
                $tagsHtml .= '<span class="badge badge-primary mr-1">' . htmlspecialchars($tag) . '</span>';
            }
        }
        
        // Prepare data for view
        $blogData = [
            'blog_post_id' => $blog['blog_post_id'],
            'title' => htmlspecialchars($blog['title']),
            'slug' => $blog['slug'],
            'description' => htmlspecialchars($blog['description'] ?? ''),
            'excerpt' => htmlspecialchars($blog['excerpt'] ?? ''),
            'meta_keywords' => htmlspecialchars($blog['meta_keywords'] ?? ''),
            'content' => $blog['content'],
            'featured_image' => $blog['featured_image'],
            'tags' => $blog['tags'],
            'tags_array' => $tagsArray,
            'tags_html' => $tagsHtml,
            'status' => $blog['status'],
            'status_badge' => $blog['status'] == 'published' ? '<span class="badge badge-success">Published</span>' : '<span class="badge badge-warning">Draft</span>',
            'is_featured' => $blog['is_featured'] ?? 0,
            'featured_badge' => ($blog['is_featured'] ?? 0) == 1 ? '<span class="badge badge-info"><i class="fas fa-star"></i> Featured</span>' : '',
            'published_at' => $blog['published_at'] ? date('F d Y, h:i A', strtotime($blog['published_at'])) : 'Not published',
            'created_at' => date('F d Y, h:i A', strtotime($blog['created_at'])),
            'updated_at' => date('F d Y, h:i A', strtotime($blog['updated_at'])),
            'categoryname' => $category ? htmlspecialchars($category['categoryname']) : 'Uncategorized',
            'view_count' => $blog['view_count'] ?? 0
        ];
        
        return $this->response->setJSON([
            'status' => 'success',
            'data' => $blogData
        ]);
    }
    
    public function delete($id)
    {
        // Check if it's an AJAX request
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid request'
            ]);
        }
        
        $blogModel = new BlogPostsModel();
        
        // Find the blog post by ID
        $blog = $blogModel->find($id);
        
        if ($blog) {
            // Delete featured image if exists
            if (!empty($blog['featured_image']) && file_exists($blog['featured_image'])) {
                unlink($blog['featured_image']);
            }
            
            // Delete the blog post record from the database
            $deleted = $blogModel->delete($id);
            
            if ($deleted) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Blog post deleted successfully'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error', 
                    'message' => 'Failed to delete the blog post from the database'
                ]);
            }
        }
        
        return $this->response->setJSON([
            'status' => 'error', 
            'message' => 'Blog post not found'
        ]);
    }
    
    /**
     * Toggle featured status
     */
    public function toggleFeatured($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid request'
            ]);
        }
        
        $blogModel = new BlogPostsModel();
        $blog = $blogModel->find($id);
        
        if (!$blog) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Blog post not found'
            ]);
        }
        
        $newFeaturedStatus = ($blog['is_featured'] ?? 0) == 1 ? 0 : 1;
        
        if ($blogModel->update($id, ['is_featured' => $newFeaturedStatus])) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => $newFeaturedStatus ? 'Blog marked as featured' : 'Blog removed from featured',
                'is_featured' => $newFeaturedStatus
            ]);
        }
        
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Failed to update featured status'
        ]);
    }
}