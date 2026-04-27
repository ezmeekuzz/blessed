<?=$this->include('templates/admin/header');?>

<style>
    /* Fix for table layout */
    #layouttemplatesmasterlist {
        width: 100%;
        table-layout: auto !important;
    }
    
    /* Ensure table cells don't overflow */
    #layouttemplatesmasterlist td,
    #layouttemplatesmasterlist th {
        word-break: break-word;
        vertical-align: middle;
        white-space: normal !important;
    }
    
    /* Column widths */
    #layouttemplatesmasterlist th:nth-child(1) { width: 5%; }  /* ID */
    #layouttemplatesmasterlist th:nth-child(2) { width: 20%; } /* Layout Name */
    #layouttemplatesmasterlist th:nth-child(3) { width: 15%; } /* Grid Template */
    #layouttemplatesmasterlist th:nth-child(4) { width: 10%; } /* Images Count */
    #layouttemplatesmasterlist th:nth-child(5) { width: 15%; } /* Preview */
    #layouttemplatesmasterlist th:nth-child(6) { width: 10%; } /* Created */
    #layouttemplatesmasterlist th:nth-child(7) { width: 10%; } /* Last Modified */
    #layouttemplatesmasterlist th:nth-child(8) { width: 15%; } /* Actions */
    
    /* Layout name styling */
    .layout-name-cell {
        font-weight: 600;
    }
    
    /* Grid badge */
    .grid-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        background: #e8f5e9;
        color: #2e7d32;
    }
    
    /* Images count badge */
    .images-count-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        background: #fff3e0;
        color: #e65100;
    }
    
    /* Preview box */
    .layout-preview-box {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 8px;
        padding: 10px;
        color: white;
        min-width: 120px;
    }
    
    .layout-preview-box .row {
        margin: 0 -2px;
    }
    
    .layout-preview-box .col {
        background: rgba(255,255,255,0.2);
        border-radius: 4px;
        padding: 6px 2px;
        margin: 0 2px;
        font-size: 10px;
        font-weight: 600;
        text-align: center;
    }
    
    /* Action buttons */
    .action-buttons {
        display: flex;
        gap: 8px;
        justify-content: center;
    }
    .action-buttons a {
        text-decoration: none;
    }
    
    /* View Modal Styling */
    .layout-preview-large {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 16px;
        padding: 30px;
        color: white;
        margin-bottom: 20px;
    }
    
    .layout-preview-large .row {
        margin: 0 -5px;
    }
    
    .layout-preview-large .col {
        background: rgba(255,255,255,0.15);
        border-radius: 8px;
        padding: 20px 5px;
        margin: 0 5px;
        text-align: center;
        font-weight: 600;
    }
    
    .images-gallery {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 15px;
        margin-top: 15px;
    }
    
    .gallery-image-item {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        overflow: hidden;
        background: white;
    }
    
    .gallery-image-item img {
        width: 100%;
        height: 120px;
        object-fit: cover;
    }
    
    .gallery-image-item .image-info {
        padding: 8px;
        font-size: 11px;
        text-align: center;
        background: #f8f9fa;
    }
    
    .json-viewer {
        background: #1e1e1e;
        color: #d4d4d4;
        padding: 15px;
        border-radius: 8px;
        font-family: monospace;
        font-size: 12px;
        max-height: 400px;
        overflow: auto;
        white-space: pre-wrap;
        word-break: break-all;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        #layouttemplatesmasterlist th:nth-child(5) { width: 12%; }
        .layout-preview-box { min-width: 80px; }
        .layout-preview-box .col { padding: 3px 1px; font-size: 8px; }
        .images-gallery {
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        }
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
                            <h1><i class="fas fa-images"></i> Layout Templates</h1>
                        </div>
                        <div class="ml-auto d-flex align-items-center">
                            <nav>
                                <ol class="breadcrumb p-0 m-b-0">
                                    <li class="breadcrumb-item">
                                        <a href="/admin/dashboard"><i class="ti ti-home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item active text-primary" aria-current="page">Layout Templates</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-statistics">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <div class="card-heading">
                                <h4 class="card-title"><i class="fas fa-images"></i> Layout Templates Masterlist</h4>
                            </div>
                            <div>
                                <a href="/admin/add-layout-template" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Create New Layout
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="datatable-wrapper table-responsive">
                                <table id="layouttemplatesmasterlist" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Layout Name</th>
                                            <th>Grid Template</th>
                                            <th>Images</th>
                                            <th>Preview</th>
                                            <th>Created</th>
                                            <th>Last Modified</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- View Layout Template Modal -->
<div class="modal fade" id="viewLayoutModal" tabindex="-1" role="dialog" aria-labelledby="viewLayoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewLayoutModalLabel">
                    <i class="fas fa-eye"></i> Layout Template Details
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="layoutPreviewContent" style="max-height: 80vh; overflow-y: auto;">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <p class="mt-2">Loading layout details...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>

<?=$this->include('templates/admin/footer');?>
<script src="<?=base_url();?>assets/js/admin/layout-templates-masterlist.js"></script>