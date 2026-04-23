<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BlogPostsModel;
use App\Models\BlogCategoriesModel;
use CodeIgniter\HTTP\ResponseInterface;

class BlogsController extends BaseController
{
    protected $blogPostsModel;
    protected $blogCategoriesModel;

    public function __construct()
    {
        $this->blogPostsModel = new BlogPostsModel();
        $this->blogCategoriesModel = new BlogCategoriesModel();
    }

    public function index()
    {
        $data = [
            'title' => 'The Blessed Manifest',
            'activeMenu' => 'blogs',
            'categories' => $this->getCategories()
        ];

        return view('pages/blogs', $data);
    }

    /**
     * Get blog posts with filtering, searching, and pagination (AJAX endpoint)
     */
    public function getPosts()
    {
        $page = $this->request->getVar('page') ?? 1;
        $search = $this->request->getVar('search') ?? '';
        $category = $this->request->getVar('category') ?? '';
        $sort = $this->request->getVar('sort') ?? 'latest';
        
        $perPage = 6;
        $offset = ($page - 1) * $perPage;
        
        $builder = $this->blogPostsModel->builder();
        
        // Join with categories table
        $builder->select('blog_posts.*, blog_categories.categoryname as category_name')
                ->join('blog_categories', 'blog_categories.blog_category_id = blog_posts.blog_category_id', 'left');
        
        // Filter by status (only published posts)
        $builder->where('blog_posts.status', 'published');
        
        // Search functionality
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('blog_posts.title', $search)
                    ->orLike('blog_posts.description', $search)
                    ->orLike('blog_posts.content', $search)
                    ->orLike('blog_posts.tags', $search)
                    ->groupEnd();
        }
        
        // Category filter
        if (!empty($category)) {
            $builder->where('blog_posts.blog_category_id', $category);
        }
        
        // Sorting
        switch ($sort) {
            case 'oldest':
                $builder->orderBy('blog_posts.published_at', 'ASC');
                break;
            case 'title_asc':
                $builder->orderBy('blog_posts.title', 'ASC');
                break;
            case 'title_desc':
                $builder->orderBy('blog_posts.title', 'DESC');
                break;
            default: // latest
                $builder->orderBy('blog_posts.published_at', 'DESC');
                break;
        }
        
        // Get total count for pagination
        $total = $builder->countAllResults(false);
        
        // Get paginated results
        $posts = $builder->limit($perPage, $offset)->get()->getResultArray();
        
        // Format posts data
        $formattedPosts = [];
        foreach ($posts as $post) {
            $formattedPosts[] = [
                'blog_post_id' => $post['blog_post_id'],
                'title' => $post['title'],
                'slug' => $post['slug'],
                'description' => $post['description'],
                'excerpt' => $post['excerpt'] ?? substr(strip_tags($post['content'] ?? ''), 0, 150),
                'content' => $post['content'] ?? '',
                'featured_image' => $post['featured_image'],
                'published_at' => $post['published_at'],
                'category_name' => $post['category_name'] ?? 'Uncategorized',
                'read_time' => $this->calculateReadTime($post['content'] ?? ''),
                'tags' => $post['tags'],
                'view_count' => $post['view_count'] ?? 0
            ];
        }
        
        $hasMore = ($offset + $perPage) < $total;
        
        return $this->response->setJSON([
            'success' => true,
            'posts' => $formattedPosts,
            'total' => $total,
            'page' => $page,
            'has_more' => $hasMore
        ]);
    }
    
    /**
     * Get all categories for dropdown and popular categories (AJAX endpoint)
     */
    public function getCategoriesAjax()
    {
        $categories = $this->blogCategoriesModel->builder()
            ->where('status', 'active')
            ->orderBy('categoryname', 'ASC')
            ->get()
            ->getResultArray();
        
        // Also get category counts (number of posts per category)
        foreach ($categories as &$category) {
            $postCount = $this->blogPostsModel->builder()
                ->where('blog_category_id', $category['blog_category_id'])
                ->where('status', 'published')
                ->countAllResults();
            $category['post_count'] = $postCount;
        }
        
        return $this->response->setJSON([
            'success' => true,
            'categories' => $categories
        ]);
    }
    
    /**
     * Get all categories (for initial page load)
     */
    private function getCategories()
    {
        return $this->blogCategoriesModel->builder()
            ->where('status', 'active')
            ->orderBy('categoryname', 'ASC')
            ->get()
            ->getResultArray();
    }
    
    /**
     * Calculate estimated read time
     */
    private function calculateReadTime($content)
    {
        $wordCount = str_word_count(strip_tags($content));
        $minutes = ceil($wordCount / 200);
        return max(1, $minutes);
    }
}