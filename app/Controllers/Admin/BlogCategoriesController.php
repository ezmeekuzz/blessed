<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\BlogCategoriesModel;
use Hermawan\DataTables\DataTable;

class BlogCategoriesController extends SessionController
{
    public function index()
    {
        $data = [
            'title' => 'The Blessed Manifest | Blog Categories',
            'activeMenu' => 'blogcategories'
        ];

        return view('pages/admin/blog-categories', $data);
    }
    
    public function insert()
    {
        // Check if it's an AJAX request
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid request'
            ]);
        }
        
        // Validate the input
        $categoryName = trim($this->request->getPost('categoryname'));
        
        if (empty($categoryName)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Category name is required'
            ]);
        }
        
        $blogCategoriesModel = new BlogCategoriesModel();
        
        // Check if category already exists
        $existingCategory = $blogCategoriesModel->where('categoryname', $categoryName)->first();
        if ($existingCategory) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Category already exists'
            ]);
        }
        
        $data = [
            'categoryname' => $categoryName,
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        try {
            $insertId = $blogCategoriesModel->insert($data);
            
            if ($insertId) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Category added successfully',
                    'data' => [
                        'blog_category_id' => $insertId,
                        'categoryname' => $categoryName,
                        'status' => 'active',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Failed to add category'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Database error: ' . $e->getMessage()
            ]);
        }
    }
    
    public function getData()
    {
        $db = db_connect();
        $builder = $db->table('blog_categories');

        // Step 1: get Response object
        $response = DataTable::of($builder)->toJson();

        // Step 2: extract JSON string
        $json = $response->getBody();

        // Step 3: decode
        $result = json_decode($json, true);

        // Step 4: transform
        $data = [];
        foreach ($result['data'] as $row) {
            $data[] = [
                'blog_category_id' => $row[0],
                'categoryname'     => $row[1],
                'status'           => $row[2],
                'created_at'       => date('F d Y, h:i:s A', strtotime($row[3])),
                'updated_at'       => date('F d Y, h:i:s A', strtotime($row[4])),
            ];
        }

        // Step 5: replace data
        $result['data'] = $data;

        // Step 6: return clean JSON
        return $this->response->setJSON($result);
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
        
        $blogCategoriesModel = new BlogCategoriesModel();
        $category = $blogCategoriesModel->find($id);
        
        if (!$category) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Category not found'
            ]);
        }
        
        // Check if category has posts
        $db = db_connect();
        $postCount = $db->table('blog_posts')
                        ->where('blog_category_id', $id)
                        ->countAllResults();
        
        if ($postCount > 0) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => "Cannot delete category with {$postCount} post(s). Please reassign or delete the posts first."
            ]);
        }
        
        try {
            if ($blogCategoriesModel->delete($id)) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Category deleted successfully'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Failed to delete category'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Database error: ' . $e->getMessage()
            ]);
        }
    }

    public function update($id)
    {
        // Check if it's an AJAX request
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid request'
            ]);
        }
        
        // Validate the input
        $categoryName = trim($this->request->getPost('categoryname'));
        $status = trim($this->request->getPost('status'));
        
        if (empty($categoryName)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Category name is required'
            ]);
        }
        
        $blogCategoriesModel = new BlogCategoriesModel();
        
        // Check if category exists
        $category = $blogCategoriesModel->find($id);
        if (!$category) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Category not found'
            ]);
        }
        
        // Check if category name already exists for another category
        $existingCategory = $blogCategoriesModel->where('categoryname', $categoryName)
                                                ->where('blog_category_id !=', $id)
                                                ->first();
        if ($existingCategory) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Category name already exists'
            ]);
        }
        
        $data = [
            'categoryname' => $categoryName,
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        try {
            if ($blogCategoriesModel->update($id, $data)) {
                // Get the updated data
                $updatedCategory = $blogCategoriesModel->find($id);
                
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Category updated successfully',
                    'data' => [
                        'blog_category_id' => $updatedCategory['blog_category_id'],
                        'categoryname' => $updatedCategory['categoryname'],
                        'status' => $updatedCategory['status'],
                        'created_at' => date('F d Y, h:i:s A', strtotime($updatedCategory['created_at'])),
                        'updated_at' => date('F d Y, h:i:s A', strtotime($updatedCategory['updated_at']))
                    ]
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Failed to update category'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Database error: ' . $e->getMessage()
            ]);
        }
    }

    public function getCategory($id)
    {
        // Check if it's an AJAX request
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid request'
            ]);
        }
        
        $blogCategoriesModel = new BlogCategoriesModel();
        $category = $blogCategoriesModel->find($id);
        
        if (!$category) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Category not found'
            ]);
        }
        
        return $this->response->setJSON([
            'status' => 'success',
            'data' => [
                'blog_category_id' => $category['blog_category_id'],
                'categoryname' => $category['categoryname'],
                'status' => $category['status']
            ]
        ]);
    }
}