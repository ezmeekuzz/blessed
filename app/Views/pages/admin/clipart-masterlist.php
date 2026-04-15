<?=$this->include('templates/admin/header');?>

<style>
    /* Fix for table layout */
    #clipartmasterlist {
        width: 100%;
        table-layout: auto !important;
    }
    
    /* Ensure table cells don't overflow */
    #clipartmasterlist td,
    #clipartmasterlist th {
        word-break: break-word;
        vertical-align: middle;
        white-space: normal !important;
    }
    
    /* Column widths */
    #clipartmasterlist th:nth-child(1) { width: 5%; }  /* ID */
    #clipartmasterlist th:nth-child(2) { width: 10%; } /* Image */
    #clipartmasterlist th:nth-child(3) { width: 20%; } /* Title */
    #clipartmasterlist th:nth-child(4) { width: 15%; } /* Tags */
    #clipartmasterlist th:nth-child(5) { width: 8%; }  /* Status */
    #clipartmasterlist th:nth-child(6) { width: 12%; } /* Date Added */
    #clipartmasterlist th:nth-child(7) { width: 10%; } /* Actions */
    
    /* Clip art thumbnail styling */
    .clipart-thumbnail {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #ddd;
        background: #f8f9fa;
    }
    
    /* Title styling */
    .clipart-title-cell {
        font-weight: 600;
    }
    .clipart-title-cell small {
        display: block;
        font-size: 11px;
        color: #999;
        margin-top: 4px;
    }
    
    /* Tags container styling */
    .tags-container {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        margin: 0;
        padding: 0;
    }
    
    /* Source badge */
    .source-badge {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 600;
        margin-top: 5px;
    }
    .source-local {
        background-color: #e3f2fd;
        color: #1976d2;
    }
    .source-external {
        background-color: #e8f5e9;
        color: #388e3c;
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
    
    /* Status toggle button */
    .status-toggle {
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .status-toggle.active {
        color: #28a745;
    }
    .status-toggle.inactive {
        color: #dc3545;
    }
    
    /* View Modal Styling */
    .clipart-preview-container {
        padding: 10px;
    }
    .clipart-preview-image {
        text-align: center;
        margin-bottom: 20px;
    }
    .clipart-preview-image img {
        max-width: 100%;
        max-height: 400px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .clipart-info-table {
        width: 100%;
    }
    .clipart-info-table td {
        padding: 8px;
    }
    .clipart-info-table td:first-child {
        font-weight: 600;
        width: 30%;
        background: #f8f9fa;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .clipart-thumbnail {
            width: 40px;
            height: 40px;
        }
        #clipartmasterlist th:nth-child(3) { width: 25%; }
        .clipart-title-cell small { display: none; }
    }
    
    /* Trash toggle buttons */
    .trash-toggle {
        margin-bottom: 15px;
        display: flex;
        gap: 10px;
        justify-content: flex-end;
    }
    .trash-toggle .btn {
        border-radius: 20px;
        padding: 5px 15px;
    }
    .btn-trash-active {
        background-color: #dc3545;
        color: white;
    }
    .btn-trash-inactive {
        background-color: #6c757d;
        color: white;
    }
    
    /* Deleted badge */
    .deleted-badge {
        background-color: #dc3545;
        color: white;
        padding: 2px 8px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 600;
        margin-left: 5px;
    }
    
    /* Restore button */
    .restore-btn {
        color: #28a745;
    }
    .restore-btn:hover {
        color: #218838;
    }
    
    /* Permanently delete button */
    .force-delete-btn {
        color: #dc3545;
    }
    .force-delete-btn:hover {
        color: #c82333;
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
                            <h1><i class="fas fa-paint-brush"></i> Clip Arts</h1>
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
                                    <li class="breadcrumb-item active text-primary" aria-current="page">Clip Arts</li>
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
                                <h4 class="card-title"><i class="fas fa-paint-brush"></i> Clip Art Masterlist</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="trash-toggle">
                                <button type="button" id="showActiveBtn" class="btn btn-sm btn-primary active">
                                    <i class="fas fa-images"></i> Active Clip Arts
                                </button>
                                <button type="button" id="showTrashBtn" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash"></i> Trash (<span id="trashCount">0</span>)
                                </button>
                            </div>
                            <div class="datatable-wrapper table-responsive">
                                <table id="clipartmasterlist" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Image</th>
                                            <th>Title</th>
                                            <th>Tags</th>
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

<!-- View Clip Art Modal -->
<div class="modal fade" id="viewClipArtModal" tabindex="-1" role="dialog" aria-labelledby="viewClipArtModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewClipArtModalLabel">
                    <i class="fas fa-eye"></i> Clip Art Details
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="clipartPreviewContent" style="max-height: 80vh; overflow-y: auto;">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <p class="mt-2">Loading clip art details...</p>
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
<script src="<?=base_url();?>assets/js/admin/clipart-masterlist.js"></script>