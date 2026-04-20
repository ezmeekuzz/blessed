<?php
// File: app/Views/pages/admin/messages.php
// Contact Messages Masterlist View
?>

<?=$this->include('templates/admin/header');?>

<style>
    /* Fix for table layout */
    #contactmessageslist {
        width: 100%;
        table-layout: auto !important;
    }
    
    /* Ensure table cells don't overflow */
    #contactmessageslist td,
    #contactmessageslist th {
        word-break: break-word;
        vertical-align: middle;
        white-space: normal !important;
    }
    
    /* Status badges */
    .status-badge {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-align: center;
    }
    .status-unread {
        background: #dc3545;
        color: white;
    }
    .status-read {
        background: #28a745;
        color: white;
    }
    
    /* Message preview */
    .message-preview {
        max-width: 250px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        color: #6c757d;
        font-size: 13px;
    }
    .message-preview i {
        margin-right: 5px;
        color: #92b0d0;
    }
    
    /* Unread row styling */
    .unread-row {
        background-color: #fff3cd !important;
        font-weight: 600;
    }
    .unread-row td {
        background-color: #fff3cd !important;
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
    }
    .stats-card.unread i { color: #dc3545; }
    .stats-card.today i { color: #28a745; }
    .stats-card.total i { color: #667eea; }
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
    
    /* Message detail modal */
    .message-detail-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    .message-detail-label {
        font-weight: 600;
        color: #495057;
        width: 100px;
        display: inline-block;
    }
    .detail-row {
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #e9ecef;
    }
    .message-content-box {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-top: 15px;
        white-space: pre-wrap;
        line-height: 1.6;
    }
    
    /* Filter section */
    .filter-section {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    
    /* Bulk actions */
    .bulk-actions {
        display: none;
        background: #e3f2fd;
        padding: 10px 15px;
        border-radius: 8px;
        margin-bottom: 15px;
        align-items: center;
        justify-content: space-between;
    }
    .bulk-actions.show {
        display: flex;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .stats-card h3 {
            font-size: 22px;
        }
        .stats-card i {
            font-size: 24px;
        }
        .action-buttons {
            flex-direction: column;
            gap: 5px;
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
                            <h1><i class="fas fa-envelope"></i> Contact Messages</h1>
                        </div>
                        <div class="ml-auto d-flex align-items-center">
                            <nav>
                                <ol class="breadcrumb p-0 m-b-0">
                                    <li class="breadcrumb-item">
                                        <a href="/admin/dashboard"><i class="ti ti-home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item active text-primary" aria-current="page">Contact Messages</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Stats Cards -->
            <div class="row">
                <div class="col-md-4">
                    <div class="stats-card unread">
                        <i class="fas fa-envelope"></i>
                        <h3 id="unreadCount">0</h3>
                        <p>Unread Messages</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card today">
                        <i class="fas fa-calendar-day"></i>
                        <h3 id="todayCount">0</h3>
                        <p>Today's Messages</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card total">
                        <i class="fas fa-database"></i>
                        <h3 id="totalCount">0</h3>
                        <p>Total Messages</p>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-statistics">
                        <div class="card-header d-flex align-items-center justify-content-between flex-wrap">
                            <div class="card-heading">
                                <h4 class="card-title"><i class="fas fa-envelope-open-text"></i> Contact Messages Masterlist</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Filter Section -->
                            <div class="filter-section">
                                <div class="row align-items-end">
                                    <div class="col-md-4 mb-2 mb-md-0">
                                        <label class="form-label">Status Filter</label>
                                        <select id="statusFilter" class="form-control">
                                            <option value="">All Messages</option>
                                            <option value="unread">Unread</option>
                                            <option value="read">Read</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-2 mb-md-0">
                                        <label class="form-label">Date Range</label>
                                        <input type="text" id="dateRange" class="form-control" placeholder="Select date range">
                                    </div>
                                    <div class="col-md-4">
                                        <button class="btn btn-secondary btn-block" id="resetFiltersBtn">
                                            <i class="fas fa-undo-alt"></i> Reset Filters
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Bulk Actions Bar -->
                            <div class="bulk-actions" id="bulkActionsBar">
                                <div>
                                    <strong><span id="selectedCount">0</span> messages selected</strong>
                                </div>
                                <div>
                                    <button class="btn btn-sm btn-success" id="bulkMarkReadBtn2">
                                        <i class="fas fa-check-double"></i> Mark as Read
                                    </button>
                                    <button class="btn btn-sm btn-danger" id="bulkDeleteBtn2">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                    <button class="btn btn-sm btn-secondary" id="clearSelectionBtn">
                                        <i class="fas fa-times"></i> Clear
                                    </button>
                                </div>
                            </div>
                            
                            <div class="datatable-wrapper table-responsive">
                                <table id="contactmessageslist" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 3%;">
                                                <input type="checkbox" id="selectAllCheckbox">
                                            </th>
                                            <th style="width: 5%;">ID</th>
                                            <th style="width: 12%;">Name</th>
                                            <th style="width: 15%;">Email</th>
                                            <th style="width: 15%;">Subject</th>
                                            <th style="width: 30%;">Message</th>
                                            <th style="width: 10%;">Status</th>
                                            <th style="width: 10%;">Date</th>
                                            <th style="width: 5%;">Actions</th>
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

<!-- View Message Modal -->
<div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="messageModalLabel">
                    <i class="fas fa-envelope-open"></i> Message Details
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="messageDetailContent" style="max-height: 70vh; overflow-y: auto;">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <p class="mt-2">Loading message details...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?=$this->include('templates/admin/footer');?>
<script src="<?=base_url();?>assets/js/admin/messages.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">