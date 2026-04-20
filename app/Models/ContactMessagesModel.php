<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactMessagesModel extends Model
{
    protected $table            = 'contact_messages';
    protected $primaryKey       = 'contact_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name', 
        'email', 
        'phone', 
        'subject', 
        'message', 
        'ip_address',
        'is_read'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'name' => 'required|min_length[2]|max_length[100]',
        'email' => 'required|valid_email|max_length[100]',
        'phone' => 'permit_empty|max_length[20]',
        'subject' => 'required|max_length[200]',
        'message' => 'required|min_length[10]',
    ];
    
    protected $validationMessages = [
        'name' => [
            'required' => 'Name is required',
            'min_length' => 'Name must be at least 2 characters',
        ],
        'email' => [
            'required' => 'Email is required',
            'valid_email' => 'Please enter a valid email address',
        ],
        'subject' => [
            'required' => 'Subject is required',
        ],
        'message' => [
            'required' => 'Message is required',
            'min_length' => 'Message must be at least 10 characters',
        ],
    ];
    
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['setDefaultValues'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
    
    /**
     * Set default values before insert
     */
    protected function setDefaultValues(array $data)
    {
        if (!isset($data['data']['is_read'])) {
            $data['data']['is_read'] = 0;
        }
        return $data;
    }
    
    /**
     * Get unread count
     */
    public function getUnreadCount()
    {
        return $this->where('is_read', 0)->countAllResults();
    }
    
    /**
     * Mark as read
     */
    public function markAsRead($id)
    {
        return $this->update($id, ['is_read' => 1]);
    }
    
    /**
     * Mark multiple as read
     */
    public function markMultipleAsRead($ids)
    {
        return $this->set('is_read', 1)
                    ->whereIn('contact_id', $ids)
                    ->update();
    }
}