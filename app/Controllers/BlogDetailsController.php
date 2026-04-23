<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BlogPostsModel;
use App\Models\BlogCategoriesModel;
use CodeIgniter\HTTP\ResponseInterface;

class BlogDetailsController extends BaseController
{
    protected $blogPostsModel;
    protected $blogCategoriesModel;

    public function __construct()
    {
        $this->blogPostsModel = new BlogPostsModel();
        $this->blogCategoriesModel = new BlogCategoriesModel();
    }

    public function index($slug = null)
    {
        if (!$slug) {
            return redirect()->to('/blogs');
        }

        // Get the blog post by slug
        $post = $this->blogPostsModel->builder()
            ->select('blog_posts.*, blog_categories.categoryname as category_name')
            ->join('blog_categories', 'blog_categories.blog_category_id = blog_posts.blog_category_id', 'left')
            ->where('blog_posts.slug', $slug)
            ->where('blog_posts.status', 'published')
            ->get()
            ->getRowArray();

        if (!$post) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Blog post not found');
        }

        // Increment view count (unique per user per day)
        $this->incrementUniqueViewPerDay($post['blog_post_id']);

        // Get related posts (same category, excluding current)
        $relatedPosts = $this->blogPostsModel->builder()
            ->select('blog_post_id, title, slug, featured_image, published_at, description')
            ->where('blog_category_id', $post['blog_category_id'])
            ->where('blog_post_id !=', $post['blog_post_id'])
            ->where('status', 'published')
            ->limit(3)
            ->get()
            ->getResultArray();

        // Get all categories for sidebar
        $categories = $this->blogCategoriesModel->builder()
            ->where('status', 'active')
            ->orderBy('categoryname', 'ASC')
            ->get()
            ->getResultArray();

        // Get recent posts
        $recentPosts = $this->blogPostsModel->builder()
            ->select('blog_post_id, title, slug, featured_image, published_at')
            ->where('status', 'published')
            ->where('blog_post_id !=', $post['blog_post_id'])
            ->orderBy('published_at', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        $readTime = $this->calculateReadTime($post['content'] ?? '');

        $data = [
            'title' => $post['title'] . ' - The Blessed Manifest',
            'activeMenu' => 'blogs',
            'post' => $post,
            'relatedPosts' => $relatedPosts,
            'categories' => $categories,
            'recentPosts' => $recentPosts,
            'read_time' => $readTime
        ];

        return view('pages/blog-details', $data);
    }

    /**
     * Increment view count - unique per user per day (Dev.to style)
     * - Each unique visitor counts once per 24 hours
     * - Page refreshes within 24 hours don't count
     */
    private function incrementUniqueViewPerDay($postId)
    {
        $cookieName = 'viewed_post_' . $postId;
        
        // Check if cookie exists
        $cookie = $this->request->getCookie($cookieName);
        
        if (!$cookie) {
            // Set cookie that expires in 24 hours (86400 seconds)
            // Correct parameter order: name, value, expire, domain, path, prefix, secure, httponly, samesite
            $this->response->setCookie(
                $cookieName,  // name
                '1',          // value
                86400,        // expire (24 hours)
                '',           // domain
                '/',          // path
                '',           // prefix (empty string, not false)
                false,        // secure
                true          // httponly
            );
            
            // Increment the view count in database
            $this->blogPostsModel->builder()
                ->set('view_count', 'view_count + 1', false)
                ->where('blog_post_id', $postId)
                ->update();
        }
    }

    /**
     * Alternative method using helper function (simpler)
     */
    private function incrementUniqueViewPerDayAlt($postId)
    {
        $cookieName = 'viewed_post_' . $postId;
        
        // Check if cookie exists using helper
        if (!get_cookie($cookieName)) {
            // Set cookie using helper (simpler)
            set_cookie($cookieName, '1', 86400); // 24 hours
            
            // Increment the view count in database
            $this->blogPostsModel->builder()
                ->set('view_count', 'view_count + 1', false)
                ->where('blog_post_id', $postId)
                ->update();
        }
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