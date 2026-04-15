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
                    ->select('blog_posts.blog_post_id, blog_posts.title, blog_posts.slug, blog_posts.description, blog_posts.blog_category_id, blog_posts.featured_image, blog_posts.tags, blog_posts.status, blog_posts.content, blog_posts.published_at, blog_posts.created_at, blog_posts.updated_at, blog_categories.categoryname')
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
            if (!empty($row[6])) {
                $tagsArray = explode(',', $row[6]);
                $tagsArray = array_map('trim', $tagsArray);
                // Create HTML badges for tags
                $tagsHtml = '';
                foreach ($tagsArray as $tag) {
                    $tagsHtml .= '<span class="badge badge-primary mr-1">' . htmlspecialchars($tag) . '</span>';
                }
            }
            
            $data[] = [
                'blog_post_id' => $row[0],
                'title' => $row[1],
                'slug' => $row[2],
                'description' => $row[3],
                'blog_category_id' => $row[4],
                'featured_image' => $row[5],
                'tags' => $row[6], // Original comma-separated string
                'tags_array' => $tagsArray, // Array of tags for easier handling
                'tags_html' => $tagsHtml, // HTML formatted tags for display
                'status' => $row[7],
                'status_badge' => $row[7] == 'published' ? '<span class="badge badge-success">Published</span>' : '<span class="badge badge-warning">Draft</span>',
                'content' => $row[8],
                'published_at' => $row[9] ? date('F d Y, h:i:s A', strtotime($row[9])) : 'Not published',
                'created_at' => date('F d Y, h:i:s A', strtotime($row[10])),
                'updated_at' => date('F d Y, h:i:s A', strtotime($row[11])),
                'categoryname' => $row[12] ?? 'Uncategorized',
                // Add excerpt for preview (first 100 characters of content)
                'excerpt' => strlen(strip_tags($row[8])) > 100 ? substr(strip_tags($row[8]), 0, 100) . '...' : strip_tags($row[8])
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
            foreach ($tagsArray as $index => $tag) {
                $tagsHtml .= '<span class="badge badge-primary mr-1">' . htmlspecialchars($tag) . '</span>';
            }
        }
        
        // Prepare data for view
        $blogData = [
            'blog_post_id' => $blog['blog_post_id'],
            'title' => htmlspecialchars($blog['title']),
            'slug' => $blog['slug'],
            'description' => htmlspecialchars($blog['description']),
            'content' => $blog['content'],
            'featured_image' => $blog['featured_image'],
            'tags' => $blog['tags'],
            'tags_array' => $tagsArray,
            'tags_html' => $tagsHtml,
            'status' => $blog['status'],
            'status_badge' => $blog['status'] == 'published' ? '<span class="badge badge-success">Published</span>' : '<span class="badge badge-warning">Draft</span>',
            'published_at' => $blog['published_at'] ? date('F d Y, h:i:s A', strtotime($blog['published_at'])) : 'Not published',
            'created_at' => date('F d Y, h:i:s A', strtotime($blog['created_at'])),
            'updated_at' => date('F d Y, h:i:s A', strtotime($blog['updated_at'])),
            'categoryname' => $category ? htmlspecialchars($category['categoryname']) : 'Uncategorized',
            'views' => $blog['views'] ?? 0
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
}
