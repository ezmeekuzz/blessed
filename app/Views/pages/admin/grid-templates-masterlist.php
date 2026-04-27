<?=$this->include('templates/admin/header');?>

<style>
    /* Fix for table layout */
    #templatesmasterlist {
        width: 100%;
        table-layout: auto !important;
    }
    
    /* Ensure table cells don't overflow */
    #templatesmasterlist td,
    #templatesmasterlist th {
        word-break: break-word;
        vertical-align: middle;
        white-space: normal !important;
    }
    
    /* Column widths */
    #templatesmasterlist th:nth-child(1) { width: 5%; }  /* ID */
    #templatesmasterlist th:nth-child(2) { width: 20%; } /* Template Name */
    #templatesmasterlist th:nth-child(3) { width: 15%; } /* Preview */
    #templatesmasterlist th:nth-child(4) { width: 10%; } /* Columns */
    #templatesmasterlist th:nth-child(5) { width: 8%; }  /* Featured */
    #templatesmasterlist th:nth-child(6) { width: 10%; } /* Created */
    #templatesmasterlist th:nth-child(7) { width: 12%; } /* Last Modified */
    #templatesmasterlist th:nth-child(8) { width: 10%; } /* Actions */
    
    /* Template name styling */
    .template-name-cell {
        font-weight: 600;
    }
    
    /* Preview box */
    .template-preview-box {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 8px;
        padding: 10px;
        color: white;
        min-width: 120px;
    }
    
    .template-preview-box .row {
        margin: 0 -2px;
    }
    
    .template-preview-box .col {
        background: rgba(255,255,255,0.2);
        border-radius: 4px;
        padding: 6px 2px;
        margin: 0 2px;
        font-size: 10px;
        font-weight: 600;
        text-align: center;
    }
    
    /* Columns badge */
    .columns-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        background: #e3f2fd;
        color: #1976d2;
    }
    
    /* Featured star */
    .featured-star {
        color: #ffc107;
        font-size: 18px;
    }
    .featured-star.not-featured {
        color: #ddd;
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
    .template-preview-large {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 16px;
        padding: 30px;
        color: white;
        margin-bottom: 20px;
    }
    
    .template-preview-large .row {
        margin: 0 -5px;
    }
    
    .template-preview-large .col {
        background: rgba(255,255,255,0.15);
        border-radius: 8px;
        padding: 20px 5px;
        margin: 0 5px;
        text-align: center;
        font-weight: 600;
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
        #templatesmasterlist th:nth-child(3) { width: 12%; }
        .template-preview-box { min-width: 80px; }
        .template-preview-box .col { padding: 3px 1px; font-size: 8px; }
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
                            <h1><i class="fas fa-th-large"></i> Grid Templates</h1>
                        </div>
                        <div class="ml-auto d-flex align-items-center">
                            <nav>
                                <ol class="breadcrumb p-0 m-b-0">
                                    <li class="breadcrumb-item">
                                        <a href="/"><i class="ti ti-home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item active text-primary" aria-current="page">Grid Templates</li>
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
                                <h4 class="card-title"><i class="fas fa-th-large"></i> Templates Masterlist</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="datatable-wrapper table-responsive">
                                <table id="templatesmasterlist" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Template Name</th>
                                            <th>Preview</th>
                                            <th>Columns</th>
                                            <th>Featured</th>
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

<!-- View Template Modal -->
<div class="modal fade" id="viewTemplateModal" tabindex="-1" role="dialog" aria-labelledby="viewTemplateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewTemplateModalLabel">
                    <i class="fas fa-eye"></i> Template Details
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="templatePreviewContent" style="max-height: 80vh; overflow-y: auto;">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <p class="mt-2">Loading template details...</p>
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
<script src="<?=base_url();?>assets/js/admin/grid-templates-masterlist.js"></script>