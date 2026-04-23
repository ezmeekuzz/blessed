<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BlogPostsModel;
use CodeIgniter\HTTP\ResponseInterface;

class HomeController extends BaseController
{
    protected $blogPostsModel;

    public function __construct()
    {
        $this->blogPostsModel = new BlogPostsModel();
    }

    public function index()
    {
        // Get featured blog posts (is_featured = 1 and status = published)
        $featuredPosts = $this->blogPostsModel->builder()
            ->select('blog_posts.blog_post_id, blog_posts.title, blog_posts.slug, blog_posts.featured_image, blog_posts.published_at, blog_posts.tags, blog_categories.categoryname')
            ->join('blog_categories', 'blog_categories.blog_category_id = blog_posts.blog_category_id', 'left')
            ->where('blog_posts.status', 'published')
            ->where('blog_posts.is_featured', 1)
            ->orderBy('blog_posts.published_at', 'DESC')
            ->limit(3)
            ->get()
            ->getResultArray();

        // If no featured posts, get latest published posts as fallback
        if (empty($featuredPosts)) {
            $featuredPosts = $this->blogPostsModel->builder()
                ->select('blog_posts.blog_post_id, blog_posts.title, blog_posts.slug, blog_posts.featured_image, blog_posts.published_at, blog_posts.tags, blog_categories.categoryname')
                ->join('blog_categories', 'blog_categories.blog_category_id = blog_posts.blog_category_id', 'left')
                ->where('blog_posts.status', 'published')
                ->orderBy('blog_posts.published_at', 'DESC')
                ->limit(3)
                ->get()
                ->getResultArray();
        }

        // Calculate read time for each post
        foreach ($featuredPosts as &$post) {
            $post['read_time'] = $this->calculateReadTime($post['content'] ?? '');
        }

        $data = [
            'title' => 'The Blessed Manifest',
            'activeMenu' => 'home',
            'featuredPosts' => $featuredPosts
        ];

        return view('pages/home', $data);
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