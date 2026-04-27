<?=$this->include('templates/admin/header');?>

<style>
    /* Layout Template Styling */
    .grid-container {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 20px;
        min-height: 500px;
        border: 2px solid #dee2e6;
        transition: all 0.3s ease;
    }
    
    .grid-cell {
        position: relative;
        overflow: hidden !important;
        background: #f8f9fa;
        border-radius: 8px;
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
    }
    
    .grid-cell.active-editor {
        z-index: 1000;
        box-shadow: 0 0 0 3px #3D204E, 0 5px 20px rgba(0,0,0,0.2);
    }
    
    .grid-cell.drag-over {
        transform: scale(1.02);
        box-shadow: 0 0 0 3px rgba(102,126,234,0.5);
        background: rgba(102,126,234,0.1);
    }
    
    .grid-cell.ready-for-image {
        cursor: crosshair;
        box-shadow: 0 0 0 3px #28a745;
        animation: pulse 1s infinite;
    }
    
    .image-editor-container {
        position: relative;
        width: 100%;
        height: 100%;
        border-radius: 8px;
        background: #f8f9fa;
        overflow: hidden;
    }
    
    /* Fabric.js Canvas Container */
    .image-editor-container .canvas-container {
        border-radius: 8px !important;
        width: 100% !important;
        height: 100% !important;
    }
    
    .image-editor-container canvas {
        border-radius: 8px !important;
    }
    
    .empty-cell-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(248,249,250,0.95);
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 10;
        border-radius: 8px;
    }
    
    .empty-cell-overlay:hover {
        background: rgba(61,32,78,0.1);
    }
    
    .empty-cell-overlay i {
        font-size: 32px;
        color: #c9b6d4;
        margin-bottom: 10px;
    }
    
    /* Fabric Controls Overlay */
    .fabric-controls {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 100;
        display: flex;
        gap: 8px;
        background: rgba(255,255,255,0.95);
        padding: 6px 10px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        backdrop-filter: blur(4px);
    }
    
    .fabric-controls button {
        padding: 6px 12px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 12px;
        transition: all 0.2s ease;
        background: #f8f9fa;
        color: #333;
    }
    
    .fabric-controls button:hover {
        background: #3D204E;
        color: white;
        transform: scale(1.05);
    }
    
    .fabric-controls .fabric-delete:hover {
        background: #dc3545;
    }
    
    /* Image Library */
    .image-library {
        max-height: 600px;
        overflow-y: auto;
    }
    
    .image-item {
        cursor: pointer;
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.3s ease;
        border: 2px solid transparent;
        margin-bottom: 15px;
        background: white;
    }
    
    .image-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        cursor: pointer;
    }
    
    .image-item.dragging {
        opacity: 0.5;
        cursor: grabbing;
    }
    
    .image-item .image-preview {
        position: relative;
        overflow: hidden;
        border-radius: 8px 8px 0 0;
    }
    
    .image-item .image-preview img {
        width: 100%;
        height: 100px;
        object-fit: cover;
    }
    
    .image-item .image-info {
        padding: 8px;
        background: white;
        font-size: 12px;
        text-align: center;
    }
    
    /* Upload Area */
    .upload-area {
        border: 2px dashed #dee2e6;
        border-radius: 12px;
        padding: 30px;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
        background: white;
    }
    
    .upload-area:hover {
        border-color: #3D204E;
        background: linear-gradient(135deg, #f8f0ff 0%, #f0e8ff 100%);
        transform: translateY(-2px);
    }
    
    .upload-area:active {
        transform: translateY(0);
    }
    
    .upload-area.drag-over {
        border-color: #3D204E;
        background: #f0e8ff;
        transform: scale(1.02);
    }
    
    /* Template Selection */
    .template-card {
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid transparent;
        position: relative;
    }
    
    .template-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    }
    
    .template-card.selected {
        border-color: #3D204E;
        background: linear-gradient(135deg, #f8f0ff 0%, #f0e8ff 100%);
    }
    
    .template-card.selected::after {
        content: '✓';
        position: absolute;
        top: 10px;
        right: 10px;
        background: #3D204E;
        color: white;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }
    
    .template-preview {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
        padding: 15px;
        color: white;
        margin-bottom: 10px;
    }
    
    .template-preview .row {
        margin: 0 -2px;
    }
    
    .template-preview .col {
        background: rgba(255,255,255,0.2);
        border-radius: 6px;
        padding: 8px 2px;
        margin: 0 2px;
        font-size: 11px;
        font-weight: 600;
        text-align: center;
    }
    
    /* Editor Mode Indicator */
    .editor-mode-indicator {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: #3D204E;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 14px;
        z-index: 9999;
        animation: slideIn 0.3s ease;
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }
    
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(40, 167, 69, 0); }
        100% { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0); }
    }
    
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    /* Loading State */
    .loading-shimmer {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 1000px 100%;
        animation: shimmer 2s infinite;
    }
    
    @keyframes shimmer {
        0% { background-position: -1000px 0; }
        100% { background-position: 1000px 0; }
    }
    
    /* Fabric.js Control Handles Customization */
    .canvas-container .canvas-controls .controls {
        background: #3D204E;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .grid-cell {
            min-height: 120px;
        }
        .fabric-controls button {
            padding: 4px 8px;
            font-size: 10px;
        }
    }
    
    /* Scrollbar Styling */
    .image-library::-webkit-scrollbar {
        width: 6px;
    }
    
    .image-library::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .image-library::-webkit-scrollbar-thumb {
        background: #c9b6d4;
        border-radius: 10px;
    }
    
    .image-library::-webkit-scrollbar-thumb:hover {
        background: #3D204E;
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
                            <h4><i class="fas fa-images"></i> <?= isset($isEdit) && $isEdit ? 'Edit' : 'Create' ?> Layout Template</h4>
                        </div>
                        <div class="ml-auto d-flex align-items-center">
                            <nav>
                                <ol class="breadcrumb p-0 m-b-0">
                                    <li class="breadcrumb-item">
                                        <a href="/admin/dashboard"><i class="ti ti-home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        Layout Templates
                                    </li>
                                    <li class="breadcrumb-item active">
                                        <?= isset($isEdit) && $isEdit ? 'Edit' : 'Create' ?> Layout
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <form id="createLayoutForm">
                
                <!-- Step 1: Select Grid Template -->
                <div class="row" id="step1" <?= (isset($isEdit) && $isEdit) ? 'style="display: none;"' : '' ?>>
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-th"></i> Step 1: Select Grid Template
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <?php if (!empty($gridTemplates)): ?>
                                        <?php foreach ($gridTemplates as $template): ?>
                                            <div class="col-md-4 col-lg-3 mb-3">
                                                <div class="template-card card h-100" 
                                                     data-grid-id="<?= $template['grid_template_id'] ?>" 
                                                     data-grid-json='<?= $template['layout_json'] ?>'>
                                                    <div class="card-body">
                                                        <div class="template-preview">
                                                            <?php
                                                            $layout = json_decode($template['layout_json'], true);
                                                            if ($layout && isset($layout['rows']) && !empty($layout['rows'])):
                                                                $firstRow = $layout['rows'][0];
                                                                $columns = $firstRow['columns'];
                                                                $colClass = $columns == 1 ? 'col-12' : ($columns == 2 ? 'col-6' : ($columns == 3 ? 'col-4' : ($columns == 4 ? 'col-3' : 'col-2')));
                                                                ?>
                                                                <div class="row">
                                                                    <?php for($i = 1; $i <= $columns; $i++): ?>
                                                                        <div class="<?= $colClass ?>"><?= $i ?></div>
                                                                    <?php endfor; ?>
                                                                </div>
                                                                <?php if (count($layout['rows']) > 1): ?>
                                                                    <div class="row mt-1">
                                                                        <div class="col-12">⋮</div>
                                                                    </div>
                                                                <?php endif; ?>
                                                            <?php else: ?>
                                                                <div class="row">
                                                                    <div class="col-12">Grid</div>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                        <h6 class="card-title text-center mt-2"><?= esc($template['name']) ?></h6>
                                                        <small class="text-muted text-center d-block">
                                                            <?= isset($layout['rows']) ? count($layout['rows']) : 0 ?> row(s)
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="col-12">
                                            <div class="alert alert-warning">
                                                <i class="fas fa-exclamation-triangle"></i> No grid templates found. 
                                                <a href="/admin/addgridtemplate">Create a grid template first</a>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="layoutName">Layout Name <span class="text-danger">*</span></label>
                                            <input type="text" id="layoutName" class="form-control" 
                                                   placeholder="e.g., Homepage Hero Layout, Product Gallery"
                                                   value="<?= (isset($isEdit) && isset($layout['name'])) ? esc($layout['name']) : '' ?>">
                                        </div>
                                        <input type="hidden" id="selectedGridId" 
                                               value="<?= (isset($isEdit) && isset($layout['grid_template_id'])) ? $layout['grid_template_id'] : '' ?>">
                                    </div>
                                </div>
                                
                                <div class="text-right">
                                    <button type="button" id="nextToStep2" class="btn btn-primary" <?= (isset($isEdit) && $isEdit) ? 'style="display: none;"' : 'disabled' ?>>
                                        Next: Add Images <i class="fas fa-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Step 2: Drag & Drop Images -->
                <div class="row" id="step2" <?= !(isset($isEdit) && $isEdit) ? 'style="display: none;"' : '' ?>>
                    <div class="col-lg-8">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-th"></i> Grid Layout - Drag & Drop Images
                                </h5>
                                <div>
                                    <button type="button" id="clearAllImages" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i> Clear All Images
                                    </button>
                                    <?php if(isset($isEdit) && $isEdit): ?>
                                        <button type="button" id="backToStep1" class="btn btn-sm btn-outline-secondary ml-2">
                                            <i class="fas fa-arrow-left"></i> Change Template
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="grid-container" id="gridContainer">
                                    <div class="text-center p-5">
                                        <i class="fas fa-spinner fa-spin"></i> Loading grid...
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <!-- Image Library -->
                        <div class="card shadow-sm mb-3">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-images"></i> Image Library
                                </h5>
                            </div>
                            <div class="card-body image-library" id="imageLibrary">
                                <div class="upload-area" id="uploadArea">
                                    <i class="fas fa-cloud-upload-alt fa-2x mb-2"></i>
                                    <p><strong>Click or drag images here</strong></p>
                                    <small class="text-muted">JPG, PNG, GIF up to 5MB</small>
                                    <input type="file" id="imageUpload" multiple accept="image/*" style="display: none;">
                                </div>
                                <div id="uploadedImages"></div>
                            </div>
                        </div>
                        
                        <!-- Layout Info -->
                        <div class="card shadow-sm">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-info-circle"></i> Layout Information
                                </h5>
                            </div>
                            <div class="card-body">
                                <div id="layoutInfo">
                                    <p><strong>Template:</strong> <span id="selectedTemplateName">-</span></p>
                                    <p><strong>Images Placed:</strong> <span id="imagesPlaced">0</span></p>
                                    <p><strong>Total Cells:</strong> <span id="totalCells">0</span></p>
                                </div>
                                <hr>
                                <button type="submit" class="btn btn-success btn-block" id="saveLayoutBtn">
                                    <i class="fas fa-save"></i> <?= isset($isEdit) && $isEdit ? 'Update' : 'Save' ?> Layout Template
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?=$this->include('templates/admin/footer');?>

<!-- Fabric.js Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.0/fabric.min.js"></script>

<script src="<?= base_url(); ?>assets/js/admin/add-layout-template.js"></script>

<script>
    // Pass PHP variables to JavaScript
    window.isEditMode = <?= $isEdit ? 'true' : 'false' ?>;
    <?php if($isEdit && isset($layout)): ?>
    window.existingLayout = {
        id: <?= $layout['layout_template_id'] ?>,
        name: '<?= esc($layout['name']) ?>',
        grid_template_id: <?= $layout['grid_template_id'] ?>,
        grid_layout: <?= $layout['grid_layout'] ?>,
        images_data: <?= $layout['images_data'] ?>
    };
    <?php endif; ?>
</script>