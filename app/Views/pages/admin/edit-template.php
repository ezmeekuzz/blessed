<?=$this->include('templates/admin/header');?>

<style>
    /* Grid Template Styling */
    .grid-preview {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 20px;
        min-height: 500px;
        border: 2px solid #dee2e6;
        transition: all 0.3s ease;
    }
    
    /* Drop Zones - Visible Areas */
    .drop-zone {
        background: rgba(61, 32, 78, 0.08);
        border: 2px dashed #3D204E;
        border-radius: 12px;
        margin: 10px 0;
        padding: 20px;
        text-align: center;
        transition: all 0.3s ease;
        position: relative;
    }
    
    .drop-zone.active {
        background: rgba(61, 32, 78, 0.2);
        border-color: #5a2e72;
        transform: scale(1.02);
    }
    
    .drop-zone .drop-label {
        color: #3D204E;
        font-size: 14px;
        font-weight: 600;
        background: white;
        display: inline-block;
        padding: 6px 16px;
        border-radius: 25px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .drop-zone.active .drop-label {
        background: #3D204E;
        color: white;
    }
    
    /* Row Drop Zone */
    .row-drop-zone {
        background: rgba(102, 126, 234, 0.1);
        border: 2px dashed #667eea;
        border-radius: 12px;
        margin: 5px 0;
        padding: 15px;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .row-drop-zone.active {
        background: rgba(102, 126, 234, 0.25);
        border-color: #764ba2;
        transform: scale(1.01);
    }
    
    .row-drop-zone .drop-label {
        color: #667eea;
        font-size: 13px;
        font-weight: 500;
    }
    
    /* Layout Rows */
    .layout-row {
        background: white;
        border-radius: 12px;
        margin-bottom: 15px;
        padding: 15px;
        border: 1px solid #e9ecef;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        position: relative;
        transition: all 0.3s ease;
    }
    
    .layout-row.dragging {
        opacity: 0.4;
        background: #e9ecef;
        transform: scale(0.98);
    }
    
    .layout-row.drag-over {
        background: #e8f0fe;
        border: 2px solid #3D204E;
        transform: scale(1.01);
    }
    
    /* Layout Cells */
    .layout-cell {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 8px;
        padding: 15px;
        text-align: center;
        transition: all 0.3s ease;
        position: relative;
        min-height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        cursor: grab;
    }
    
    .layout-cell:active {
        cursor: grabbing;
    }
    
    .layout-cell.dragging {
        opacity: 0.5;
        transform: scale(0.95);
    }
    
    .layout-cell.drag-over {
        transform: scale(1.02);
        box-shadow: 0 0 0 3px rgba(102,126,234,0.5);
        background: linear-gradient(135deg, #764ba2 0%, #3D204E 100%);
    }
    
    .remove-cell {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #dc3545;
        color: white;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 12px;
        transition: all 0.3s ease;
        z-index: 10;
    }
    
    .remove-cell:hover {
        transform: scale(1.1);
    }
    
    .row-controls {
        position: absolute;
        top: -12px;
        right: 10px;
        background: white;
        border-radius: 20px;
        padding: 4px 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        z-index: 10;
        display: flex;
        gap: 5px;
    }
    
    .row-controls button {
        padding: 2px 8px;
        font-size: 11px;
    }
    
    .drag-handle {
        cursor: grab;
        padding: 5px 8px;
        background: #f8f9fa;
        border-radius: 4px;
        margin-left: 5px;
        display: inline-block;
    }
    
    .drag-handle:active {
        cursor: grabbing;
    }
    
    .drag-handle:hover {
        background: #e9ecef;
    }
    
    .json-error {
        border-color: #dc3545 !important;
        background: #fff8f8 !important;
    }
    
    .drag-instruction {
        background: #e8f0fe;
        border-left: 4px solid #667eea;
        padding: 12px 15px;
        margin-bottom: 15px;
        border-radius: 8px;
    }
    
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }
    
    .loading-spinner {
        background: white;
        padding: 20px;
        border-radius: 16px;
        text-align: center;
    }
</style>

<div class="app-container">
    <?=$this->include('templates/admin/sidebar');?>
    <div class="app-main" id="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 m-b-30">
                    <div class="d-block d-sm-flex flex-nowrap align-items-center">
                        <div class="page-title mb-2 mb-sm-0">
                            <h4><i class="fas fa-edit"></i> Edit Grid Template</h4>
                        </div>
                        <div class="ml-auto d-flex align-items-center">
                            <nav>
                                <ol class="breadcrumb p-0 m-b-0">
                                    <li class="breadcrumb-item">
                                        <a href="/"><i class="ti ti-home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        Grid Templates
                                    </li>
                                    <li class="breadcrumb-item active">
                                        Edit Template
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Template Form -->
            <form id="editTemplateForm">
                <?= csrf_field() ?>
                <input type="hidden" name="grid_template_id" id="templateId" value="<?= $template['grid_template_id'] ?>">
                
                <div class="row">
                    <!-- Left Column - Template Builder -->
                    <div class="col-lg-7">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-paint-brush"></i> Grid Builder
                                </h5>
                                <div>
                                    <button type="button" id="clearAllBtn" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i> Clear All
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Drag Instruction -->
                                <div class="drag-instruction">
                                    <i class="fas fa-arrows-alt"></i>
                                    <strong>Drag & Drop Areas:</strong>
                                    <small class="d-block mt-1">
                                        • <i class="fas fa-grip-vertical"></i> <strong>Drag rows</strong> using the handle (⋮⋮) - drop zones appear between rows<br>
                                        • <i class="fas fa-columns"></i> <strong>Drag columns</strong> directly - drop zones highlight on other columns
                                    </small>
                                </div>
                                
                                <!-- Grid Preview Area -->
                                <div class="grid-preview" id="gridPreview">
                                    <div class="text-center py-5">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                        <p class="mt-2">Loading template...</p>
                                    </div>
                                </div>
                                
                                <hr>
                                
                                <!-- Row Controls -->
                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Number of Columns</label>
                                            <input type="number" id="numColumns" class="form-control" min="1" max="6" value="3">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Row Height (px)</label>
                                            <input type="number" id="rowHeight" class="form-control" min="80" max="300" value="120">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button type="button" class="btn btn-primary btn-block" id="addRowBtn">
                                                <i class="fas fa-plus"></i> Add Row
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Column - Template Details -->
                    <div class="col-lg-5">
                        <!-- Template Info Card -->
                        <div class="card shadow-sm mb-3">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0"><i class="fas fa-info-circle"></i> Template Info</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="templateName">Template Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="templateName" class="form-control" value="<?= esc($template['name']) ?>" placeholder="e.g., 3-Column Grid, Product Gallery" required>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Settings Card -->
                        <div class="card shadow-sm mb-3">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0"><i class="fas fa-cog"></i> Settings</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="isFeatured" name="is_featured" value="1" <?= ($template['is_featured'] ?? 0) == 1 ? 'checked' : '' ?>>
                                        <label class="custom-control-label" for="isFeatured">Feature this template</label>
                                    </div>
                                    <small class="form-text text-muted">Featured templates appear on the homepage.</small>
                                </div>
                            </div>
                        </div>
                        
                        <!-- JSON Editor Card -->
                        <div class="card shadow-sm mb-3">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0"><i class="fas fa-code"></i> JSON Layout</h5>
                                <div>
                                    <button type="button" id="formatJsonBtn" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-code-branch"></i> Format
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <textarea name="layout_json" id="layoutJson" rows="8" class="form-control font-monospace" style="font-family: monospace; font-size: 12px;" placeholder='{"rows": [{"columns": 3, "height": 120}]}'></textarea>
                                <small class="text-muted mt-2 d-block">Edit JSON directly or use the visual builder</small>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <button type="button" class="btn btn-outline-secondary btn-block mb-2" id="resetFormBtn">
                                    <i class="fas fa-undo-alt"></i> Reset Changes
                                </button>
                                <button type="submit" class="btn btn-primary btn-block" id="submitBtn">
                                    <i class="fas fa-save"></i> Update Template
                                </button>
                                <a href="/admin/templates-masterlist" class="btn btn-secondary btn-block mt-2">
                                    <i class="fas fa-arrow-left"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner">
        <i class="fas fa-spinner fa-spin fa-2x"></i>
        <p class="mt-2 mb-0">Saving template...</p>
    </div>
</div>

<?=$this->include('templates/admin/footer');?>

<script src="<?= base_url(); ?>assets/js/admin/edit-template.js"></script>