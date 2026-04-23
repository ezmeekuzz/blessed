<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\BlogPostsModel;
use App\Models\BlogCategoriesModel;

class AddBlogController extends SessionController
{
    public function index()
    {
        $data = [
            'title' => 'The Blessed Manifest | Add Blog',
            'activeMenu' => 'addblog'
        ];

        return view('pages/admin/add-blog', $data);
    }
    
    public function insert()
    {
        // Check if this is an AJAX request
        if (!$this->request->isAJAX()) {
            return redirect()->to('/admin/addblog')->with('error', 'Invalid request method.');
        }
        
        $blogModel = new BlogPostsModel();
        
        // Validation rules
        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'slug' => 'required|is_unique[blog_posts.slug]',
            'blog_category_id' => 'required|is_not_unique[blog_categories.blog_category_id]',
            'content' => 'required',
            'status' => 'required|in_list[draft,published]'
        ];
        
        if (!$this->validate($rules)) {
            $errors = $this->validator->getErrors();
            $errorMessages = [];
            foreach ($errors as $field => $error) {
                $errorMessages[] = $error;
            }
            
            return $this->response->setJSON([
                'success' => false,
                'message' => implode('<br>', $errorMessages)
            ]);
        }
        
        // Handle file upload
        $featuredImage = $this->uploadFeaturedImage();
        
        // Prepare data with all fields including new ones
        $data = [
            'title' => $this->request->getPost('title'),
            'slug' => $this->request->getPost('slug'),
            'description' => $this->request->getPost('description'),
            'excerpt' => $this->request->getPost('excerpt'),
            'blog_category_id' => $this->request->getPost('blog_category_id'),
            'featured_image' => $featuredImage,
            'tags' => $this->request->getPost('tags'),
            'status' => $this->request->getPost('status'),
            'content' => $this->request->getPost('content'),
            'meta_keywords' => $this->request->getPost('meta_keywords'),
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0,
            'author_id' => session()->get('admin_user_id') ? session()->get('admin_user_id') : NULL,
            'view_count' => 0 // Initialize view count
        ];
        
        // Handle published_at
        $publishedAt = $this->request->getPost('published_at');
        if ($publishedAt) {
            $data['published_at'] = date('Y-m-d H:i:s', strtotime($publishedAt));
        } else {
            $data['published_at'] = $data['status'] === 'published' ? date('Y-m-d H:i:s') : null;
        }
        
        // Save to database
        if ($blogModel->insert($data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Blog post created successfully!',
                'blog_id' => $blogModel->insertID()
            ]);
        }
        
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to create blog post. Please try again.'
        ]);
    }

    private function uploadFeaturedImage()
    {
        $file = $this->request->getFile('featured_image');
        
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Validate file
            $validationRule = [
                'featured_image' => [
                    'label' => 'Image File',
                    'rules' => 'is_image[featured_image]|max_size[featured_image,2048]|mime_in[featured_image,image/jpg,image/jpeg,image/png,image/webp]',
                ],
            ];
            
            if (!$this->validate($validationRule)) {
                return null;
            }
            
            $newName = $file->getRandomName();
            $file->move('uploads/blogs', $newName);
            return 'uploads/blogs/' . $newName;
        }
        
        return null;
    }
    
    public function categoryList()
    {
        $categoryModel = new BlogCategoriesModel();
        $categories = $categoryModel->where('status', 'active')->orderBy('categoryname', 'ASC')->findAll();
        
        return $this->response->setJSON($categories);
    }
    
    public function checkSlug()
    {
        $slug = $this->request->getPost('slug');
        $blogModel = new BlogPostsModel();
        
        $exists = $blogModel->where('slug', $slug)->first();
        
        return $this->response->setJSON([
            'exists' => !empty($exists)
        ]);
    }
}