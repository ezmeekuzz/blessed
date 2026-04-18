// File: assets/js/admin/email-templates.js
// Email Templates Management JavaScript - FIXED

$(document).ready(function () {
    let currentDeleteId = null;
    let currentEditorMode = 'visual';
    
    // Initialize rich text editor
    initEditor();
    
    // Load templates on page load
    loadTemplates();
    loadStats();
    
    // Create new template button
    $('#createTemplateBtn').on('click', function() {
        resetForm();
        $('#templateModalLabel').html('<i class="fas fa-plus-circle"></i> Create New Template');
        $('#templateModal').modal({
            backdrop: 'static',
            keyboard: false
        });
        $('#templateModal').modal('show');
        // Fix modal z-index
        $('.modal-backdrop').css('z-index', '9998');
        $('#templateModal').css('z-index', '9999');
    });
    
    // Refresh button
    $('#refreshTemplatesBtn').on('click', function() {
        loadTemplates();
        loadStats();
    });
    
    // Tab switching
    $('.template-tab').on('click', function() {
        let mode = $(this).data('editor');
        currentEditorMode = mode;
        
        $('.template-tab').removeClass('active');
        $(this).addClass('active');
        
        if (mode === 'visual') {
            // Sync HTML to visual editor
            let htmlContent = $('#htmlEmailContent').val();
            if (htmlContent && htmlContent.trim() !== '') {
                $('#visualEmailContent').html(htmlContent);
            }
            $('#visualEditor').show();
            $('#htmlEditor').hide();
        } else {
            // Sync visual to HTML editor
            let visualContent = $('#visualEmailContent').html();
            $('#htmlEmailContent').val(visualContent);
            $('#visualEditor').hide();
            $('#htmlEditor').show();
        }
    });
    
    // Insert variable
    $(document).on('click', '.variable-tag', function() {
        let variable = $(this).data('var');
        
        if (currentEditorMode === 'visual') {
            // For visual editor
            let editor = document.getElementById('visualEmailContent');
            editor.focus();
            document.execCommand('insertText', false, variable);
        } else {
            // For HTML editor
            let textarea = $('#htmlEmailContent');
            let cursorPos = textarea.prop('selectionStart');
            let text = textarea.val();
            let newText = text.substring(0, cursorPos) + variable + text.substring(cursorPos);
            textarea.val(newText);
        }
    });
    
    // Save template
    $('#saveTemplateBtn').on('click', function() {
        let name = $('#templateName').val().trim();
        let subject = $('#templateSubject').val().trim();
        
        if (!name) {
            Swal.fire({
                icon: 'warning',
                title: 'Missing Name',
                text: 'Please enter a template name'
            });
            return;
        }
        
        if (!subject) {
            Swal.fire({
                icon: 'warning',
                title: 'Missing Subject',
                text: 'Please enter an email subject'
            });
            return;
        }
        
        let content = currentEditorMode === 'visual' 
            ? $('#visualEmailContent').html() 
            : $('#htmlEmailContent').val();
        
        if (!content || content === '<p><br></p>' || content.trim() === '' || content === '<div><br></div>') {
            Swal.fire({
                icon: 'warning',
                title: 'Missing Content',
                text: 'Please enter email content'
            });
            return;
        }
        
        let formData = {
            template_id: $('#templateId').val(),
            name: name,
            description: $('#templateDescription').val(),
            category: $('#templateCategory').val(),
            subject: subject,
            preheader: $('#templatePreheader').val(),
            content: content,
            is_active: $('#templateActive').is(':checked') ? 1 : 0
        };
        
        Swal.fire({
            title: 'Saving...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        $.ajax({
            url: '/admin/email-templates/save',
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                Swal.close();
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                    $('#templateModal').modal('hide');
                    // Remove backdrop manually if needed
                    $('.modal-backdrop').remove();
                    $('body').removeClass('modal-open');
                    loadTemplates();
                    loadStats();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function(xhr) {
                Swal.close();
                let errorMsg = 'Something went wrong. Please try again.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMsg
                });
            }
        });
    });
    
    // Preview template
    $('#previewTemplateBtn').on('click', function() {
        let subject = $('#templateSubject').val();
        let content = currentEditorMode === 'visual' 
            ? $('#visualEmailContent').html() 
            : $('#htmlEmailContent').val();
        let preheader = $('#templatePreheader').val();
        
        if (!subject) {
            Swal.fire({
                icon: 'warning',
                title: 'Missing Subject',
                text: 'Please enter a subject before previewing'
            });
            return;
        }
        
        let previewHtml = buildEmailPreview(subject, preheader, content);
        $('#previewContent').html(previewHtml);
        $('#previewModal').modal({
            backdrop: 'static',
            keyboard: true
        });
        $('#previewModal').modal('show');
        $('.modal-backdrop').css('z-index', '9998');
        $('#previewModal').css('z-index', '9999');
    });
    
    // Edit template
    $(document).on('click', '.edit-template', function() {
        let id = $(this).data('id');
        
        Swal.fire({
            title: 'Loading...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        $.ajax({
            url: '/admin/email-templates/get/' + id,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                Swal.close();
                if (response.status === 'success') {
                    let data = response.data;
                    $('#templateId').val(data.template_id);
                    $('#templateName').val(data.name);
                    $('#templateDescription').val(data.description || '');
                    $('#templateCategory').val(data.category);
                    $('#templateSubject').val(data.subject);
                    $('#templatePreheader').val(data.preheader || '');
                    $('#visualEmailContent').html(data.content);
                    $('#htmlEmailContent').val(data.content);
                    $('#templateActive').prop('checked', data.is_active == 1);
                    
                    $('#templateModalLabel').html('<i class="fas fa-edit"></i> Edit Template');
                    $('#templateModal').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $('#templateModal').modal('show');
                    $('.modal-backdrop').css('z-index', '9998');
                    $('#templateModal').css('z-index', '9999');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function() {
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to load template'
                });
            }
        });
    });
    
    // Delete template
    $(document).on('click', '.delete-template', function() {
        currentDeleteId = $(this).data('id');
        let name = $(this).data('name');
        $('#deleteTemplateName').text(name);
        $('#deleteModal').modal({
            backdrop: 'static',
            keyboard: true
        });
        $('#deleteModal').modal('show');
        $('.modal-backdrop').css('z-index', '9998');
        $('#deleteModal').css('z-index', '9999');
    });
    
    $('#confirmDeleteBtn').on('click', function() {
        if (!currentDeleteId) return;
        
        Swal.fire({
            title: 'Deleting...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        $.ajax({
            url: '/admin/email-templates/delete/' + currentDeleteId,
            method: 'DELETE',
            dataType: 'json',
            success: function(response) {
                Swal.close();
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                    $('#deleteModal').modal('hide');
                    loadTemplates();
                    loadStats();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function() {
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to delete template'
                });
            }
        });
    });
    
    // Toggle active status
    $(document).on('click', '.toggle-status', function() {
        let id = $(this).data('id');
        let currentStatus = $(this).data('status');
        let newStatus = currentStatus == 1 ? 0 : 1;
        let actionText = newStatus == 1 ? 'activate' : 'deactivate';
        
        Swal.fire({
            title: `Confirm ${actionText}`,
            text: `Are you sure you want to ${actionText} this template?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: newStatus == 1 ? '#28a745' : '#dc3545',
            confirmButtonText: `Yes, ${actionText} it`
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/email-templates/toggleStatus/' + id,
                    method: 'POST',
                    data: { is_active: newStatus },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            loadTemplates();
                            loadStats();
                            Swal.fire({
                                icon: 'success',
                                title: 'Updated!',
                                text: response.message,
                                timer: 1000,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to update status'
                        });
                    }
                });
            }
        });
    });
    
    // Duplicate template
    $(document).on('click', '.duplicate-template', function() {
        let id = $(this).data('id');
        
        Swal.fire({
            title: 'Duplicating...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        $.ajax({
            url: '/admin/email-templates/duplicate/' + id,
            method: 'POST',
            dataType: 'json',
            success: function(response) {
                Swal.close();
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Duplicated!',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                    loadTemplates();
                    loadStats();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function() {
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to duplicate template'
                });
            }
        });
    });
    
    // Copy template code
    $(document).on('click', '.copy-template', function() {
        let id = $(this).data('id');
        
        Swal.fire({
            title: 'Loading...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        $.ajax({
            url: '/admin/email-templates/get/' + id,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                Swal.close();
                if (response.status === 'success') {
                    navigator.clipboard.writeText(response.data.content).then(function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Copied!',
                            text: 'Template HTML copied to clipboard',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }).catch(function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to copy to clipboard'
                        });
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function() {
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to load template'
                });
            }
        });
    });
    
    function loadTemplates() {
        $.ajax({
            url: '/admin/email-templates/list',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success' && response.data && response.data.length > 0) {
                    let html = '<div class="row">';
                    response.data.forEach(template => {
                        let categoryClass = getCategoryClass(template.category);
                        let statusBadge = template.is_active == 1 
                            ? '<span class="badge badge-success">Active</span>' 
                            : '<span class="badge badge-secondary">Inactive</span>';
                        
                        let usedCount = template.used_count || 0;
                        let createdDate = template.created_at ? new Date(template.created_at).toLocaleDateString() : 'N/A';
                        let templateName = escapeHtml(template.name);
                        let templateDesc = escapeHtml(template.description || 'No description');
                        let templateCategory = escapeHtml(template.category);
                        
                        html += `
                            <div class="col-md-4 col-lg-3">
                                <div class="template-card">
                                    <div class="template-preview">
                                        <div class="template-badge">${statusBadge}</div>
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div class="template-body">
                                        <div class="template-title" title="${templateName}">${templateName}</div>
                                        <div class="template-description" title="${templateDesc}">${templateDesc}</div>
                                        <div>
                                            <span class="category-pill ${categoryClass}">${templateCategory}</span>
                                        </div>
                                        <div class="template-meta">
                                            <span><i class="fas fa-clock"></i> ${usedCount} used</span>
                                            <span><i class="fas fa-calendar"></i> ${createdDate}</span>
                                        </div>
                                        <div class="template-actions">
                                            <button class="btn btn-sm btn-outline-primary edit-template" data-id="${template.template_id}">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-outline-success duplicate-template" data-id="${template.template_id}" title="Duplicate">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger delete-template" data-id="${template.template_id}" data-name="${templateName}" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        <div class="template-actions mt-1">
                                            <button class="btn btn-sm btn-outline-secondary toggle-status" data-id="${template.template_id}" data-status="${template.is_active}">
                                                <i class="fas ${template.is_active == 1 ? 'fa-pause' : 'fa-play'}"></i> ${template.is_active == 1 ? 'Deactivate' : 'Activate'}
                                            </button>
                                            <button class="btn btn-sm btn-outline-info copy-template" data-id="${template.template_id}" title="Copy HTML">
                                                <i class="fas fa-code"></i> Copy
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    html += '</div>';
                    $('#templatesGrid').html(html);
                } else {
                    $('#templatesGrid').html(`
                        <div class="col-12 text-center py-5">
                            <i class="fas fa-envelope-open" style="font-size: 64px; color: #dee2e6;"></i>
                            <h4 class="mt-3">No Templates Found</h4>
                            <p class="text-muted">Click "Create New Template" to get started.</p>
                        </div>
                    `);
                }
            },
            error: function() {
                $('#templatesGrid').html(`
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-exclamation-triangle" style="font-size: 64px; color: #dc3545;"></i>
                        <h4 class="mt-3">Error Loading Templates</h4>
                        <p class="text-muted">Please try refreshing the page.</p>
                    </div>
                `);
            }
        });
    }
    
    // Updated loadStats function with better error handling
    function loadStats() {
        console.log('Loading stats...');
        
        $.ajax({
            url: '/admin/email-templates/stats',
            method: 'GET',
            dataType: 'json',
            timeout: 10000, // 10 second timeout
            success: function(response) {
                console.log('Stats response:', response);
                
                if (response.status === 'success') {
                    // Update the stats cards
                    $('#totalTemplates').text(response.data.total || 0);
                    $('#activeTemplates').text(response.data.active || 0);
                    $('#totalCategories').text(response.data.categories || 0);
                    $('#mostUsed').text(response.data.most_used || 0);
                    
                    // Also update the title attributes for tooltips
                    $('#totalTemplates').attr('title', 'Total number of email templates');
                    $('#activeTemplates').attr('title', 'Number of active templates');
                    $('#totalCategories').attr('title', 'Number of unique categories');
                    $('#mostUsed').attr('title', 'Highest usage count among templates');
                } else {
                    console.error('Stats error:', response.message);
                    // Set default values on error
                    setDefaultStats();
                    // Show error in console but don't alert user
                    console.warn('Failed to load stats:', response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error loading stats:', {
                    status: status,
                    error: error,
                    responseText: xhr.responseText,
                    statusCode: xhr.status
                });
                
                // Set default values on error
                setDefaultStats();
                
                // Check if it's a 404 error (route not found)
                if (xhr.status === 404) {
                    console.error('Stats endpoint not found. Please check your routes.');
                }
            }
        });
    }

    // Function to set default stats values
    function setDefaultStats() {
        $('#totalTemplates').text('0');
        $('#activeTemplates').text('0');
        $('#totalCategories').text('0');
        $('#mostUsed').text('0');
    }

    // Also update loadTemplates to refresh stats after loading templates
    function loadTemplates() {
        console.log('Loading templates...');
        
        $.ajax({
            url: '/admin/email-templates/list',
            method: 'GET',
            dataType: 'json',
            timeout: 10000,
            success: function(response) {
                console.log('Templates response:', response);
                
                if (response.status === 'success' && response.data && response.data.length > 0) {
                    let html = '<div class="row">';
                    response.data.forEach(template => {
                        let categoryClass = getCategoryClass(template.category);
                        let statusBadge = template.is_active == 1 
                            ? '<span class="badge badge-success">Active</span>' 
                            : '<span class="badge badge-secondary">Inactive</span>';
                        
                        let usedCount = template.used_count || 0;
                        let createdDate = template.created_at ? new Date(template.created_at).toLocaleDateString() : 'N/A';
                        let templateName = escapeHtml(template.name);
                        let templateDesc = escapeHtml(template.description || 'No description');
                        let templateCategory = escapeHtml(template.category);
                        
                        html += `
                            <div class="col-md-4 col-lg-3">
                                <div class="template-card">
                                    <div class="template-preview">
                                        <div class="template-badge">${statusBadge}</div>
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div class="template-body">
                                        <div class="template-title" title="${templateName}">${templateName}</div>
                                        <div class="template-description" title="${templateDesc}">${templateDesc}</div>
                                        <div>
                                            <span class="category-pill ${categoryClass}">${templateCategory}</span>
                                        </div>
                                        <div class="template-meta">
                                            <span><i class="fas fa-clock"></i> ${usedCount} used</span>
                                            <span><i class="fas fa-calendar"></i> ${createdDate}</span>
                                        </div>
                                        <div class="template-actions">
                                            <button class="btn btn-sm btn-outline-primary edit-template" data-id="${template.template_id}">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-outline-success duplicate-template" data-id="${template.template_id}" title="Duplicate">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger delete-template" data-id="${template.template_id}" data-name="${templateName}" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        <div class="template-actions mt-1">
                                            <button class="btn btn-sm btn-outline-secondary toggle-status" data-id="${template.template_id}" data-status="${template.is_active}">
                                                <i class="fas ${template.is_active == 1 ? 'fa-pause' : 'fa-play'}"></i> ${template.is_active == 1 ? 'Deactivate' : 'Activate'}
                                            </button>
                                            <button class="btn btn-sm btn-outline-info copy-template" data-id="${template.template_id}" title="Copy HTML">
                                                <i class="fas fa-code"></i> Copy
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    html += '</div>';
                    $('#templatesGrid').html(html);
                } else {
                    $('#templatesGrid').html(`
                        <div class="col-12 text-center py-5">
                            <i class="fas fa-envelope-open" style="font-size: 64px; color: #dee2e6;"></i>
                            <h4 class="mt-3">No Templates Found</h4>
                            <p class="text-muted">Click "Create New Template" to get started.</p>
                        </div>
                    `);
                }
                
                // Reload stats after templates are loaded
                loadStats();
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error loading templates:', {
                    status: status,
                    error: error,
                    responseText: xhr.responseText,
                    statusCode: xhr.status
                });
                
                $('#templatesGrid').html(`
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-exclamation-triangle" style="font-size: 64px; color: #dc3545;"></i>
                        <h4 class="mt-3">Error Loading Templates</h4>
                        <p class="text-muted">Please try refreshing the page.</p>
                        <p class="text-muted small">Error: ${error}</p>
                    </div>
                `);
                
                // Still try to load stats even if templates fail
                loadStats();
            }
        });
    }

    // Add a manual refresh for stats
    $('#refreshTemplatesBtn').on('click', function() {
        console.log('Manual refresh triggered');
        loadTemplates();
        loadStats();
    });
    
    function resetForm() {
        $('#templateId').val('');
        $('#templateName').val('');
        $('#templateDescription').val('');
        $('#templateCategory').val('welcome');
        $('#templateSubject').val('');
        $('#templatePreheader').val('');
        $('#visualEmailContent').html(`
            <h2>Hello {name},</h2>
            <p>&nbsp;</p>
            <p>Welcome to our community! We're excited to have you with us.</p>
            <p>&nbsp;</p>
            <p>Best regards,<br>The {site_name} Team</p>
        `);
        $('#htmlEmailContent').val('');
        $('#templateActive').prop('checked', true);
        currentEditorMode = 'visual';
        $('.template-tab[data-editor="visual"]').addClass('active');
        $('.template-tab[data-editor="html"]').removeClass('active');
        $('#visualEditor').show();
        $('#htmlEditor').hide();
    }
    
    function getCategoryClass(category) {
        switch(category) {
            case 'welcome': return 'category-welcome';
            case 'promo': return 'category-promo';
            case 'update': return 'category-update';
            case 'newsletter': return 'category-newsletter';
            case 'order': return 'category-order';
            default: return 'category-default';
        }
    }
    
    function buildEmailPreview(subject, preheader, content) {
        return `
            <div style="font-family: Arial, sans-serif;">
                <div style="background: #f8f9fa; padding: 10px; border-bottom: 1px solid #dee2e6; font-size: 12px; color: #6c757d; margin-bottom: 20px;">
                    <strong>Subject:</strong> ${escapeHtml(subject)}
                    ${preheader ? `<br><strong>Preheader:</strong> ${escapeHtml(preheader)}` : ''}
                </div>
                <div style="max-width: 600px; margin: 0 auto; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; text-align: center;">
                        <h2 style="margin: 0;">Email Preview</h2>
                    </div>
                    <div style="padding: 30px;">
                        ${content}
                    </div>
                    <div style="background: #f8f9fa; padding: 20px; text-align: center; font-size: 12px; color: #6c757d;">
                        <p>This is a preview of your email template.</p>
                        <p>&copy; ${new Date().getFullYear()} Your Company</p>
                    </div>
                </div>
            </div>
        `;
    }
    
    function initEditor() {
        let editor = document.getElementById('visualEmailContent');
        if (!editor) return;
        
        document.querySelectorAll('[data-command]').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                let command = this.dataset.command;
                
                if (command === 'createLink') {
                    let url = prompt('Enter URL:', 'https://');
                    if (url) {
                        document.execCommand(command, false, url);
                    }
                } else if (command === 'insertImage') {
                    let url = prompt('Enter image URL:', 'https://');
                    if (url) {
                        document.execCommand(command, false, url);
                    }
                } else {
                    document.execCommand(command, false, null);
                }
                editor.focus();
            });
        });
        
        // Ensure editor has focus when clicked
        editor.addEventListener('click', function() {
            editor.focus();
        });
    }
    
    function escapeHtml(text) {
        if (!text) return '';
        let div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
});