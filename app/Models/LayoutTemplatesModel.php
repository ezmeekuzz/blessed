<?php

namespace App\Models;

use CodeIgniter\Model;

class LayoutTemplatesModel extends Model
{
    protected $table            = 'layout_templates';
    protected $primaryKey       = 'layout_template_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name', 'grid_template_id', 'images_data'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[200]',
        'grid_template_id' => 'required|is_natural_no_zero',
        'images_data' => 'required|valid_json'
    ];
    
    protected $validationMessages = [
        'name' => [
            'required' => 'Layout name is required.',
            'min_length' => 'Layout name must be at least 3 characters.'
        ],
        'grid_template_id' => [
            'required' => 'Please select a grid template.',
            'is_natural_no_zero' => 'Invalid grid template selected.'
        ],
        'images_data' => [
            'required' => 'Images data is required.',
            'valid_json' => 'Invalid images data format.'
        ]
    ];

    protected $skipValidation = false;

    /**
     * Get layout with grid template details
     */
    public function getLayoutWithGrid($layoutId)
    {
        return $this->select('layout_templates.*, grid_templates.name as grid_name, grid_templates.layout_json as grid_layout')
                    ->join('grid_templates', 'grid_templates.grid_template_id = layout_templates.grid_template_id')
                    ->find($layoutId);
    }
    
    /**
     * Get all layouts with their grid templates
     */
    public function getAllLayoutsWithGrids()
    {
        return $this->select('layout_templates.*, grid_templates.name as grid_name')
                    ->join('grid_templates', 'grid_templates.grid_template_id = layout_templates.grid_template_id')
                    ->orderBy('layout_templates.created_at', 'DESC')
                    ->findAll();
    }
}