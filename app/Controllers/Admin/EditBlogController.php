<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\BlogPostsModel;
use App\Models\BlogCategoriesModel;

class EditBlogController extends SessionController
{
    public function index($id)
    {
        $blogModel = new BlogPostsModel();
        $blog = $blogModel->find($id);
        
        if (!$blog) {
            return redirect()->to('/admin/blogmasterlist')->with('error', 'Blog post not found.');
        }
        
        $data = [
            'title' => 'The Blessed Manifest | Edit Blog',
            'activeMenu' => 'blogmasterlist',
            'blog' => $blog
        ];

        return view('pages/admin/edit-blog', $data);
    }
    
    public function update($id)
    {
        // Check if this is an AJAX request
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request method.'
            ]);
        }
        
        $blogModel = new BlogPostsModel();
        
        // Check if blog exists
        $blog = $blogModel->find($id);
        if (!$blog) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Blog post not found.'
            ]);
        }
        
        // Validation rules
        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'slug' => 'required',
            'blog_category_id' => 'required|is_not_unique[blog_categories.blog_category_id]',
            'content' => 'required',
            'status' => 'required|in_list[draft,published]'
        ];
        
        // Check if slug is unique (excluding current blog)
        $existingSlug = $blogModel->where('slug', $this->request->getPost('slug'))
                                   ->where('blog_post_id !=', $id)
                                   ->first();
        if ($existingSlug) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Slug already exists. Please use a unique URL.'
            ]);
        }
        
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
        
        // Handle file upload if new image is provided
        $featuredImage = $blog['featured_image']; // Keep existing image
        $file = $this->request->getFile('featured_image');
        
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Validate file
            $validationRule = [
                'featured_image' => [
                    'label' => 'Image File',
                    'rules' => 'is_image[featured_image]|max_size[featured_image,2048]|mime_in[featured_image,image/jpg,image/jpeg,image/png,image/webp]',
                ],
            ];
            
            if ($this->validate($validationRule)) {
                // Delete old image if exists
                if ($featuredImage && file_exists($featuredImage)) {
                    unlink($featuredImage);
                }
                
                $newName = $file->getRandomName();
                $file->move('uploads/blogs', $newName);
                $featuredImage = 'uploads/blogs/' . $newName;
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Invalid image file. Please upload JPG, PNG, GIF, or WEBP (max 2MB).'
                ]);
            }
        }
        
        // Prepare data with all fields
        $data = [
            'title' => $this->request->getPost('title'),
            'slug' => $this->request->getPost('slug'),
            'description' => $this->request->getPost('description'), // Serves as meta description
            'excerpt' => $this->request->getPost('excerpt'),
            'blog_category_id' => $this->request->getPost('blog_category_id'),
            'featured_image' => $featuredImage,
            'tags' => $this->request->getPost('tags'),
            'status' => $this->request->getPost('status'),
            'content' => $this->request->getPost('content'),
            'meta_keywords' => $this->request->getPost('meta_keywords'),
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        // Handle published_at
        $publishedAt = $this->request->getPost('published_at');
        if ($publishedAt) {
            $data['published_at'] = date('Y-m-d H:i:s', strtotime($publishedAt));
        } elseif ($data['status'] === 'published' && !$blog['published_at']) {
            $data['published_at'] = date('Y-m-d H:i:s');
        }
        
        // Update database
        if ($blogModel->update($id, $data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Blog post updated successfully!',
                'blog_id' => $id
            ]);
        }
        
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to update blog post. Please try again.'
        ]);
    }
    
    public function getCategories()
    {
        $categoryModel = new BlogCategoriesModel();
        $categories = $categoryModel->where('status', 'active')
                                     ->orderBy('categoryname', 'ASC')
                                     ->findAll();
        
        return $this->response->setJSON($categories);
    }
    
    public function checkSlug()
    {
        $slug = $this->request->getPost('slug');
        $id = $this->request->getPost('id');
        $blogModel = new BlogPostsModel();
        
        $exists = $blogModel->where('slug', $slug)
                            ->where('blog_post_id !=', $id)
                            ->first();
        
        return $this->response->setJSON([
            'exists' => !empty($exists)
        ]);
    }
}