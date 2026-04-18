<?php
// File: app/Views/pages/admin/send-newsletter.php
// Send Newsletter View
?>

<?=$this->include('templates/admin/header');?>

<style>
    /* Main container styles */
    .newsletter-container {
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
    }
    .stats-card:hover {
        transform: translateY(-5px);
    }
    .stats-card i {
        font-size: 32px;
        margin-bottom: 10px;
    }
    .stats-card.subscribers i { color: #667eea; }
    .stats-card.sent i { color: #28a745; }
    .stats-card.pending i { color: #ffc107; }
    .stats-card.opened i { color: #17a2b8; }
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
    
    /* Newsletter form */
    .newsletter-form-container {
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
    
    /* Template cards */
    .template-card {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .template-card:hover {
        border-color: #667eea;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .template-card.active {
        border-color: #667eea;
        background: #f8f9ff;
    }
    .template-card-title {
        font-weight: 600;
        margin-bottom: 5px;
    }
    .template-card-desc {
        font-size: 12px;
        color: #6c757d;
    }
    
    /* Email editor */
    .email-editor {
        border: 1px solid #e9ecef;
        border-radius: 8px;
        overflow: hidden;
    }
    .email-editor-toolbar {
        background: #f8f9fa;
        padding: 10px;
        border-bottom: 1px solid #e9ecef;
    }
    .email-editor-toolbar button {
        background: none;
        border: none;
        padding: 5px 10px;
        margin: 0 2px;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .email-editor-toolbar button:hover {
        background: #e9ecef;
    }
    .email-editor-content {
        min-height: 300px;
        padding: 20px;
        background: white;
    }
    .email-editor-content:focus {
        outline: none;
    }
    
    /* Recipient list */
    .recipient-list {
        max-height: 300px;
        overflow-y: auto;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 10px;
    }
    .recipient-item {
        padding: 8px 10px;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
    }
    .recipient-item:last-child {
        border-bottom: none;
    }
    .recipient-item input {
        margin-right: 10px;
    }
    .recipient-email {
        flex: 1;
    }
    .recipient-name {
        font-size: 12px;
        color: #6c757d;
        margin-left: 10px;
    }
    
    /* Schedule options */
    .schedule-option {
        padding: 10px;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        margin-bottom: 10px;
        cursor: pointer;
    }
    .schedule-option.active {
        border-color: #667eea;
        background: #f8f9ff;
    }
    
    /* Progress bar */
    .progress-container {
        display: none;
        margin-top: 20px;
    }
    .progress-container.show {
        display: block;
    }
    .progress-stats {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
        font-size: 12px;
        color: #6c757d;
    }
    
    /* Campaign history table */
    .campaign-history-table {
        font-size: 13px;
    }
    .campaign-status {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }
    .status-sent {
        background: #d4edda;
        color: #155724;
    }
    .status-scheduled {
        background: #fff3cd;
        color: #856404;
    }
    .status-draft {
        background: #e2e3e5;
        color: #383d41;
    }
    .status-failed {
        background: #f8d7da;
        color: #721c24;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .stats-card h3 {
            font-size: 22px;
        }
        .stats-card i {
            font-size: 24px;
        }
        .template-card {
            margin-bottom: 10px;
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
                            <h1><i class="fas fa-bullhorn"></i> Send Newsletter</h1>
                        </div>
                        <div class="ml-auto d-flex align-items-center">
                            <nav>
                                <ol class="breadcrumb p-0 m-b-0">
                                    <li class="breadcrumb-item">
                                        <a href="/admin/dashboard"><i class="ti ti-home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item active text-primary" aria-current="page">Send Newsletter</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Stats Cards -->
            <div class="row">
                <div class="col-md-3">
                    <div class="stats-card subscribers">
                        <i class="fas fa-users"></i>
                        <h3 id="totalSubscribers">0</h3>
                        <p>Total Subscribers</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card sent">
                        <i class="fas fa-paper-plane"></i>
                        <h3 id="totalSent">0</h3>
                        <p>Newsletters Sent</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card pending">
                        <i class="fas fa-clock"></i>
                        <h3 id="scheduledCount">0</h3>
                        <p>Scheduled</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card opened">
                        <i class="fas fa-envelope-open"></i>
                        <h3 id="avgOpenRate">0%</h3>
                        <p>Avg. Open Rate</p>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-8">
                    <div class="newsletter-form-container">
                        <h4 class="form-section-title">
                            <i class="fas fa-edit"></i> Create Newsletter
                        </h4>
                        
                        <form id="newsletterForm" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Newsletter Subject <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="newsletterSubject" name="subject" 
                                       placeholder="Enter newsletter subject" required>
                                <small class="text-muted">This will appear as the email subject line</small>
                            </div>
                            
                            <div class="form-group">
                                <label>Preheader Text (Optional)</label>
                                <input type="text" class="form-control" id="preheaderText" name="preheader" 
                                       placeholder="Short preview text that appears after the subject line">
                                <small class="text-muted">A short summary that appears after the subject line in inbox</small>
                            </div>
                            
                            <div class="form-group">
                                <label>Email Content <span class="text-danger">*</span></label>
                                <div class="email-editor">
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
                                    <div class="email-editor-content" id="emailContent" contenteditable="true">
                                        <p>Hello [Subscriber Name],</p>
                                        <p>&nbsp;</p>
                                        <p>We hope you're having a great day! Here's our latest update:</p>
                                        <p>&nbsp;</p>
                                        <p>Best regards,<br>The Team</p>
                                    </div>
                                </div>
                                <textarea name="content" id="emailContentHidden" style="display: none;"></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label>Feature Image (Optional)</label>
                                <input type="file" class="form-control-file" id="featureImage" name="feature_image" accept="image/*">
                                <small class="text-muted">Upload an image to appear at the top of your newsletter</small>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Send As</label>
                                        <select class="form-control" id="sendFrom" name="from_email">
                                            <option value="noreply@yourdomain.com">noreply@yourdomain.com</option>
                                            <option value="newsletter@yourdomain.com">newsletter@yourdomain.com</option>
                                            <option value="admin@yourdomain.com">admin@yourdomain.com</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Reply To</label>
                                        <input type="email" class="form-control" id="replyTo" name="reply_to" 
                                               placeholder="support@yourdomain.com">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <!-- Templates -->
                    <div class="newsletter-form-container mb-3">
                        <h4 class="form-section-title">
                            <i class="fas fa-palette"></i> Templates
                        </h4>
                        <div id="templatesList">
                            <div class="template-card" data-template="welcome">
                                <div class="template-card-title">
                                    <i class="fas fa-smile"></i> Welcome Newsletter
                                </div>
                                <div class="template-card-desc">Perfect for new subscribers</div>
                            </div>
                            <div class="template-card" data-template="promo">
                                <div class="template-card-title">
                                    <i class="fas fa-tag"></i> Promotional
                                </div>
                                <div class="template-card-desc">Highlight products and offers</div>
                            </div>
                            <div class="template-card" data-template="update">
                                <div class="template-card-title">
                                    <i class="fas fa-bell"></i> Update/Announcement
                                </div>
                                <div class="template-card-desc">Share company news and updates</div>
                            </div>
                            <div class="template-card" data-template="digest">
                                <div class="template-card-title">
                                    <i class="fas fa-newspaper"></i> Weekly Digest
                                </div>
                                <div class="template-card-desc">Roundup of recent content</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Recipients -->
                    <div class="newsletter-form-container mb-3">
                        <h4 class="form-section-title">
                            <i class="fas fa-users"></i> Recipients
                        </h4>
                        
                        <div class="form-group">
                            <select class="form-control" id="recipientGroup">
                                <option value="all">All Subscribers</option>
                                <option value="active">Active Subscribers Only</option>
                                <option value="verified">Verified Subscribers</option>
                                <option value="new_last_30">New (Last 30 Days)</option>
                                <option value="custom">Custom Selection</option>
                            </select>
                        </div>
                        
                        <div id="customRecipientList" style="display: none;">
                            <label>Select Recipients:</label>
                            <div class="recipient-list" id="subscriberList">
                                <div class="text-center py-3">
                                    <div class="spinner-border spinner-border-sm text-primary"></div>
                                    Loading subscribers...
                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="button" class="btn btn-sm btn-link" id="selectAllSubscribers">
                                    Select All
                                </button>
                                <button type="button" class="btn btn-sm btn-link text-muted" id="deselectAllSubscribers">
                                    Deselect All
                                </button>
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                <strong id="recipientCount">0</strong> recipient(s) selected
                            </div>
                        </div>
                    </div>
                    
                    <!-- Schedule -->
                    <div class="newsletter-form-container">
                        <h4 class="form-section-title">
                            <i class="fas fa-calendar-alt"></i> Schedule
                        </h4>
                        
                        <div class="schedule-option active" data-schedule="now">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="scheduleType" id="sendNow" value="now" checked>
                                <label class="form-check-label" for="sendNow">
                                    <strong>Send Now</strong>
                                    <div class="small text-muted">Send immediately after confirmation</div>
                                </label>
                            </div>
                        </div>
                        
                        <div class="schedule-option" data-schedule="later">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="scheduleType" id="scheduleLater" value="later">
                                <label class="form-check-label" for="scheduleLater">
                                    <strong>Schedule for Later</strong>
                                    <div class="small text-muted">Choose date and time to send</div>
                                </label>
                            </div>
                            <div id="scheduleDateTime" style="display: none; margin-top: 15px; margin-left: 25px;">
                                <input type="datetime-local" class="form-control" id="scheduledDateTime">
                            </div>
                        </div>
                        
                        <div class="schedule-option" data-schedule="draft">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="scheduleType" id="saveDraft" value="draft">
                                <label class="form-check-label" for="saveDraft">
                                    <strong>Save as Draft</strong>
                                    <div class="small text-muted">Save to send or edit later</div>
                                </label>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <button type="button" class="btn btn-primary btn-block" id="previewBtn">
                            <i class="fas fa-eye"></i> Preview Newsletter
                        </button>
                        
                        <button type="button" class="btn btn-success btn-block mt-2" id="sendNewsletterBtn">
                            <i class="fas fa-paper-plane"></i> Send Newsletter
                        </button>
                        
                        <button type="button" class="btn btn-secondary btn-block mt-2" id="saveDraftBtn">
                            <i class="fas fa-save"></i> Save as Draft
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Campaign History -->
            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card card-statistics">
                        <div class="card-header">
                            <div class="card-heading">
                                <h4 class="card-title">
                                    <i class="fas fa-history"></i> Campaign History
                                </h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered campaign-history-table" id="campaignHistoryTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Subject</th>
                                            <th>Recipients</th>
                                            <th>Sent/Scheduled</th>
                                            <th>Status</th>
                                            <th>Open Rate</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="campaignHistoryBody">
                                        <tr>
                                            <td colspan="7" class="text-center">Loading campaigns...</td>
                                        </tr>
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

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-eye"></i> Newsletter Preview
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="previewContent" style="max-height: 70vh; overflow-y: auto;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Send Confirmation Modal -->
<div class="modal fade" id="sendConfirmModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-paper-plane"></i> Confirm Send
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to send this newsletter to <strong id="confirmRecipientCount">0</strong> recipient(s)?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i> This action cannot be undone.
                </div>
                <div id="sendProgress" style="display: none;">
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                    </div>
                    <div class="progress-stats">
                        <span id="sentCount">0</span> / <span id="totalToSend">0</span> sent
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirmSendBtn">Send Now</button>
            </div>
        </div>
    </div>
</div>

<?=$this->include('templates/admin/footer');?>
<script src="<?=base_url();?>assets/js/admin/send-newsletter.js"></script>