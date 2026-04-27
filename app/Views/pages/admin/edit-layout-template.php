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
    
    .canvas-container .canvas-controls .controls {
        background: #3D204E;
    }
    
    @media (max-width: 768px) {
        .grid-cell {
            min-height: 120px;
        }
        .fabric-controls button {
            padding: 4px 8px;
            font-size: 10px;
        }
    }
    
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
    
    .cancel-btn {
        background: #6c757d;
        color: white;
    }
    
    .cancel-btn:hover {
        background: #5a6268;
        color: white;
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
                            <h4><i class="fas fa-edit"></i> Edit Layout Template</h4>
                        </div>
                        <div class="ml-auto d-flex align-items-center">
                            <nav>
                                <ol class="breadcrumb p-0 m-b-0">
                                    <li class="breadcrumb-item">
                                        <a href="/admin/dashboard"><i class="ti ti-home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="/admin/layout-templates-masterlist">Layout Templates</a>
                                    </li>
                                    <li class="breadcrumb-item active">
                                        Edit Layout
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <form id="editLayoutForm">
                <?= csrf_field() ?>
                <input type="hidden" name="layout_id" id="layoutId" value="<?= isset($layout['layout_template_id']) ? $layout['layout_template_id'] : '' ?>">
                
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-th"></i> Grid Layout - Edit Images
                                </h5>
                                <div>
                                    <button type="button" id="clearAllImages" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i> Clear All Images
                                    </button>
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
                        <div class="card shadow-sm mb-3">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-info-circle"></i> Layout Information
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="layoutName">Layout Name <span class="text-danger">*</span></label>
                                    <input type="text" id="layoutName" class="form-control" 
                                           placeholder="e.g., Homepage Hero Layout, Product Gallery"
                                           value="<?= isset($layout['name']) ? esc($layout['name']) : '' ?>">
                                </div>
                                <input type="hidden" id="selectedGridId" value="<?= isset($layout['grid_template_id']) ? $layout['grid_template_id'] : '' ?>">
                                <div id="layoutInfo">
                                    <p><strong>Template:</strong> <span id="selectedTemplateName"><?= isset($layout['grid_name']) ? esc($layout['grid_name']) : '' ?></span></p>
                                    <p><strong>Images Placed:</strong> <span id="imagesPlaced">0</span></p>
                                    <p><strong>Total Cells:</strong> <span id="totalCells">0</span></p>
                                </div>
                            </div>
                        </div>
                        
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
                        
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <button type="submit" class="btn btn-success btn-block" id="updateLayoutBtn">
                                    <i class="fas fa-save"></i> Update Layout Template
                                </button>
                                <a href="/admin/layout-templates-masterlist" class="btn btn-secondary btn-block mt-2">
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.0/fabric.min.js"></script>
<script src="<?= base_url(); ?>assets/js/admin/edit-layout-template.js"></script>

<script>
    // Pass PHP variables to JavaScript - properly encode as JSON
    window.layoutData = {
        id: <?= isset($layout['layout_template_id']) ? $layout['layout_template_id'] : 0 ?>,
        name: <?= isset($layout['name']) ? json_encode($layout['name']) : json_encode('') ?>,
        grid_template_id: <?= isset($layout['grid_template_id']) ? $layout['grid_template_id'] : 0 ?>,
        grid_name: <?= isset($layout['grid_name']) ? json_encode($layout['grid_name']) : json_encode('') ?>,
        grid_layout: <?= isset($layout['grid_layout']) ? json_encode($layout['grid_layout']) : json_encode(['rows' => []]) ?>,
        images_data: <?= isset($layout['images_data']) ? json_encode($layout['images_data']) : json_encode(['images' => []]) ?>
    };
</script>