<?=$this->include('templates/admin/header');?>

<style>
    /* Fix for table layout */
    #customermasterlist {
        width: 100%;
        table-layout: auto !important;
    }
    
    /* Ensure table cells don't overflow */
    #customermasterlist td,
    #customermasterlist th {
        word-break: break-word;
        vertical-align: middle;
        white-space: normal !important;
    }
    
    /* Column widths */
    #customermasterlist th:nth-child(1) { width: 5%; }  /* ID */
    #customermasterlist th:nth-child(2) { width: 20%; } /* Customer Name */
    #customermasterlist th:nth-child(3) { width: 20%; } /* Email */
    #customermasterlist th:nth-child(4) { width: 12%; } /* Email Verified */
    #customermasterlist th:nth-child(5) { width: 8%; }  /* Status */
    #customermasterlist th:nth-child(6) { width: 15%; } /* Date Registered */
    #customermasterlist th:nth-child(7) { width: 10%; } /* Actions */
    
    /* Customer name styling */
    .customer-name-cell {
        font-weight: 600;
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
    .status-toggle, .verify-toggle {
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    /* View Modal Styling */
    .customer-preview-container {
        padding: 10px;
    }
    .customer-info-table {
        width: 100%;
    }
    .customer-info-table td {
        padding: 8px;
    }
    .customer-info-table td:first-child {
        font-weight: 600;
        width: 35%;
        background: #f8f9fa;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        #customermasterlist th:nth-child(2) { width: 25%; }
        #customermasterlist th:nth-child(3) { width: 25%; }
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
                            <h1><i class="fas fa-users"></i> Customers</h1>
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
                                    <li class="breadcrumb-item active text-primary" aria-current="page">Customers</li>
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
                                <h4 class="card-title"><i class="fas fa-users"></i> Customer Masterlist</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="datatable-wrapper table-responsive">
                                <table id="customermasterlist" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Customer Name</th>
                                            <th>Email Address</th>
                                            <th>Email Verified</th>
                                            <th>Status</th>
                                            <th>Date Registered</th>
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

<!-- View Customer Modal -->
<div class="modal fade" id="viewCustomerModal" tabindex="-1" role="dialog" aria-labelledby="viewCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewCustomerModalLabel">
                    <i class="fas fa-user-circle"></i> Customer Details
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="customerPreviewContent" style="max-height: 80vh; overflow-y: auto;">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <p class="mt-2">Loading customer details...</p>
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
<script src="<?=base_url();?>assets/js/admin/customer-masterlist.js"></script>