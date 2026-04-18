// File: assets/js/admin/send-newsletter.js
// Send Newsletter JavaScript

$(document).ready(function () {
    let selectedRecipients = [];
    let currentCampaignId = null;
    
    // Initialize rich text editor
    initEditor();
    
    // Load initial data
    loadStats();
    loadSubscribers();
    loadCampaignHistory();
    
    // Template selection
    $('.template-card').on('click', function() {
        $('.template-card').removeClass('active');
        $(this).addClass('active');
        let template = $(this).data('template');
        loadTemplate(template);
    });
    
    // Recipient group change
    $('#recipientGroup').on('change', function() {
        let value = $(this).val();
        if (value === 'custom') {
            $('#customRecipientList').show();
            loadSubscribers();
        } else {
            $('#customRecipientList').hide();
            updateRecipientCount();
        }
    });
    
    // Select/Deselect all subscribers
    $('#selectAllSubscribers').on('click', function() {
        $('.subscriber-checkbox').prop('checked', true).trigger('change');
    });
    
    $('#deselectAllSubscribers').on('click', function() {
        $('.subscriber-checkbox').prop('checked', false).trigger('change');
    });
    
    // Schedule options
    $('.schedule-option').on('click', function() {
        $('.schedule-option').removeClass('active');
        $(this).addClass('active');
        let scheduleType = $(this).data('schedule');
        $(`input[name="scheduleType"][value="${scheduleType}"]`).prop('checked', true);
        
        if (scheduleType === 'later') {
            $('#scheduleDateTime').show();
        } else {
            $('#scheduleDateTime').hide();
        }
    });
    
    $('#scheduleLater').on('change', function() {
        if ($(this).is(':checked')) {
            $('#scheduleDateTime').show();
        }
    });
    
    $('#sendNow, #saveDraft').on('change', function() {
        $('#scheduleDateTime').hide();
    });
    
    // Preview newsletter
    $('#previewBtn').on('click', function() {
        let subject = $('#newsletterSubject').val();
        let content = getEditorContent();
        let preheader = $('#preheaderText').val();
        
        if (!subject) {
            Swal.fire({
                icon: 'warning',
                title: 'Missing Subject',
                text: 'Please enter a newsletter subject'
            });
            return;
        }
        
        let previewHtml = `
            <div class="email-preview">
                <div class="card">
                    <div class="card-header bg-light">
                        <strong>Subject:</strong> ${escapeHtml(subject)}
                        ${preheader ? `<br><small class="text-muted">Preheader: ${escapeHtml(preheader)}</small>` : ''}
                    </div>
                    <div class="card-body">
                        ${content}
                    </div>
                </div>
            </div>
        `;
        
        $('#previewContent').html(previewHtml);
        $('#previewModal').modal('show');
    });
    
    // Send newsletter button
    $('#sendNewsletterBtn').on('click', function() {
        let subject = $('#newsletterSubject').val();
        let content = getEditorContent();
        
        if (!subject) {
            Swal.fire({
                icon: 'warning',
                title: 'Missing Subject',
                text: 'Please enter a newsletter subject'
            });
            return;
        }
        
        if (!content || content === '<p><br></p>' || content.trim() === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Missing Content',
                text: 'Please enter newsletter content'
            });
            return;
        }
        
        let recipientCount = getSelectedRecipientCount();
        if (recipientCount === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No Recipients',
                text: 'Please select at least one recipient'
            });
            return;
        }
        
        $('#confirmRecipientCount').text(recipientCount);
        $('#sendConfirmModal').modal('show');
    });
    
    // Confirm send
    $('#confirmSendBtn').on('click', function() {
        let scheduleType = $('input[name="scheduleType"]:checked').val();
        let scheduledDateTime = $('#scheduledDateTime').val();
        
        if (scheduleType === 'later' && !scheduledDateTime) {
            Swal.fire({
                icon: 'warning',
                title: 'Missing Date/Time',
                text: 'Please select a date and time to schedule'
            });
            return;
        }
        
        let formData = new FormData();
        formData.append('subject', $('#newsletterSubject').val());
        formData.append('preheader', $('#preheaderText').val());
        formData.append('content', getEditorContent());
        formData.append('from_email', $('#sendFrom').val());
        formData.append('reply_to', $('#replyTo').val());
        formData.append('recipient_group', $('#recipientGroup').val());
        formData.append('schedule_type', scheduleType);
        formData.append('scheduled_datetime', scheduledDateTime);
        
        // Add selected recipients for custom group
        if ($('#recipientGroup').val() === 'custom') {
            let recipients = [];
            $('.subscriber-checkbox:checked').each(function() {
                recipients.push($(this).val());
            });
            formData.append('recipients', JSON.stringify(recipients));
        }
        
        let featureImage = $('#featureImage')[0].files[0];
        if (featureImage) {
            formData.append('feature_image', featureImage);
        }
        
        $('#sendProgress').show();
        $('#confirmSendBtn').prop('disabled', true);
        
        $.ajax({
            url: '/admin/send-newsletter/send',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            xhr: function() {
                let xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        let percentComplete = (evt.loaded / evt.total) * 100;
                        $('.progress-bar').css('width', percentComplete + '%');
                    }
                }, false);
                return xhr;
            },
            success: function(response) {
                if (response.status === 'success') {
                    $('#sendConfirmModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        confirmButtonColor: '#3085d6'
                    }).then(() => {
                        resetForm();
                        loadCampaignHistory();
                        loadStats();
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
                    text: 'Something went wrong. Please try again.'
                });
            },
            complete: function() {
                $('#sendProgress').hide();
                $('#confirmSendBtn').prop('disabled', false);
                $('.progress-bar').css('width', '0%');
            }
        });
    });
    
    // Save draft
    $('#saveDraftBtn').on('click', function() {
        let subject = $('#newsletterSubject').val();
        
        if (!subject) {
            Swal.fire({
                icon: 'warning',
                title: 'Missing Subject',
                text: 'Please enter a newsletter subject'
            });
            return;
        }
        
        let formData = new FormData();
        formData.append('subject', $('#newsletterSubject').val());
        formData.append('preheader', $('#preheaderText').val());
        formData.append('content', getEditorContent());
        formData.append('from_email', $('#sendFrom').val());
        formData.append('reply_to', $('#replyTo').val());
        formData.append('recipient_group', $('#recipientGroup').val());
        
        if ($('#recipientGroup').val() === 'custom') {
            let recipients = [];
            $('.subscriber-checkbox:checked').each(function() {
                recipients.push($(this).val());
            });
            formData.append('recipients', JSON.stringify(recipients));
        }
        
        let featureImage = $('#featureImage')[0].files[0];
        if (featureImage) {
            formData.append('feature_image', featureImage);
        }
        
        Swal.fire({
            title: 'Saving Draft...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        $.ajax({
            url: '/admin/send-newsletter/saveDraft',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.close();
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Draft Saved!',
                        text: response.message,
                        confirmButtonColor: '#3085d6'
                    });
                    loadCampaignHistory();
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
                    text: 'Something went wrong. Please try again.'
                });
            }
        });
    });
    
    // Cancel/delete campaign
    $(document).on('click', '.cancel-campaign', function() {
        let id = $(this).data('id');
        
        Swal.fire({
            title: 'Cancel Campaign',
            text: 'Are you sure you want to cancel this scheduled campaign?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, cancel it'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/send-newsletter/cancel/' + id,
                    method: 'POST',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Cancelled!',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                            loadCampaignHistory();
                            loadStats();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message
                            });
                        }
                    }
                });
            }
        });
    });
    
    // Delete campaign
    $(document).on('click', '.delete-campaign', function() {
        let id = $(this).data('id');
        
        Swal.fire({
            title: 'Delete Campaign',
            text: 'Are you sure you want to delete this campaign? This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/send-newsletter/delete/' + id,
                    method: 'DELETE',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                            loadCampaignHistory();
                            loadStats();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message
                            });
                        }
                    }
                });
            }
        });
    });
    
    // Edit draft
    $(document).on('click', '.edit-campaign', function() {
        let id = $(this).data('id');
        
        $.ajax({
            url: '/admin/send-newsletter/getCampaign/' + id,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    let data = response.data;
                    $('#newsletterSubject').val(data.subject);
                    $('#preheaderText').val(data.preheader);
                    setEditorContent(data.content);
                    $('#sendFrom').val(data.from_email);
                    $('#replyTo').val(data.reply_to);
                    $('#recipientGroup').val(data.recipient_group).trigger('change');
                    
                    if (data.recipient_group === 'custom' && data.recipients) {
                        let recipients = JSON.parse(data.recipients);
                        setTimeout(() => {
                            $('.subscriber-checkbox').each(function() {
                                if (recipients.includes($(this).val())) {
                                    $(this).prop('checked', true);
                                }
                            });
                            updateRecipientCount();
                        }, 500);
                    }
                    
                    currentCampaignId = id;
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Loaded',
                        text: 'Draft loaded successfully',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    
                    $('html, body').animate({
                        scrollTop: 0
                    }, 500);
                }
            }
        });
    });
    
    function initEditor() {
        let editor = document.getElementById('emailContent');
        
        // Toolbar commands
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
    }
    
    function getEditorContent() {
        let content = $('#emailContent').html();
        $('#emailContentHidden').val(content);
        return content;
    }
    
    function setEditorContent(content) {
        $('#emailContent').html(content);
        $('#emailContentHidden').val(content);
    }
    
    function loadTemplate(template) {
        let content = '';
        switch(template) {
            case 'welcome':
                content = `
                    <h2>Welcome to Our Community! 🎉</h2>
                    <p>Dear [Subscriber Name],</p>
                    <p>Thank you for subscribing to our newsletter! We're excited to have you on board.</p>
                    <p>Here's what you can expect from us:</p>
                    <ul>
                        <li>Exclusive offers and discounts</li>
                        <li>Latest product updates</li>
                        <li>Helpful tips and tutorials</li>
                        <li>Community news and events</li>
                    </ul>
                    <p>To get started, check out our latest collection:</p>
                    <p>[Insert featured products here]</p>
                    <p>Best regards,<br>The Team</p>
                `;
                break;
            case 'promo':
                content = `
                    <h2>Special Offer Just for You! 🎁</h2>
                    <p>Hello [Subscriber Name],</p>
                    <p>We're excited to announce our biggest sale of the season!</p>
                    <div style="background: #f8f9fa; padding: 20px; text-align: center; margin: 20px 0;">
                        <h3 style="color: #667eea;">UP TO 50% OFF</h3>
                        <p>Use code: <strong>NEWSLETTER50</strong></p>
                        <p style="font-size: 12px;">Valid for a limited time only</p>
                    </div>
                    <p>Shop now and save on your favorite items:</p>
                    <p>[Insert product grid here]</p>
                    <p>Don't miss out on these amazing deals!</p>
                    <p>Happy shopping!<br>The Team</p>
                `;
                break;
            case 'update':
                content = `
                    <h2>Exciting News & Updates 📢</h2>
                    <p>Dear [Subscriber Name],</p>
                    <p>We have some exciting news to share with you!</p>
                    <h3>What's New:</h3>
                    <ul>
                        <li>New website features</li>
                        <li>Improved user experience</li>
                        <li>Expanded product range</li>
                    </ul>
                    <p>[Insert announcement details here]</p>
                    <p>Thank you for being part of our journey!</p>
                    <p>Best regards,<br>The Team</p>
                `;
                break;
            case 'digest':
                content = `
                    <h2>Weekly Digest 📰</h2>
                    <p>Hello [Subscriber Name],</p>
                    <p>Here's what happened this week:</p>
                    <h3>📝 Latest Articles</h3>
                    <ul>
                        <li><a href="#">Article Title 1</a> - Brief description</li>
                        <li><a href="#">Article Title 2</a> - Brief description</li>
                        <li><a href="#">Article Title 3</a> - Brief description</li>
                    </ul>
                    <h3>🔥 Popular This Week</h3>
                    <p>[Insert popular content here]</p>
                    <h3>💡 Tip of the Week</h3>
                    <p>[Insert helpful tip here]</p>
                    <p>Stay tuned for more next week!</p>
                    <p>The Team</p>
                `;
                break;
        }
        setEditorContent(content);
    }
    
    function loadStats() {
        $.ajax({
            url: '/admin/send-newsletter/stats',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    $('#totalSubscribers').text(response.data.total_subscribers || 0);
                    $('#totalSent').text(response.data.total_sent || 0);
                    $('#scheduledCount').text(response.data.scheduled_count || 0);
                    $('#avgOpenRate').text(response.data.avg_open_rate || '0%');
                }
            }
        });
    }
    
    function loadSubscribers() {
        $.ajax({
            url: '/admin/send-newsletter/subscribers',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success' && response.data.length > 0) {
                    let html = '';
                    response.data.forEach(sub => {
                        html += `
                            <div class="recipient-item">
                                <input type="checkbox" class="subscriber-checkbox" value="${sub.subscriber_id}" data-email="${sub.email}">
                                <span class="recipient-email">${escapeHtml(sub.email)}</span>
                                ${sub.name ? `<span class="recipient-name">(${escapeHtml(sub.name)})</span>` : ''}
                            </div>
                        `;
                    });
                    $('#subscriberList').html(html);
                    
                    $('.subscriber-checkbox').on('change', function() {
                        updateRecipientCount();
                    });
                } else {
                    $('#subscriberList').html('<div class="text-center py-3 text-muted">No subscribers found</div>');
                }
                updateRecipientCount();
            }
        });
    }
    
    function updateRecipientCount() {
        let count = 0;
        let group = $('#recipientGroup').val();
        
        if (group === 'custom') {
            count = $('.subscriber-checkbox:checked').length;
        } else {
            // For predefined groups, we'll get count from server
            $.ajax({
                url: '/admin/send-newsletter/recipient-count',
                method: 'POST',
                data: { group: group },
                dataType: 'json',
                async: false,
                success: function(response) {
                    count = response.count || 0;
                }
            });
        }
        
        $('#recipientCount').text(count);
    }
    
    function getSelectedRecipientCount() {
        let group = $('#recipientGroup').val();
        if (group === 'custom') {
            return $('.subscriber-checkbox:checked').length;
        } else {
            let count = 0;
            $.ajax({
                url: '/admin/send-newsletter/recipient-count',
                method: 'POST',
                data: { group: group },
                dataType: 'json',
                async: false,
                success: function(response) {
                    count = response.count || 0;
                }
            });
            return count;
        }
    }
    
    function loadCampaignHistory() {
        $.ajax({
            url: '/admin/send-newsletter/campaigns',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success' && response.data.length > 0) {
                    let html = '';
                    response.data.forEach(campaign => {
                        let statusClass = '';
                        switch(campaign.status) {
                            case 'sent': statusClass = 'status-sent'; break;
                            case 'scheduled': statusClass = 'status-scheduled'; break;
                            case 'draft': statusClass = 'status-draft'; break;
                            case 'failed': statusClass = 'status-failed'; break;
                        }
                        
                        let actions = '';
                        if (campaign.status === 'draft') {
                            actions = `
                                <button class="btn btn-sm btn-info edit-campaign" data-id="${campaign.campaign_id}">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-sm btn-danger delete-campaign" data-id="${campaign.campaign_id}">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            `;
                        } else if (campaign.status === 'scheduled') {
                            actions = `
                                <button class="btn btn-sm btn-warning cancel-campaign" data-id="${campaign.campaign_id}">
                                    <i class="fas fa-ban"></i> Cancel
                                </button>
                            `;
                        } else {
                            actions = `<span class="text-muted">-</span>`;
                        }
                        
                        html += `
                            <tr>
                                <td>#${campaign.campaign_id}</td>
                                <td>${escapeHtml(campaign.subject)}</td>
                                <td>${campaign.recipient_count || 0}</td>
                                <td>${campaign.sent_at || campaign.scheduled_datetime || '-'}</td>
                                <td><span class="campaign-status ${statusClass}">${campaign.status}</span></td>
                                <td>${campaign.open_rate || '0%'}</td>
                                <td>${actions}</td>
                            </tr>
                        `;
                    });
                    $('#campaignHistoryBody').html(html);
                } else {
                    $('#campaignHistoryBody').html('<tr><td colspan="7" class="text-center">No campaigns found</td></tr>');
                }
            }
        });
    }
    
    function resetForm() {
        $('#newsletterSubject').val('');
        $('#preheaderText').val('');
        setEditorContent('<p>Hello [Subscriber Name],</p><p>&nbsp;</p><p>We hope you\'re having a great day!</p><p>&nbsp;</p><p>Best regards,<br>The Team</p>');
        $('#featureImage').val('');
        $('#recipientGroup').val('all').trigger('change');
        $('input[name="scheduleType"][value="now"]').prop('checked', true);
        $('#scheduleDateTime').val('').hide();
        $('.template-card').removeClass('active');
        currentCampaignId = null;
    }
    
    function escapeHtml(text) {
        if (!text) return '';
        let div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
});