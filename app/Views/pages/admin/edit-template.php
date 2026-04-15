<?=$this->include('templates/admin/header');?>

<style>
    /* Grid Template Styling */
    .grid-preview {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 20px;
        min-height: 400px;
        border: 2px dashed #dee2e6;
        transition: all 0.3s ease;
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
    }
    
    .layout-row.dragging {
        opacity: 0.5;
        background: #e9ecef;
    }
    
    .layout-row.drag-over {
        background: #e8f0fe;
        border: 2px solid #3D204E;
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
    }
    
    .layout-cell.dragging {
        opacity: 0.5;
    }
    
    .layout-cell.drag-over {
        transform: scale(1.02);
        box-shadow: 0 0 0 3px rgba(102,126,234,0.4);
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
        cursor: move;
        padding: 5px 8px;
        background: #f8f9fa;
        border-radius: 4px;
        margin-left: 5px;
    }
    
    .drag-handle:hover {
        background: #e9ecef;
    }
    
    /* Preset Cards */
    .preset-card {
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid transparent;
        background: white;
        border-radius: 12px;
        padding: 12px;
    }
    
    .preset-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    }
    
    .preset-card.selected {
        border-color: #3D204E;
        background: linear-gradient(135deg, #f8f0ff 0%, #f0e8ff 100%);
    }
    
    .preset-preview {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
        padding: 15px;
        color: white;
        margin-bottom: 8px;
    }
    
    .preset-preview .row {
        margin: 0 -2px;
    }
    
    .preset-preview .col {
        background: rgba(255,255,255,0.2);
        border-radius: 6px;
        padding: 8px 2px;
        margin: 0 2px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .preset-card small {
        font-size: 12px;
        font-weight: 500;
        color: #666;
    }
    
    .preset-card.selected small {
        color: #3D204E;
        font-weight: 600;
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }
    
    .empty-state i {
        font-size: 64px;
        color: #c9b6d4;
        margin-bottom: 20px;
    }
    
    /* JSON Editor */
    .json-error {
        border-color: #dc3545 !important;
        background: #fff8f8 !important;
    }
    
    /* Loading Spinner */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Info Alert */
    .info-alert {
        background: #e3f2fd;
        border-left: 4px solid #2196f3;
        padding: 12px 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    
    .info-alert i {
        color: #2196f3;
        margin-right: 10px;
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
                                        <a href="/admin/templates-masterlist">Grid Templates</a>
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
                <input type="hidden" name="template_id" id="templateId" value="<?= $template['grid_template_id'] ?? '' ?>">
                
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
                                <!-- Grid Preview Area -->
                                <div class="grid-preview" id="gridPreview">
                                    <div class="empty-state">
                                        <i class="fas fa-th-large"></i>
                                        <h5>Loading template...</h5>
                                        <p class="text-muted">Please wait while we load your template</p>
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
                                    <input type="text" name="name" id="templateName" class="form-control" placeholder="e.g., 3-Column Grid, Product Gallery" value="<?= htmlspecialchars($template['name'] ?? '') ?>" required>
                                </div>
                                
                                <div class="info-alert">
                                    <i class="fas fa-info-circle"></i>
                                    <small>Edit your template layout using the visual builder on the left, or modify the JSON directly.</small>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Presets Card -->
                        <div class="card shadow-sm mb-3">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0"><i class="fas fa-star"></i> Quick Presets</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <div class="preset-card text-center" data-preset="3-col">
                                            <div class="preset-preview">
                                                <div class="row">
                                                    <div class="col-4">1</div>
                                                    <div class="col-4">2</div>
                                                    <div class="col-4">3</div>
                                                </div>
                                            </div>
                                            <small>3 Columns</small>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="preset-card text-center" data-preset="2-col">
                                            <div class="preset-preview">
                                                <div class="row">
                                                    <div class="col-6">1</div>
                                                    <div class="col-6">2</div>
                                                </div>
                                            </div>
                                            <small>2 Columns</small>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="preset-card text-center" data-preset="4-col">
                                            <div class="preset-preview">
                                                <div class="row">
                                                    <div class="col-3">1</div>
                                                    <div class="col-3">2</div>
                                                    <div class="col-3">3</div>
                                                    <div class="col-3">4</div>
                                                </div>
                                            </div>
                                            <small>4 Columns</small>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="preset-card text-center" data-preset="hero">
                                            <div class="preset-preview">
                                                <div class="row mb-1">
                                                    <div class="col-12">Hero</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">1</div>
                                                    <div class="col-6">2</div>
                                                </div>
                                            </div>
                                            <small>Hero + 2 Columns</small>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="preset-card text-center" data-preset="sidebar">
                                            <div class="preset-preview">
                                                <div class="row">
                                                    <div class="col-8">Main</div>
                                                    <div class="col-4">Side</div>
                                                </div>
                                            </div>
                                            <small>Main + Sidebar</small>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="preset-card text-center" data-preset="gallery">
                                            <div class="preset-preview">
                                                <div class="row">
                                                    <div class="col-6">Big</div>
                                                    <div class="col-3">1</div>
                                                    <div class="col-3">2</div>
                                                </div>
                                            </div>
                                            <small>Gallery Layout</small>
                                        </div>
                                    </div>
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
                                <textarea name="layout_json" id="layoutJson" rows="8" class="form-control font-monospace" style="font-family: monospace; font-size: 12px;" placeholder='{"rows": [{"columns": 3, "height": 120}]}'><?= htmlspecialchars($template['layout_json'] ?? '') ?></textarea>
                                <small class="text-muted mt-2 d-block">Edit JSON directly or use the visual builder</small>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="card shadow-sm">
                            <div class="card-body">
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

<?=$this->include('templates/admin/footer');?>

<script src="<?= base_url(); ?>assets/js/admin/edit-template.js"></script>