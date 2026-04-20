<?php
// File: app/Views/pages/admin/email-templates.php
// Email Templates Management View - WITH DYNAMIC STATS
?>

<?=$this->include('templates/admin/header');?>

<style>
    /* Fix modal z-index issues */
    .modal {
        z-index: 9999 !important;
    }
    .modal-backdrop {
        z-index: 9998 !important;
    }
    .modal-open {
        overflow: hidden !important;
        padding-right: 0 !important;
    }
    
    /* Main container styles */
    .templates-container {
        padding: 20px 0;
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
        cursor: pointer;
    }
    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    .stats-card i {
        font-size: 32px;
        margin-bottom: 10px;
    }
    .stats-card.total i { color: #667eea; }
    .stats-card.active i { color: #28a745; }
    .stats-card.categories i { color: #ffc107; }
    .stats-card.used i { color: #17a2b8; }
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
    
    /* Loading animation for stats */
    .stats-loading {
        animation: pulse 1.5s ease-in-out infinite;
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    
    /* Template cards */
    .template-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 25px;
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
    }
    .template-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    .template-preview {
        height: 160px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .template-preview i {
        font-size: 48px;
        color: rgba(255,255,255,0.8);
    }
    .template-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(0,0,0,0.7);
        color: white;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }
    .template-body {
        padding: 15px;
    }
    .template-title {
        font-weight: 700;
        font-size: 16px;
        margin-bottom: 5px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .template-description {
        font-size: 13px;
        color: #6c757d;
        margin-bottom: 10px;
        line-height: 1.4;
        height: 40px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    .template-meta {
        display: flex;
        justify-content: space-between;
        font-size: 11px;
        color: #adb5bd;
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid #e9ecef;
    }
    .template-actions {
        display: flex;
        gap: 8px;
        margin-top: 12px;
        flex-wrap: wrap;
    }
    .template-actions .btn {
        flex: 1;
        padding: 5px 8px;
        font-size: 12px;
        min-width: 0;
    }
    
    /* Category pills */
    .category-pill {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 600;
        margin-right: 5px;
        margin-bottom: 5px;
    }
    .category-welcome { background: #d4edda; color: #155724; }
    .category-promo { background: #fff3cd; color: #856404; }
    .category-update { background: #cce5ff; color: #004085; }
    .category-newsletter { background: #e2e3e5; color: #383d41; }
    .category-order { background: #d1ecf1; color: #0c5460; }
    .category-default { background: #f8f9fa; color: #6c757d; }
    
    /* Form styles */
    .template-form-container {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .form-section-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #667eea;
        display: inline-block;
    }
    
    /* Code editor */
    .code-editor {
        font-family: 'Courier New', monospace;
        font-size: 13px;
        background: #1e1e1e;
        color: #d4d4d4;
        padding: 15px;
        border-radius: 8px;
        min-height: 400px;
        width: 100%;
    }
    
    /* Email editor */
    .email-editor-container {
        border: 1px solid #e9ecef;
        border-radius: 8px;
        overflow: hidden;
    }
    .email-editor-toolbar {
        background: #f8f9fa;
        padding: 8px 12px;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
    }
    .email-editor-toolbar button {
        background: none;
        border: none;
        padding: 5px 10px;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .email-editor-toolbar button:hover {
        background: #e9ecef;
    }
    .email-editor-content {
        min-height: 400px;
        padding: 20px;
        background: white;
        overflow-y: auto;
    }
    .email-editor-content:focus {
        outline: none;
    }
    
    /* Variable tags */
    .variable-tag {
        display: inline-block;
        background: #e9ecef;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        margin: 3px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .variable-tag:hover {
        background: #667eea;
        color: white;
    }
    
    /* Tabs */
    .template-tabs {
        border-bottom: 2px solid #e9ecef;
        margin-bottom: 20px;
    }
    .template-tab {
        display: inline-block;
        padding: 10px 20px;
        cursor: pointer;
        font-weight: 500;
        color: #6c757d;
        border-bottom: 2px solid transparent;
        margin-bottom: -2px;
    }
    .template-tab.active {
        color: #667eea;
        border-bottom-color: #667eea;
    }
    
    /* Modal body max height */
    .modal-body-scroll {
        max-height: 70vh;
        overflow-y: auto;
    }
    
    /* Stats refresh indicator */
    .stats-refresh {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 12px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .stats-card:hover .stats-refresh {
        opacity: 0.7;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .stats-card h3 {
            font-size: 22px;
        }
        .template-card {
            margin-bottom: 15px;
        }
        .template-tab {
            padding: 8px 12px;
            font-size: 13px;
        }
        .template-actions .btn {
            font-size: 10px;
            padding: 4px 6px;
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
                            <h1><i class="fas fa-envelope-open"></i> Email Templates</h1>
                        </div>
                        <div class="ml-auto d-flex align-items-center">
                            <nav>
                                <ol class="breadcrumb p-0 m-b-0">
                                    <li class="breadcrumb-item">
                                        <a href="/admin/dashboard"><i class="ti ti-home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item active text-primary" aria-current="page">Email Templates</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Stats Cards - Will be populated dynamically via JavaScript -->
            <div class="row" id="statsContainer">
                <div class="col-md-3">
                    <div class="stats-card total">
                        <i class="fas fa-database"></i>
                        <h3 id="totalTemplates">--</h3>
                        <p>Total Templates</p>
                        <small class="stats-refresh text-muted"><i class="fas fa-sync-alt"></i> Click to refresh</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card active">
                        <i class="fas fa-check-circle"></i>
                        <h3 id="activeTemplates">--</h3>
                        <p>Active Templates</p>
                        <small class="stats-refresh text-muted"><i class="fas fa-sync-alt"></i> Click to refresh</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card categories">
                        <i class="fas fa-tags"></i>
                        <h3 id="totalCategories">--</h3>
                        <p>Categories</p>
                        <small class="stats-refresh text-muted"><i class="fas fa-sync-alt"></i> Click to refresh</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card used">
                        <i class="fas fa-chart-line"></i>
                        <h3 id="mostUsed">--</h3>
                        <p>Most Used Count</p>
                        <small class="stats-refresh text-muted"><i class="fas fa-sync-alt"></i> Click to refresh</small>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <!-- Action Buttons -->
                    <div class="mb-3">
                        <button class="btn btn-primary" id="createTemplateBtn">
                            <i class="fas fa-plus"></i> Create New Template
                        </button>
                        <button class="btn btn-outline-secondary" id="refreshTemplatesBtn">
                            <i class="fas fa-sync-alt"></i> Refresh
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <div id="templatesGrid"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create/Edit Template Modal -->
<div class="modal fade" id="templateModal" tabindex="-1" role="dialog" aria-labelledby="templateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="templateModalLabel">
                    <i class="fas fa-plus-circle"></i> Create New Template
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal-body-scroll">
                <form id="templateForm">
                    <input type="hidden" id="templateId" name="template_id">
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Template Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="templateName" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Category</label>
                                <select class="form-control" id="templateCategory" name="category">
                                    <option value="welcome">Welcome Email</option>
                                    <option value="promo">Promotional</option>
                                    <option value="update">Update/Announcement</option>
                                    <option value="newsletter">Newsletter</option>
                                    <option value="order">Order Confirmation</option>
                                    <option value="custom">Custom</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" id="templateDescription" name="description" rows="2" 
                                  placeholder="Brief description of when to use this template"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>Email Subject <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="templateSubject" name="subject" required>
                        <small class="text-muted">Use variables like {name}, {site_name}, etc.</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Preheader Text</label>
                        <input type="text" class="form-control" id="templatePreheader" name="preheader">
                        <small class="text-muted">Short preview text that appears after the subject line</small>
                    </div>
                    
                    <!-- Tabs for HTML and Visual Editor -->
                    <div class="template-tabs">
                        <span class="template-tab active" data-editor="visual">
                            <i class="fas fa-eye"></i> Visual Editor
                        </span>
                        <span class="template-tab" data-editor="html">
                            <i class="fas fa-code"></i> HTML Editor
                        </span>
                    </div>
                    
                    <!-- Visual Editor -->
                    <div id="visualEditor" class="email-editor-container">
                        <div class="email-editor-toolbar">
                            <button type="button" data-command="bold" title="Bold"><i class="fas fa-bold"></i></button>
                            <button type="button" data-command="italic" title="Italic"><i class="fas fa-italic"></i></button>
                            <button type="button" data-command="underline" title="Underline"><i class="fas fa-underline"></i></button>
                            <span class="mx-1">|</span>
                            <button type="button" data-command="insertUnorderedList" title="Bullet List"><i class="fas fa-list-ul"></i></button>
                            <button type="button" data-command="insertOrderedList" title="Numbered List"><i class="fas fa-list-ol"></i></button>
                            <span class="mx-1">|</span>
                            <button type="button" data-command="createLink" title="Insert Link"><i class="fas fa-link"></i></button>
                            <button type="button" data-command="insertImage" title="Insert Image"><i class="fas fa-image"></i></button>
                            <span class="mx-1">|</span>
                            <button type="button" data-command="undo" title="Undo"><i class="fas fa-undo"></i></button>
                            <button type="button" data-command="redo" title="Redo"><i class="fas fa-redo"></i></button>
                        </div>
                        <div class="email-editor-content" id="visualEmailContent" contenteditable="true">
                            <h2>Hello {name},</h2>
                            <p>&nbsp;</p>
                            <p>Welcome to our community! We're excited to have you with us.</p>
                            <p>&nbsp;</p>
                            <p>Best regards,<br>The {site_name} Team</p>
                        </div>
                    </div>
                    
                    <!-- HTML Editor -->
                    <div id="htmlEditor" style="display: none;">
                        <textarea class="form-control code-editor" id="htmlEmailContent" rows="20" placeholder="Enter HTML code here..."></textarea>
                    </div>
                    
                    <div class="form-group mt-3">
                        <label>Available Variables</label>
                        <div id="variableList">
                            <span class="variable-tag" data-var="{name}">{name} - Recipient Name</span>
                            <span class="variable-tag" data-var="{email}">{email} - Recipient Email</span>
                            <span class="variable-tag" data-var="{site_name}">{site_name} - Website Name</span>
                            <span class="variable-tag" data-var="{site_url}">{site_url} - Website URL</span>
                            <span class="variable-tag" data-var="{unsubscribe_link}">{unsubscribe_link} - Unsubscribe Link</span>
                            <span class="variable-tag" data-var="{view_online}">{view_online} - View Online Link</span>
                            <span class="variable-tag" data-var="{current_year}">{current_year} - Current Year</span>
                            <span class="variable-tag" data-var="{order_id}">{order_id} - Order ID</span>
                            <span class="variable-tag" data-var="{product_name}">{product_name} - Product Name</span>
                            <span class="variable-tag" data-var="{promo_code}">{promo_code} - Promo Code</span>
                        </div>
                        <small class="text-muted">Click on any variable to insert it into the email content</small>
                    </div>
                    
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="templateActive" name="is_active" value="1" checked>
                            <label class="custom-control-label" for="templateActive">Active</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="button" class="btn btn-primary" id="saveTemplateBtn">
                    <i class="fas fa-save"></i> Save Template
                </button>
                <button type="button" class="btn btn-success" id="previewTemplateBtn">
                    <i class="fas fa-eye"></i> Preview
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-eye"></i> Template Preview
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="previewContent" style="max-height: 70vh; overflow-y: auto; background: #f4f4f4;">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-trash"></i> Delete Template
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the template <strong id="deleteTemplateName"></strong>?</p>
                <p class="text-danger">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
            </div>
        </div>
    </div>
</div>

<?=$this->include('templates/admin/footer');?>
<script src="<?=base_url();?>assets/js/admin/email-templates.js"></script>