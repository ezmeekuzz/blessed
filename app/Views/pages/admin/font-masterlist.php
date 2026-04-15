<?=$this->include('templates/admin/header');?>

<style>
    /* Fix for table layout to prevent overlapping */
    #fontmasterlist {
        width: 100%;
        table-layout: auto !important;
    }
    
    /* Ensure table cells don't overflow */
    #fontmasterlist td,
    #fontmasterlist th {
        word-break: break-word;
        vertical-align: middle;
        white-space: normal !important;
    }
    
    /* Column widths */
    #fontmasterlist th:nth-child(1) { width: 5%; }  /* ID */
    #fontmasterlist th:nth-child(2) { width: 25%; } /* Font Name */
    #fontmasterlist th:nth-child(3) { width: 10%; } /* Source Type */
    #fontmasterlist th:nth-child(4) { width: 25%; } /* Font Link / File Path */
    #fontmasterlist th:nth-child(5) { width: 8%; }  /* Featured */
    #fontmasterlist th:nth-child(6) { width: 8%; }  /* Status */
    #fontmasterlist th:nth-child(7) { width: 12%; } /* Date Added */
    #fontmasterlist th:nth-child(8) { width: 7%; }  /* Actions */
    
    /* Font name styling */
    .font-name-cell {
        font-weight: 600;
    }
    
    /* Source type badge */
    .source-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }
    .source-local {
        background-color: #e3f2fd;
        color: #1976d2;
    }
    .source-external {
        background-color: #e8f5e9;
        color: #388e3c;
    }
    
    /* Font link styling */
    .font-link-cell {
        max-width: 300px;
        word-break: break-all;
    }
    .font-link-cell a {
        color: #007bff;
        text-decoration: none;
    }
    .font-link-cell a:hover {
        text-decoration: underline;
    }
    
    /* File path styling */
    .file-path-cell {
        font-size: 12px;
        color: #666;
        word-break: break-all;
    }
    
    /* Preview font styling */
    .font-preview {
        font-family: inherit;
        font-size: 14px;
        margin-top: 5px;
        color: #666;
    }
    
    /* Status badges */
    .status-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }
    .status-active {
        background-color: #d4edda;
        color: #155724;
    }
    .status-inactive {
        background-color: #f8d7da;
        color: #721c24;
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
    
    /* Featured star */
    .featured-star {
        color: #ffc107;
        font-size: 18px;
    }
    .featured-star.not-featured {
        color: #ddd;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        #fontmasterlist th:nth-child(4) { width: 20%; }
        .font-link-cell { max-width: 150px; }
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
                            <h1><i class="fas fa-font"></i> Fonts</h1>
                        </div>
                        <div class="ml-auto d-flex align-items-center">
                            <nav>
                                <ol class="breadcrumb p-0 m-b-0">
                                    <li class="breadcrumb-item">
                                        <a href="/"><i class="ti ti-home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        Dashboard
                                    </li>
                                    <li class="breadcrumb-item active text-primary" aria-current="page">Fonts</li>
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
                                <h4 class="card-title"><i class="fas fa-font"></i> Font Masterlist</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="datatable-wrapper table-responsive">
                                <table id="fontmasterlist" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Font Name</th>
                                            <th>Source</th>
                                            <th>Font Link / File</th>
                                            <th>Featured</th>
                                            <th>Status</th>
                                            <th>Date Added</th>
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

<!-- View Font Modal -->
<div class="modal fade" id="viewFontModal" tabindex="-1" role="dialog" aria-labelledby="viewFontModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewFontModalLabel">
                    <i class="fas fa-eye"></i> Font Details
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="fontPreviewContent" style="max-height: 80vh; overflow-y: auto;">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <p class="mt-2">Loading font details...</p>
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

<script>
    let baseUrl = "<?=base_url();?>";
</script>
<script src="<?=base_url();?>assets/js/admin/font-masterlist.js"></script>