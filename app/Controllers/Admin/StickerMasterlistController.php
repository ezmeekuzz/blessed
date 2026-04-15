<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\StickersModel;
use Hermawan\DataTables\DataTable;

class StickerMasterlistController extends SessionController
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
            'title' => 'The Blessed Manifest | Sticker Masterlist',
            'activeMenu' => 'stickermasterlist'
        ];
        return view('pages/admin/sticker-masterlist', $data);
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
        
        // Only get records where deleted_at IS NULL (not soft deleted)
        $builder = $db->table('stickers')
                    ->select('
                        sticker_id, 
                        title, 
                        image_url, 
                        tags, 
                        description, 
                        is_active,
                        created_at,
                        updated_at,
                        deleted_at
                    ')
                    ->where('deleted_at IS NULL', null, false)
                    ->orderBy('sticker_id', 'DESC');

        // Get DataTable response
        $response = DataTable::of($builder)->toJson();
        $json = $response->getBody();
        $result = json_decode($json, true);
        
        // Check if data key exists, if not, initialize empty array
        if (!isset($result['data'])) {
            $result['data'] = [];
        }

        // Transform data
        $data = [];
        foreach ($result['data'] as $row) {
            // Process tags
            $tagsArray = [];
            $tagsHtml = '';
            if (!empty($row[3])) {
                $tagsArray = explode(',', $row[3]);
                $tagsArray = array_map('trim', $tagsArray);
                foreach ($tagsArray as $tag) {
                    $tagsHtml .= '<span class="badge badge-info mr-1 mb-1">' . htmlspecialchars($tag) . '</span>';
                }
            }
            
            // Determine image type (local or external)
            $imageUrl = $row[2];
            $isExternal = filter_var($imageUrl, FILTER_VALIDATE_URL) && 
                          (strpos($imageUrl, 'http://') === 0 || strpos($imageUrl, 'https://') === 0);
            
            $data[] = [
                'sticker_id' => $row[0],
                'title' => $row[1],
                'image_url' => $row[2],
                'image_url_display' => $imageUrl, // Store as is, let JS handle base_url
                'is_external' => $isExternal,
                'tags' => $row[3],
                'tags_array' => $tagsArray,
                'tags_html' => $tagsHtml,
                'description' => $row[4],
                'is_active' => $row[5],
                'status_badge' => $row[5] == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>',
                'created_at' => $row[6] ? date('F d Y, h:i:s A', strtotime($row[6])) : 'N/A',
                'updated_at' => $row[7] ? date('F d Y, h:i:s A', strtotime($row[7])) : 'N/A',
                'deleted_at' => $row[8]
            ];
        }

        $result['data'] = $data;
        return $this->response->setJSON($result);
    }
    
    public function getTrashData()
    {
        // Check if user is logged in
        if (!$this->session->get('AdminLoggedIn')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized'
            ]);
        }
        
        $db = db_connect();
        
        // Get only soft-deleted records (deleted_at IS NOT NULL)
        $builder = $db->table('stickers')
                    ->select('
                        sticker_id, 
                        title, 
                        image_url, 
                        tags, 
                        description, 
                        is_active,
                        created_at,
                        updated_at,
                        deleted_at
                    ')
                    ->where('deleted_at IS NOT NULL', null, false)
                    ->orderBy('deleted_at', 'DESC');

        // Get DataTable response
        $response = DataTable::of($builder)->toJson();
        $json = $response->getBody();
        $result = json_decode($json, true);
        
        // Check if data key exists, if not, initialize empty array
        if (!isset($result['data'])) {
            $result['data'] = [];
        }

        // Transform data
        $data = [];
        foreach ($result['data'] as $row) {
            // Process tags
            $tagsArray = [];
            $tagsHtml = '';
            if (!empty($row[3])) {
                $tagsArray = explode(',', $row[3]);
                $tagsArray = array_map('trim', $tagsArray);
                foreach ($tagsArray as $tag) {
                    $tagsHtml .= '<span class="badge badge-info mr-1 mb-1">' . htmlspecialchars($tag) . '</span>';
                }
            }
            
            // Determine image type (local or external)
            $imageUrl = $row[2];
            $isExternal = filter_var($imageUrl, FILTER_VALIDATE_URL) && 
                          (strpos($imageUrl, 'http://') === 0 || strpos($imageUrl, 'https://') === 0);
            
            $data[] = [
                'sticker_id' => $row[0],
                'title' => $row[1],
                'image_url' => $row[2],
                'image_url_display' => $imageUrl,
                'is_external' => $isExternal,
                'tags' => $row[3],
                'tags_array' => $tagsArray,
                'tags_html' => $tagsHtml,
                'description' => $row[4],
                'is_active' => $row[5],
                'status_badge' => $row[5] == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>',
                'created_at' => $row[6] ? date('F d Y, h:i:s A', strtotime($row[6])) : 'N/A',
                'updated_at' => $row[7] ? date('F d Y, h:i:s A', strtotime($row[7])) : 'N/A',
                'deleted_at' => $row[8] ? date('F d Y, h:i:s A', strtotime($row[8])) : 'N/A'
            ];
        }

        $result['data'] = $data;
        return $this->response->setJSON($result);
    }
    
    /**
     * Get trash count only (simple endpoint, not DataTable)
     */
    public function getTrashCount()
    {
        // Check if user is logged in
        if (!$this->session->get('AdminLoggedIn')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized'
            ]);
        }
        
        $db = db_connect();
        $count = $db->table('stickers')
                    ->where('deleted_at IS NOT NULL', null, false)
                    ->countAllResults();
        
        return $this->response->setJSON([
            'status' => 'success',
            'count' => $count
        ]);
    }
    
    /**
     * Get single sticker for viewing (including soft-deleted)
     */
    public function getSticker($id)
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
        
        $stickersModel = new StickersModel();
        // Use withDeleted to include soft-deleted records
        $sticker = $stickersModel->withDeleted()->find($id);
        
        if (!$sticker) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Sticker not found'
            ]);
        }
        
        // Process tags
        $tagsArray = [];
        $tagsHtml = '';
        if (!empty($sticker['tags'])) {
            $tagsArray = explode(',', $sticker['tags']);
            $tagsArray = array_map('trim', $tagsArray);
            foreach ($tagsArray as $tag) {
                $tagsHtml .= '<span class="badge badge-info mr-1">' . htmlspecialchars($tag) . '</span>';
            }
        }
        
        // Determine if image is external or local
        $isExternal = filter_var($sticker['image_url'], FILTER_VALIDATE_URL) && 
                      (strpos($sticker['image_url'], 'http://') === 0 || strpos($sticker['image_url'], 'https://') === 0);
        $displayImageUrl = $isExternal ? $sticker['image_url'] : base_url($sticker['image_url']);
        
        // Prepare data for view
        $stickerData = [
            'sticker_id' => $sticker['sticker_id'],
            'title' => htmlspecialchars($sticker['title']),
            'image_url' => $sticker['image_url'],
            'display_image_url' => $displayImageUrl,
            'is_external' => $isExternal,
            'description' => nl2br(htmlspecialchars($sticker['description'])),
            'tags' => $sticker['tags'],
            'tags_array' => $tagsArray,
            'tags_html' => $tagsHtml,
            'is_active' => $sticker['is_active'],
            'status_badge' => $sticker['is_active'] == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>',
            'is_deleted' => !empty($sticker['deleted_at']),
            'deleted_at' => !empty($sticker['deleted_at']) ? date('F d Y, h:i:s A', strtotime($sticker['deleted_at'])) : null,
            'created_at' => date('F d Y, h:i:s A', strtotime($sticker['created_at'])),
            'updated_at' => $sticker['updated_at'] ? date('F d Y, h:i:s A', strtotime($sticker['updated_at'])) : date('F d Y, h:i:s A', strtotime($sticker['created_at']))
        ];
        
        return $this->response->setJSON([
            'status' => 'success',
            'data' => $stickerData
        ]);
    }
    
    /**
     * Restore soft-deleted sticker
     */
    public function restore($id)
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
        
        $stickersModel = new StickersModel();
        
        // Find soft-deleted sticker
        $sticker = $stickersModel->withDeleted()->find($id);
        
        if ($sticker && !empty($sticker['deleted_at'])) {
            // Use Query Builder directly to update deleted_at to NULL
            $db = db_connect();
            $updated = $db->table('stickers')
                          ->where('sticker_id', $id)
                          ->update(['deleted_at' => null]);
            
            if ($updated) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Sticker restored successfully'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Failed to restore sticker'
                ]);
            }
        }
        
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Sticker not found in trash'
        ]);
    }
    
    /**
     * Permanently delete sticker (hard delete)
     */
    public function forceDelete($id)
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
        
        $stickersModel = new StickersModel();
        
        // Find the sticker (including soft-deleted)
        $sticker = $stickersModel->withDeleted()->find($id);
        
        if ($sticker) {
            $fileDeleted = false;
            
            // Delete image file if it's a local file (not external URL)
            $imageUrl = $sticker['image_url'];
            $isExternal = filter_var($imageUrl, FILTER_VALIDATE_URL) && 
                          (strpos($imageUrl, 'http://') === 0 || strpos($imageUrl, 'https://') === 0);
            
            if (!$isExternal && !empty($imageUrl)) {
                // Build the full file path
                $filePath = FCPATH . $imageUrl;
                $filePath = str_replace('/', DIRECTORY_SEPARATOR, $filePath);
                
                if (file_exists($filePath)) {
                    if (unlink($filePath)) {
                        $fileDeleted = true;
                        log_message('info', 'File deleted: ' . $filePath);
                    } else {
                        log_message('error', 'Failed to delete file: ' . $filePath);
                    }
                } else {
                    log_message('error', 'File not found: ' . $filePath);
                }
            }
            
            // Permanently delete the sticker record
            $deleted = $stickersModel->delete($id, true);
            
            if ($deleted) {
                $message = 'Sticker permanently deleted';
                if ($fileDeleted) {
                    $message .= ' and image file removed';
                } elseif (!$isExternal && !empty($imageUrl)) {
                    $message .= ' but image file could not be deleted';
                }
                
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => $message
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Failed to permanently delete sticker'
                ]);
            }
        }
        
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Sticker not found'
        ]);
    }
    
    /**
     * Soft delete sticker
     */
    public function softDelete($id)
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
        
        $stickersModel = new StickersModel();
        
        // Find the sticker
        $sticker = $stickersModel->find($id);
        
        if ($sticker) {
            // Soft delete the sticker record
            $deleted = $stickersModel->delete($id);
            
            if ($deleted) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Sticker moved to trash'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Failed to delete sticker'
                ]);
            }
        }
        
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Sticker not found'
        ]);
    }
    
    /**
     * Toggle active status
     */
    public function toggleStatus($id)
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
        
        $stickersModel = new StickersModel();
        $sticker = $stickersModel->find($id);
        
        if ($sticker) {
            $newStatus = $sticker['is_active'] == 1 ? 0 : 1;
            $stickersModel->update($id, ['is_active' => $newStatus]);
            
            return $this->response->setJSON([
                'status' => 'success',
                'message' => $newStatus == 1 ? 'Sticker activated' : 'Sticker deactivated',
                'is_active' => $newStatus
            ]);
        }
        
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Sticker not found'
        ]);
    }
}