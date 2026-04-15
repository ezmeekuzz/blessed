<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\FontsModel;
use Hermawan\DataTables\DataTable;

class FontMasterlistController extends SessionController
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
            'title' => 'The Blessed Manifest | Font Masterlist',
            'activeMenu' => 'fonts'
        ];
        return view('pages/admin/font-masterlist', $data);
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
        $builder = $db->table('fonts')
                    ->select('
                        font_id, 
                        font_name, 
                        source_type, 
                        file_path, 
                        font_link, 
                        status, 
                        is_featured, 
                        created_at,
                        updated_at
                    ')
                    ->orderBy('font_id', 'DESC');

        // Get DataTable response
        $response = DataTable::of($builder)->toJson();
        $json = $response->getBody();
        $result = json_decode($json, true);

        // Transform data
        $data = [];
        foreach ($result['data'] as $row) {
            $data[] = [
                'font_id' => $row[0],
                'font_name' => $row[1],
                'source_type' => $row[2],
                'file_path' => $row[3],
                'font_link' => $row[4],
                'status' => $row[5],
                'is_featured' => $row[6],
                'created_at' => $row[7] ? date('Y-m-d H:i:s', strtotime($row[7])) : 'N/A',
                'updated_at' => $row[8] ? date('Y-m-d H:i:s', strtotime($row[8])) : 'N/A'
            ];
        }

        $result['data'] = $data;
        return $this->response->setJSON($result);
    }
    
    /**
     * Get single font for viewing
     */
    public function getFont($id)
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
        
        $fontsModel = new FontsModel();
        $font = $fontsModel->find($id);
        
        if (!$font) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Font not found'
            ]);
        }
        
        // Prepare data for view
        $fontData = [
            'font_id' => $font['font_id'],
            'font_name' => htmlspecialchars($font['font_name']),
            'source_type' => $font['source_type'],
            'file_path' => $font['file_path'],
            'font_link' => $font['font_link'],
            'status' => $font['status'],
            'is_featured' => $font['is_featured'],
            'created_at' => date('F d Y, h:i:s A', strtotime($font['created_at'])),
            'updated_at' => $font['updated_at'] ? date('F d Y, h:i:s A', strtotime($font['updated_at'])) : date('F d Y, h:i:s A', strtotime($font['created_at']))
        ];
        
        return $this->response->setJSON([
            'status' => 'success',
            'data' => $fontData
        ]);
    }
    
    /**
     * Download font file
     */
    public function download($filePath)
    {
        // Check if user is logged in
        if (!$this->session->get('AdminLoggedIn')) {
            return redirect()->to('/admin/login');
        }
        
        $fullPath = FCPATH . $filePath;
        
        if (file_exists($fullPath)) {
            return $this->response->download($fullPath, null);
        }
        
        return redirect()->back()->with('error', 'File not found.');
    }
    
    /**
     * Delete font
     */
    public function delete($id)
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
        
        $fontsModel = new FontsModel();
        
        // Find the font by ID
        $font = $fontsModel->find($id);
        
        if ($font) {
            // Delete font file if it exists (for local fonts)
            if ($font['source_type'] === 'local' && !empty($font['file_path'])) {
                $filePath = FCPATH . $font['file_path'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            
            // Delete the font record
            $deleted = $fontsModel->delete($id);
            
            if ($deleted) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Font deleted successfully'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Failed to delete font'
                ]);
            }
        }
        
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Font not found'
        ]);
    }
    
    /**
     * Toggle featured status
     */
    public function toggleFeatured($id)
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
        
        $fontsModel = new FontsModel();
        $font = $fontsModel->find($id);
        
        if ($font) {
            $newStatus = $font['is_featured'] == 1 ? 0 : 1;
            $fontsModel->update($id, ['is_featured' => $newStatus]);
            
            return $this->response->setJSON([
                'status' => 'success',
                'message' => $newStatus == 1 ? 'Font marked as featured' : 'Font removed from featured',
                'is_featured' => $newStatus
            ]);
        }
        
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Font not found'
        ]);
    }
}