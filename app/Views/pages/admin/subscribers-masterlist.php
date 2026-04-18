<?php
// File: app/Views/pages/admin/subscribers-masterlist.php
// Newsletter Subscribers Masterlist View
?>

<?=$this->include('templates/admin/header');?>

<style>
    /* Fix for table layout */
    #subscribersmasterlist {
        width: 100%;
        table-layout: auto !important;
    }
    
    /* Ensure table cells don't overflow */
    #subscribersmasterlist td,
    #subscribersmasterlist th {
        word-break: break-word;
        vertical-align: middle;
        white-space: normal !important;
    }
    
    /* Column widths */
    #subscribersmasterlist th:nth-child(1) { width: 5%; }  /* ID */
    #subscribersmasterlist th:nth-child(2) { width: 25%; } /* Email */
    #subscribersmasterlist th:nth-child(3) { width: 15%; } /* Name */
    #subscribersmasterlist th:nth-child(4) { width: 12%; } /* Status */
    #subscribersmasterlist th:nth-child(5) { width: 10%; } /* Verified */
    #subscribersmasterlist th:nth-child(6) { width: 13%; } /* Subscribed Date */
    #subscribersmasterlist th:nth-child(7) { width: 10%; } /* Actions */
    
    /* Subscriber email styling */
    .subscriber-email-cell {
        font-weight: 600;
        color: #2c3e50;
    }
    
    /* Status badges */
    .status-badge {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-align: center;
    }
    .status-active {
        background: #d4edda;
        color: #155724;
    }
    .status-inactive {
        background: #f8d7da;
        color: #721c24;
    }
    .status-pending {
        background: #fff3cd;
        color: #856404;
    }
    
    /* Verified badge */
    .verified-badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }
    .verified-yes {
        background: #cce5ff;
        color: #004085;
    }
    .verified-no {
        background: #e2e3e5;
        color: #383d41;
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
    
    /* Export buttons */
    .export-buttons {
        display: flex;
        gap: 10px;
    }
    .export-btn {
        padding: 5px 12px;
        border-radius: 4px;
        font-size: 13px;
        transition: all 0.3s ease;
    }
    .export-csv {
        background: #28a745;
        color: white;
        border: none;
    }
    .export-csv:hover {
        background: #218838;
        color: white;
    }
    .export-excel {
        background: #007bff;
        color: white;
        border: none;
    }
    .export-excel:hover {
        background: #0069d9;
        color: white;
    }
    
    /* Filter section */
    .filter-section {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    
    /* Stats cards */
    .stats-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 20px;
        transition: transform 0.3s ease;
    }
    .stats-card:hover {
        transform: translateY(-5px);
    }
    .stats-card i {
        font-size: 32px;
        margin-bottom: 10px;
        color: #667eea;
    }
    .stats-card h3 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 5px;
    }
    .stats-card p {
        color: #6c757d;
        margin-bottom: 0;
        font-size: 14px;
    }
    
    /* Modal styling */
    .subscriber-detail-label {
        font-weight: 600;
        color: #495057;
        width: 140px;
        display: inline-block;
    }
    .detail-row {
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #e9ecef;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .stats-card h3 {
            font-size: 22px;
        }
        .stats-card i {
            font-size: 24px;
        }
        .export-buttons {
            flex-direction: column;
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
                            <h1><i class="fas fa-envelope-open-text"></i> Newsletter Subscribers</h1>
                        </div>
                        <div class="ml-auto d-flex align-items-center">
                            <nav>
                                <ol class="breadcrumb p-0 m-b-0">
                                    <li class="breadcrumb-item">
                                        <a href="/admin/dashboard"><i class="ti ti-home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item active text-primary" aria-current="page">Newsletter Subscribers</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Stats Cards -->
            <div class="row">
                <div class="col-md-3">
                    <div class="stats-card">
                        <i class="fas fa-users"></i>
                        <h3 id="totalSubscribers">0</h3>
                        <p>Total Subscribers</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <i class="fas fa-check-circle"></i>
                        <h3 id="activeSubscribers">0</h3>
                        <p>Active Subscribers</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <i class="fas fa-envelope"></i>
                        <h3 id="verifiedSubscribers">0</h3>
                        <p>Verified Subscribers</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <i class="fas fa-calendar-week"></i>
                        <h3 id="newThisMonth">0</h3>
                        <p>New This Month</p>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-statistics">
                        <div class="card-header d-flex align-items-center justify-content-between flex-wrap">
                            <div class="card-heading">
                                <h4 class="card-title"><i class="fas fa-envelope-open-text"></i> Subscribers Masterlist</h4>
                            </div>
                            <div class="export-buttons mt-2 mt-sm-0">
                                <button class="btn export-csv" id="exportCSVBtn">
                                    <i class="fas fa-file-csv"></i> Export CSV
                                </button>
                                <button class="btn export-excel" id="exportExcelBtn">
                                    <i class="fas fa-file-excel"></i> Export Excel
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Filter Section -->
                            <div class="filter-section">
                                <div class="row align-items-end">
                                    <div class="col-md-3 mb-2 mb-md-0">
                                        <label class="form-label">Status Filter</label>
                                        <select id="statusFilter" class="form-control">
                                            <option value="">All Status</option>
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                            <option value="pending">Pending</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-2 mb-md-0">
                                        <label class="form-label">Verification Filter</label>
                                        <select id="verifiedFilter" class="form-control">
                                            <option value="">All</option>
                                            <option value="1">Verified</option>
                                            <option value="0">Not Verified</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-2 mb-md-0">
                                        <label class="form-label">Date Range</label>
                                        <input type="text" id="dateRange" class="form-control" placeholder="Select date range">
                                    </div>
                                    <div class="col-md-3">
                                        <button class="btn btn-secondary btn-block" id="resetFiltersBtn">
                                            <i class="fas fa-undo-alt"></i> Reset Filters
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="datatable-wrapper table-responsive">
                                <table id="subscribersmasterlist" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Email Address</th>
                                            <th>Name</th>
                                            <th>Status</th>
                                            <th>Verified</th>
                                            <th>Subscribed Date</th>
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

<!-- View Subscriber Modal -->
<div class="modal fade" id="viewSubscriberModal" tabindex="-1" role="dialog" aria-labelledby="viewSubscriberModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewSubscriberModalLabel">
                    <i class="fas fa-user-circle"></i> Subscriber Details
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="subscriberDetailContent">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <p class="mt-2">Loading subscriber details...</p>
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
<script src="<?=base_url();?>assets/js/admin/subscribers-masterlist.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">