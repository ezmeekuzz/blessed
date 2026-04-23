<?= $this->include('templates/header'); ?>

<style>
/* Professional Profile CSS */
.profile-section {
    background: #f0f2f5;
    min-height: calc(100vh - 200px);
    padding: 30px 0;
}

/* Profile Header Card */
.profile-header-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    margin-bottom: 24px;
}

.profile-header-content {
    padding: 32px;
    background: linear-gradient(135deg, #3D204E 0%, #5a2d73 100%);
}

.profile-avatar-large {
    width: 120px;
    height: 120px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.profile-avatar-large i {
    font-size: 60px;
    color: #3D204E;
}

.profile-name-large {
    text-align: center;
    color: white;
}

.profile-name-large h1 {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 8px;
}

.profile-name-large p {
    font-size: 14px;
    opacity: 0.9;
    margin-bottom: 16px;
}

.badge-container {
    display: flex;
    gap: 10px;
    justify-content: center;
    flex-wrap: wrap;
}

.badge-custom {
    padding: 6px 14px;
    border-radius: 30px;
    font-size: 12px;
    font-weight: 600;
}

/* Stats Row */
.stats-row {
    background: white;
    border-radius: 16px;
    padding: 20px;
    margin-bottom: 24px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
}

.stat-card {
    text-align: center;
    padding: 12px;
    border-right: 1px solid #e4e6eb;
}

.stat-card:last-child {
    border-right: none;
}

.stat-icon {
    font-size: 28px;
    color: #3D204E;
    margin-bottom: 8px;
}

.stat-value {
    font-size: 22px;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 4px;
}

.stat-label {
    font-size: 13px;
    color: #65676b;
}

/* Profile Cards */
.profile-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    overflow: hidden;
    margin-bottom: 24px;
}

.card-header-custom {
    padding: 20px 24px;
    border-bottom: 1px solid #e4e6eb;
    background: white;
}

.card-header-custom h5 {
    margin: 0;
    font-weight: 600;
    color: #1a1a2e;
}

.card-body-custom {
    padding: 24px;
}

/* Info Row */
.info-row {
    display: flex;
    padding: 14px 0;
    border-bottom: 1px solid #f0f2f5;
}

.info-row:last-child {
    border-bottom: none;
}

.info-label {
    width: 140px;
    font-size: 14px;
    color: #65676b;
}

.info-value {
    flex: 1;
    font-size: 15px;
    font-weight: 500;
    color: #1a1a2e;
}

/* Detail Items */
.detail-item {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 16px;
    transition: all 0.2s ease;
}

.detail-item:hover {
    background: #f0e9e2;
}

.detail-label {
    font-size: 12px;
    color: #65676b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 4px;
}

.detail-value {
    font-size: 16px;
    font-weight: 600;
    color: #1a1a2e;
    margin-bottom: 0;
}

/* Buttons */
.btn-primary-custom {
    background: #3D204E;
    color: white;
    border: none;
    padding: 10px 24px;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.2s ease;
}

.btn-primary-custom:hover {
    background: #5a2d73;
    transform: translateY(-1px);
}

.btn-outline-custom {
    background: transparent;
    color: #3D204E;
    border: 1px solid #3D204E;
    padding: 10px 24px;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.2s ease;
}

.btn-outline-custom:hover {
    background: #3D204E;
    color: white;
}

/* Form Controls */
.form-control-custom {
    border-radius: 10px;
    border: 1px solid #e4e6eb;
    padding: 12px 16px;
    transition: all 0.2s ease;
}

.form-control-custom:focus {
    border-color: #3D204E;
    box-shadow: 0 0 0 3px rgba(61, 32, 78, 0.1);
}

/* Tabs */
.profile-tabs {
    background: white;
    border-radius: 16px;
    margin-bottom: 24px;
    overflow: hidden;
}

.tab-btn {
    flex: 1;
    text-align: center;
    padding: 16px;
    background: white;
    border: none;
    font-weight: 600;
    color: #65676b;
    transition: all 0.2s ease;
    position: relative;
}

.tab-btn:hover {
    color: #3D204E;
    background: #f8f9fa;
}

.tab-btn.active {
    color: #3D204E;
}

.tab-btn.active::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: #3D204E;
}

/* Progress Bar */
.progress {
    background-color: #e9ecef;
    border-radius: 5px;
    overflow: hidden;
    height: 5px;
}

.progress-bar {
    transition: width 0.3s ease;
}

/* Responsive */
@media (max-width: 768px) {
    .profile-header-content {
        padding: 20px;
    }
    
    .profile-avatar-large {
        width: 80px;
        height: 80px;
    }
    
    .profile-avatar-large i {
        font-size: 40px;
    }
    
    .profile-name-large h1 {
        font-size: 22px;
    }
    
    .stats-row {
        padding: 12px;
    }
    
    .stat-value {
        font-size: 18px;
    }
    
    .stat-label {
        font-size: 11px;
    }
    
    .info-row {
        flex-direction: column;
    }
    
    .info-label {
        width: 100%;
        margin-bottom: 5px;
    }
    
    .card-header-custom {
        padding: 16px 20px;
    }
    
    .card-body-custom {
        padding: 16px 20px;
    }
    
    .tab-btn {
        padding: 12px;
        font-size: 13px;
    }
}
</style>

<section class="profile-section">
    <div class="container">
        <!-- Profile Header Card -->
        <div class="profile-header-card">
            <div class="profile-header-content">
                <div class="profile-avatar-large">
                    <i class="fas fa-user-circle"></i>
                </div>
                <div class="profile-name-large">
                    <h1><?= esc($user['firstname'] . ' ' . $user['lastname']) ?></h1>
                    <p><?= esc($user['emailaddress']) ?></p>
                    <div class="badge-container">
                        <?php
                        $status = $user['status'];
                        if ($status == 1 || $status == 'active') {
                            $statusText = 'Active';
                            $statusColor = '#28a745';
                            $statusIcon = 'fa-check-circle';
                        } elseif ($status == 0 || $status == 'pending') {
                            $statusText = 'Pending';
                            $statusColor = '#ffc107';
                            $statusIcon = 'fa-clock';
                        } else {
                            $statusText = ucfirst($status);
                            $statusColor = '#6c757d';
                            $statusIcon = 'fa-user';
                        }
                        ?>
                        <span class="badge-custom" style="background: <?= $statusColor ?>20; color: <?= $statusColor ?>; border: 1px solid <?= $statusColor ?>40;">
                            <i class="fas <?= $statusIcon ?> me-1"></i> <?= $statusText ?> Account
                        </span>
                        <?php if ($user['email_verified'] == 1): ?>
                            <span class="badge-custom" style="background: #28a74520; color: #28a745; border: 1px solid #28a74540;">
                                <i class="fas fa-check-circle me-1"></i> Verified Email
                            </span>
                        <?php else: ?>
                            <span class="badge-custom" style="background: #ffc10720; color: #856404; border: 1px solid #ffc10740;">
                                <i class="fas fa-exclamation-triangle me-1"></i> Unverified Email
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Row -->
        <div class="stats-row">
            <div class="row">
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="stat-value"><?= date('Y', strtotime($user['created_at'])) ?></div>
                        <div class="stat-label">Member Since</div>
                        <small class="text-muted"><?= date('F j, Y', strtotime($user['created_at'])) ?></small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-tag"></i>
                        </div>
                        <div class="stat-value"><?= esc($user['usertype']) ?></div>
                        <div class="stat-label">Account Type</div>
                        <small class="text-muted">Regular Member</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="stat-value"><?= $user['email_verified'] == 1 ? 'Verified' : 'Pending' ?></div>
                        <div class="stat-label">Email Status</div>
                        <small class="text-muted"><?= $user['email_verified'] == 1 ? 'Confirmed' : 'Awaiting verification' ?></small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="profile-tabs">
            <div class="d-flex">
                <button class="tab-btn active" data-tab="profile">Profile Information</button>
                <button class="tab-btn" data-tab="security">Security</button>
                <button class="tab-btn" data-tab="activity">Activity</button>
            </div>
        </div>

        <!-- Profile Tab Content -->
        <div id="profileTab" class="tab-content active">
            <div class="profile-card">
                <div class="card-header-custom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5><i class="fas fa-user-circle me-2" style="color: #3D204E;"></i> Personal Information</h5>
                        <button class="btn btn-sm btn-outline-custom" id="editProfileBtn">
                            <i class="fas fa-edit me-1"></i> Edit
                        </button>
                    </div>
                </div>
                <div class="card-body-custom">
                    <!-- View Mode -->
                    <div id="profileViewMode">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <div class="detail-label">First Name</div>
                                    <div class="detail-value"><?= esc($user['firstname']) ?></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <div class="detail-label">Last Name</div>
                                    <div class="detail-value"><?= esc($user['lastname']) ?></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="detail-item">
                                    <div class="detail-label">Email Address</div>
                                    <div class="detail-value"><?= esc($user['emailaddress']) ?></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <div class="detail-label">Account Type</div>
                                    <div class="detail-value"><?= esc($user['usertype']) ?></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <div class="detail-label">Member Since</div>
                                    <div class="detail-value"><?= date('F j, Y', strtotime($user['created_at'])) ?></div>
                                </div>
                            </div>
                        </div>
                        
                        <?php if ($user['email_verified'] == 0): ?>
                        <div class="mt-4 pt-3 border-top">
                            <button class="btn btn-link p-0" id="resendVerificationBtn" style="color: #3D204E;">
                                <i class="fas fa-paper-plane me-2"></i> Resend Verification Email
                            </button>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Edit Mode -->
                    <div id="profileEditMode" style="display: none;">
                        <form id="profileEditForm">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">First Name</label>
                                    <input type="text" class="form-control form-control-custom" id="firstname" name="firstname" value="<?= esc($user['firstname']) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Last Name</label>
                                    <input type="text" class="form-control form-control-custom" id="lastname" name="lastname" value="<?= esc($user['lastname']) ?>" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Email Address</label>
                                    <input type="email" class="form-control form-control-custom" id="emailaddress" name="emailaddress" value="<?= esc($user['emailaddress']) ?>" required>
                                </div>
                                <div class="col-12 mt-3">
                                    <button type="submit" class="btn btn-primary-custom">
                                        <i class="fas fa-save me-2"></i> Save Changes
                                    </button>
                                    <button type="button" class="btn btn-outline-custom ms-2" id="cancelEditBtn">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Security Tab Content -->
        <div id="securityTab" class="tab-content" style="display: none;">
            <div class="profile-card">
                <div class="card-header-custom">
                    <h5><i class="fas fa-lock me-2" style="color: #3D204E;"></i> Change Password</h5>
                </div>
                <div class="card-body-custom">
                    <form id="passwordChangeForm">
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Current Password</label>
                            <input type="password" class="form-control form-control-custom" id="current_password" name="current_password" placeholder="Enter your current password" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">New Password</label>
                            <input type="password" class="form-control form-control-custom" id="new_password" name="new_password" placeholder="Enter new password" required>
                            <div id="newPasswordStrength" class="mt-2"></div>
                            <small class="text-muted">Minimum 8 characters with at least one number and one letter</small>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Confirm New Password</label>
                            <input type="password" class="form-control form-control-custom" id="confirm_password" name="confirm_password" placeholder="Confirm new password" required>
                            <div id="confirmPasswordMatch" class="mt-2"></div>
                        </div>
                        <button type="submit" class="btn btn-primary-custom">
                            <i class="fas fa-key me-2"></i> Update Password
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Activity Tab Content -->
        <div id="activityTab" class="tab-content" style="display: none;">
            <div class="profile-card">
                <div class="card-header-custom">
                    <h5><i class="fas fa-chart-line me-2" style="color: #3D204E;"></i> Account Activity</h5>
                </div>
                <div class="card-body-custom text-center py-5">
                    <i class="fas fa-chart-simple fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">No Activity Yet</h5>
                    <p class="text-secondary">Your account activity will appear here as you use the platform.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->include('templates/footer'); ?>

<script>
$(document).ready(function() {
    // Tab switching
    $('.tab-btn').on('click', function() {
        const tab = $(this).data('tab');
        
        $('.tab-btn').removeClass('active');
        $(this).addClass('active');
        
        $('.tab-content').hide();
        
        if (tab === 'profile') $('#profileTab').show();
        else if (tab === 'security') $('#securityTab').show();
        else if (tab === 'activity') $('#activityTab').show();
    });
    
    // Edit Profile
    $('#editProfileBtn').on('click', function() {
        $('#profileViewMode').hide();
        $('#profileEditMode').show();
    });
    
    $('#cancelEditBtn').on('click', function() {
        $('#profileEditMode').hide();
        $('#profileViewMode').show();
        $('#profileEditForm')[0].reset();
        $('#firstname').val('<?= esc($user['firstname']) ?>');
        $('#lastname').val('<?= esc($user['lastname']) ?>');
        $('#emailaddress').val('<?= esc($user['emailaddress']) ?>');
    });
    
    // Profile Edit Form Submit
    $('#profileEditForm').on('submit', function(e) {
        e.preventDefault();
        
        const firstname = $('#firstname').val().trim();
        const lastname = $('#lastname').val().trim();
        const emailaddress = $('#emailaddress').val().trim();
        
        if (!firstname || !lastname || !emailaddress) {
            showNotification('Please fill in all fields.', 'error');
            return;
        }
        
        const emailRegex = /^[^\s@]+@([^\s@]+\.)+[^\s@]+$/;
        if (!emailRegex.test(emailaddress)) {
            showNotification('Please enter a valid email address.', 'error');
            return;
        }
        
        const $submitBtn = $(this).find('button[type="submit"]');
        $submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
        
        $.ajax({
            url: '/profile/update',
            method: 'POST',
            data: { firstname: firstname, lastname: lastname, emailaddress: emailaddress },
            dataType: 'json',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function(response) {
                if (response.success) {
                    showNotification(response.message, 'success');
                    $('.profile-name-large h1').text(firstname + ' ' + lastname);
                    $('.profile-name-large p').text(emailaddress);
                    $('#profileViewMode .detail-item:eq(0) .detail-value').text(firstname);
                    $('#profileViewMode .detail-item:eq(1) .detail-value').text(lastname);
                    $('#profileViewMode .detail-item:eq(2) .detail-value').text(emailaddress);
                    $('#profileEditMode').hide();
                    $('#profileViewMode').show();
                } else {
                    showNotification(response.message, 'error');
                }
            },
            error: function() { showNotification('An error occurred. Please try again.', 'error'); },
            complete: function() { $submitBtn.prop('disabled', false).html('<i class="fas fa-save me-2"></i> Save Changes'); }
        });
    });
    
    // Password strength indicator
    $('#new_password').on('keyup', function() {
        const password = $(this).val();
        const strengthBar = $('#newPasswordStrength');
        
        if (password.length === 0) { strengthBar.html(''); return; }
        
        let strength = 0;
        let strengthText = '', strengthColor = '';
        
        if (password.length >= 8) strength++;
        if (password.length >= 12) strength++;
        if (/\d/.test(password)) strength++;
        if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
        if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) strength++;
        
        if (strength <= 2) { strengthText = 'Weak'; strengthColor = '#dc3545'; }
        else if (strength <= 4) { strengthText = 'Medium'; strengthColor = '#ffc107'; }
        else { strengthText = 'Strong'; strengthColor = '#28a745'; }
        
        const width = (strength / 5) * 100;
        strengthBar.html(`
            <div class="progress"><div class="progress-bar" style="width: ${width}%; background-color: ${strengthColor};"></div></div>
            <small style="color: ${strengthColor};">Password Strength: ${strengthText}</small>
        `);
    });
    
    // Confirm password match
    $('#confirm_password').on('keyup', function() {
        const newPassword = $('#new_password').val();
        const confirmPassword = $(this).val();
        const matchDiv = $('#confirmPasswordMatch');
        
        if (confirmPassword.length === 0) { matchDiv.html(''); return; }
        
        if (newPassword === confirmPassword) {
            matchDiv.html('<small style="color: #28a745;"><i class="fas fa-check-circle"></i> Passwords match</small>');
        } else {
            matchDiv.html('<small style="color: #dc3545;"><i class="fas fa-times-circle"></i> Passwords do not match</small>');
        }
    });
    
    // Password Change Form Submit
    $('#passwordChangeForm').on('submit', function(e) {
        e.preventDefault();
        
        const currentPassword = $('#current_password').val();
        const newPassword = $('#new_password').val();
        const confirmPassword = $('#confirm_password').val();
        
        if (!currentPassword) { showNotification('Please enter your current password.', 'error'); return; }
        if (!newPassword) { showNotification('Please enter a new password.', 'error'); return; }
        if (newPassword.length < 8) { showNotification('New password must be at least 8 characters.', 'error'); return; }
        if (newPassword !== confirmPassword) { showNotification('New passwords do not match.', 'error'); return; }
        
        const $submitBtn = $(this).find('button[type="submit"]');
        $submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Changing...');
        
        $.ajax({
            url: '/profile/change-password',
            method: 'POST',
            data: { current_password: currentPassword, new_password: newPassword, confirm_password: confirmPassword },
            dataType: 'json',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function(response) {
                if (response.success) {
                    showNotification(response.message, 'success');
                    $('#passwordChangeForm')[0].reset();
                    $('#newPasswordStrength').html('');
                    $('#confirmPasswordMatch').html('');
                } else {
                    showNotification(response.message, 'error');
                }
            },
            error: function() { showNotification('An error occurred. Please try again.', 'error'); },
            complete: function() { $submitBtn.prop('disabled', false).html('<i class="fas fa-key me-2"></i> Update Password'); }
        });
    });
    
    // Resend verification email
    $('#resendVerificationBtn').on('click', function() {
        const $btn = $(this);
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Sending...');
        
        $.ajax({
            url: '/resend-verification',
            method: 'POST',
            data: { email: '<?= esc($user['emailaddress']) ?>' },
            dataType: 'json',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function(response) {
                showNotification(response.message, response.success ? 'success' : 'error');
            },
            error: function() { showNotification('An error occurred. Please try again.', 'error'); },
            complete: function() { $btn.prop('disabled', false).html('Resend Verification Email'); }
        });
    });
    
    // Notification function
    function showNotification(message, type) {
        $('.notification-toast').remove();
        const toast = $('<div class="notification-toast" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999; min-width: 250px; padding: 12px 20px; border-radius: 10px; color: white; font-weight: 500; display: none;"></div>');
        const bgColor = type === 'success' ? '#28a745' : type === 'info' ? '#17a2b8' : '#dc3545';
        toast.css('background', bgColor);
        toast.text(message);
        $('body').append(toast);
        toast.fadeIn(300);
        setTimeout(() => toast.fadeOut(300, () => toast.remove()), 5000);
    }
});
</script>