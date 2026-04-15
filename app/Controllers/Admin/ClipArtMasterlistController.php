<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ClipArtsModel;
use Hermawan\DataTables\DataTable;

class ClipArtMasterlistController extends SessionController
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
            'title' => 'The Blessed Manifest | Clip Art Masterlist',
            'activeMenu' => 'clipartmasterlist'
        ];
        return view('pages/admin/clipart-masterlist', $data);
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
        
        // IMPORTANT: Only get records where deleted_at IS NULL (not soft deleted)
        $builder = $db->table('clip_arts')
                    ->select('
                        clip_art_id, 
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
                    ->orderBy('clip_art_id', 'DESC');

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
                'clip_art_id' => $row[0],
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
        
        // IMPORTANT: Only get records where deleted_at IS NULL (not soft deleted)
        $builder = $db->table('clip_arts')
                    ->select('
                        clip_art_id, 
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
                    ->orderBy('clip_art_id', 'DESC');

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
            $isExternal = filter_var($imageUrl, FILTER_VALIDATE_URL) && strpos($imageUrl, 'http') === 0;
            
            $data[] = [
                'clip_art_id' => $row[0],
                'title' => $row[1],
                'image_url' => $row[2],
                'image_url_display' => $isExternal ? $imageUrl : base_url($imageUrl),
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
        $count = $db->table('clip_arts')
                    ->where('deleted_at IS NOT NULL', null, false)
                    ->countAllResults();
        
        return $this->response->setJSON([
            'status' => 'success',
            'count' => $count
        ]);
    }
    
    /**
     * Get single clip art for viewing (including soft-deleted)
     */
    public function getClipArt($id)
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
        
        $clipArtModel = new ClipArtsModel();
        // Use withDeleted to include soft-deleted records
        $clipArt = $clipArtModel->withDeleted()->find($id);
        
        if (!$clipArt) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Clip art not found'
            ]);
        }
        
        // Process tags
        $tagsArray = [];
        $tagsHtml = '';
        if (!empty($clipArt['tags'])) {
            $tagsArray = explode(',', $clipArt['tags']);
            $tagsArray = array_map('trim', $tagsArray);
            foreach ($tagsArray as $tag) {
                $tagsHtml .= '<span class="badge badge-info mr-1">' . htmlspecialchars($tag) . '</span>';
            }
        }
        
        // Determine if image is external or local
        $isExternal = filter_var($clipArt['image_url'], FILTER_VALIDATE_URL) && strpos($clipArt['image_url'], 'http') === 0;
        $displayImageUrl = $isExternal ? $clipArt['image_url'] : base_url($clipArt['image_url']);
        
        // Prepare data for view
        $clipArtData = [
            'clip_art_id' => $clipArt['clip_art_id'],
            'title' => htmlspecialchars($clipArt['title']),
            'image_url' => $clipArt['image_url'],
            'display_image_url' => $displayImageUrl,
            'is_external' => $isExternal,
            'description' => nl2br(htmlspecialchars($clipArt['description'])),
            'tags' => $clipArt['tags'],
            'tags_array' => $tagsArray,
            'tags_html' => $tagsHtml,
            'is_active' => $clipArt['is_active'],
            'status_badge' => $clipArt['is_active'] == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>',
            'is_deleted' => !empty($clipArt['deleted_at']),
            'deleted_at' => !empty($clipArt['deleted_at']) ? date('F d Y, h:i:s A', strtotime($clipArt['deleted_at'])) : null,
            'created_at' => date('F d Y, h:i:s A', strtotime($clipArt['created_at'])),
            'updated_at' => $clipArt['updated_at'] ? date('F d Y, h:i:s A', strtotime($clipArt['updated_at'])) : date('F d Y, h:i:s A', strtotime($clipArt['created_at']))
        ];
        
        return $this->response->setJSON([
            'status' => 'success',
            'data' => $clipArtData
        ]);
    }
    
    /**
     * Restore soft-deleted clip art
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
        
        $clipArtModel = new ClipArtsModel();
        
        // Find soft-deleted clip art
        $clipArt = $clipArtModel->withDeleted()->find($id);
        
        if ($clipArt && !empty($clipArt['deleted_at'])) {
            // Use Query Builder directly to update deleted_at to NULL
            $db = db_connect();
            $updated = $db->table('clip_arts')
                          ->where('clip_art_id', $id)
                          ->update(['deleted_at' => null]);
            
            if ($updated) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Clip art restored successfully'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Failed to restore clip art'
                ]);
            }
        }
        
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Clip art not found in trash'
        ]);
    }

    /**
     * Permanently delete clip art (hard delete)
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
        
        $clipArtModel = new ClipArtsModel();
        
        // Find the clip art (including soft-deleted)
        $clipArt = $clipArtModel->withDeleted()->find($id);
        
        if ($clipArt) {
            $fileDeleted = false;
            
            // Delete image file if it's a local file (not external URL)
            $imageUrl = $clipArt['image_url'];
            
            // Check if it's an external URL
            $isExternal = filter_var($imageUrl, FILTER_VALIDATE_URL) && 
                        (strpos($imageUrl, 'http://') === 0 || strpos($imageUrl, 'https://') === 0);
            
            if (!$isExternal && !empty($imageUrl)) {
                // Build the full file path
                // image_url should be like: "uploads/cliparts/sdfsdf_1776271038_3953f68e.jpg"
                $filePath = FCPATH . $imageUrl;
                
                // Normalize path separators for Windows
                $filePath = str_replace('/', DIRECTORY_SEPARATOR, $filePath);
                
                // Log for debugging
                log_message('debug', 'Attempting to delete file: ' . $filePath);
                
                // Check if file exists and delete it
                if (file_exists($filePath)) {
                    if (unlink($filePath)) {
                        $fileDeleted = true;
                        log_message('info', 'File deleted successfully: ' . $filePath);
                    } else {
                        log_message('error', 'Failed to delete file (permission issue): ' . $filePath);
                    }
                } else {
                    log_message('error', 'File not found: ' . $filePath);
                }
            }
            
            // Permanently delete the clip art record
            $deleted = $clipArtModel->delete($id, true);
            
            if ($deleted) {
                $message = 'Clip art permanently deleted';
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
                    'message' => 'Failed to permanently delete clip art'
                ]);
            }
        }
        
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Clip art not found'
        ]);
    }
    
    /**
     * Soft delete clip art
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
        
        $clipArtModel = new ClipArtsModel();
        
        // Find the clip art
        $clipArt = $clipArtModel->find($id);
        
        if ($clipArt) {
            // Soft delete the clip art record
            $deleted = $clipArtModel->delete($id);
            
            if ($deleted) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Clip art moved to trash'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Failed to delete clip art'
                ]);
            }
        }
        
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Clip art not found'
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
        
        $clipArtModel = new ClipArtsModel();
        $clipArt = $clipArtModel->find($id);
        
        if ($clipArt) {
            $newStatus = $clipArt['is_active'] == 1 ? 0 : 1;
            $clipArtModel->update($id, ['is_active' => $newStatus]);
            
            return $this->response->setJSON([
                'status' => 'success',
                'message' => $newStatus == 1 ? 'Clip art activated' : 'Clip art deactivated',
                'is_active' => $newStatus
            ]);
        }
        
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Clip art not found'
        ]);
    }
}