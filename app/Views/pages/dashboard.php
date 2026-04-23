<?= $this->include('templates/header'); ?>

<style>
/* Dashboard CSS */
.dashboard-section {
    background: #f0f2f5;
    min-height: calc(100vh - 200px);
    padding: 30px 0;
}

/* Welcome Banner */
.welcome-banner {
    background: linear-gradient(135deg, #3D204E 0%, #5a2d73 100%);
    border-radius: 20px;
    padding: 30px;
    margin-bottom: 30px;
    color: white;
}

.welcome-title {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 8px;
}

.welcome-subtitle {
    font-size: 14px;
    opacity: 0.9;
}

/* Stats Cards */
.stat-card {
    background: white;
    border-radius: 16px;
    padding: 20px;
    margin-bottom: 24px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    transition: all 0.2s ease;
}

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}

.stat-icon-wrapper {
    width: 50px;
    height: 50px;
    background: #f0e9f5;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 16px;
}

.stat-icon-wrapper i {
    font-size: 24px;
    color: #3D204E;
}

.stat-value {
    font-size: 28px;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 4px;
}

.stat-label {
    font-size: 13px;
    color: #65676b;
}

/* Section Titles */
.section-title {
    font-size: 18px;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 20px;
    padding-bottom: 12px;
    border-bottom: 2px solid #e4e6eb;
}

.section-title i {
    color: #3D204E;
    margin-right: 10px;
}

/* Recent Orders Card */
.recent-orders-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    margin-bottom: 24px;
}

.order-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 20px;
    border-bottom: 1px solid #f0f2f5;
    transition: all 0.2s ease;
}

.order-item:hover {
    background: #f8f9fa;
}

.order-info {
    flex: 1;
}

.order-id {
    font-weight: 600;
    color: #1a1a2e;
    margin-bottom: 4px;
}

.order-date {
    font-size: 12px;
    color: #65676b;
}

.order-status {
    padding: 4px 12px;
    border-radius: 30px;
    font-size: 11px;
    font-weight: 600;
}

.status-delivered {
    background: #28a74520;
    color: #28a745;
}

.status-processing {
    background: #ffc10720;
    color: #856404;
}

.status-shipped {
    background: #17a2b820;
    color: #17a2b8;
}

.status-pending {
    background: #fd7e1420;
    color: #fd7e14;
}

.order-total {
    font-weight: 600;
    color: #3D204E;
    margin-left: 16px;
    min-width: 80px;
    text-align: right;
}

/* Quick Actions */
.quick-actions-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
}

.quick-action-card {
    background: white;
    border-radius: 16px;
    padding: 20px;
    text-align: center;
    text-decoration: none;
    transition: all 0.2s ease;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
}

.quick-action-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    text-decoration: none;
}

.quick-action-icon {
    width: 60px;
    height: 60px;
    background: #f0e9f5;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 12px;
}

.quick-action-icon i {
    font-size: 28px;
    color: #3D204E;
}

.quick-action-title {
    font-weight: 600;
    color: #1a1a2e;
    margin-bottom: 4px;
}

.quick-action-desc {
    font-size: 11px;
    color: #65676b;
}

/* Profile Card */
.profile-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    margin-bottom: 24px;
}

.profile-card-header {
    background: #3D204E;
    padding: 20px;
    text-align: center;
    color: white;
}

.profile-avatar {
    width: 80px;
    height: 80px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 12px;
}

.profile-avatar i {
    font-size: 45px;
    color: #3D204E;
}

.profile-name {
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 4px;
}

.profile-email {
    font-size: 12px;
    opacity: 0.8;
}

.profile-info {
    padding: 16px 20px;
}

.profile-info-item {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid #f0f2f5;
}

.profile-info-item:last-child {
    border-bottom: none;
}

.profile-info-label {
    font-size: 13px;
    color: #65676b;
}

.profile-info-value {
    font-size: 13px;
    font-weight: 500;
    color: #1a1a2e;
}

/* Wishlist Items */
.wishlist-items {
    max-height: 400px;
    overflow-y: auto;
}

.wishlist-item {
    display: flex;
    align-items: center;
    padding: 12px 16px;
    border-bottom: 1px solid #f0f2f5;
    transition: all 0.2s ease;
}

.wishlist-item:hover {
    background: #f8f9fa;
}

.wishlist-item-image {
    width: 50px;
    height: 50px;
    background: #f0e9f5;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
}

.wishlist-item-image i {
    font-size: 24px;
    color: #3D204E;
}

.wishlist-item-info {
    flex: 1;
}

.wishlist-item-name {
    font-weight: 600;
    font-size: 14px;
    color: #1a1a2e;
    margin-bottom: 2px;
}

.wishlist-item-price {
    font-size: 13px;
    color: #3D204E;
    font-weight: 600;
}

.wishlist-item-actions {
    display: flex;
    gap: 8px;
}

.btn-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f0f2f5;
    color: #65676b;
    transition: all 0.2s ease;
}

.btn-icon:hover {
    background: #3D204E;
    color: white;
}

/* Activity Feed */
.activity-feed {
    max-height: 400px;
    overflow-y: auto;
}

.activity-item {
    display: flex;
    padding: 14px 16px;
    border-bottom: 1px solid #f0f2f5;
    transition: all 0.2s ease;
}

.activity-item:hover {
    background: #f8f9fa;
}

.activity-icon {
    width: 40px;
    height: 40px;
    background: #f0e9f5;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
}

.activity-icon i {
    font-size: 18px;
    color: #3D204E;
}

.activity-content {
    flex: 1;
}

.activity-text {
    font-size: 13px;
    color: #1a1a2e;
    margin-bottom: 2px;
}

.activity-time {
    font-size: 11px;
    color: #65676b;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 40px 20px;
}

.empty-icon {
    font-size: 60px;
    color: #e4e6eb;
    margin-bottom: 16px;
}

.empty-text {
    color: #65676b;
    font-size: 14px;
}

/* View All Link */
.view-all-link {
    display: inline-block;
    margin-top: 16px;
    font-size: 13px;
    font-weight: 500;
    color: #3D204E;
    text-decoration: none;
}

.view-all-link:hover {
    text-decoration: underline;
}

/* Responsive */
@media (max-width: 768px) {
    .dashboard-section {
        padding: 20px 0;
    }
    
    .welcome-title {
        font-size: 22px;
    }
    
    .stat-value {
        font-size: 22px;
    }
    
    .quick-actions-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }
    
    .quick-action-card {
        padding: 16px;
    }
    
    .quick-action-icon {
        width: 50px;
        height: 50px;
    }
    
    .quick-action-icon i {
        font-size: 22px;
    }
    
    .order-item {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .order-total {
        margin-left: 0;
        margin-top: 8px;
        text-align: left;
    }
}
</style>

<section class="dashboard-section">
    <div class="container">
        <!-- Welcome Banner -->
        <div class="welcome-banner">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="welcome-title">
                        Welcome back, <?= esc($user['firstname']) ?>! 🙏
                    </h1>
                    <p class="welcome-subtitle">
                        Here's what's happening with your account today.
                    </p>
                </div>
            </div>
        </div>

        <!-- Stats Row -->
        <div class="row">
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-icon-wrapper">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div class="stat-value" id="totalOrders">4</div>
                    <div class="stat-label">Total Orders</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-icon-wrapper">
                        <i class="fas fa-heart"></i>
                    </div>
                    <div class="stat-value" id="wishlistCount">6</div>
                    <div class="stat-label">Wishlist Items</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-icon-wrapper">
                        <i class="fas fa-truck"></i>
                    </div>
                    <div class="stat-value" id="pendingOrders">2</div>
                    <div class="stat-label">Pending Delivery</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-icon-wrapper">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="stat-value" id="reviewsCount">3</div>
                    <div class="stat-label">Reviews Written</div>
                </div>
            </div>
        </div>

        <!-- Main Content Row -->
        <div class="row">
            <!-- Left Column -->
            <div class="col-lg-8">
                <!-- Recent Orders Section -->
                <div class="recent-orders-card">
                    <div class="card-header-custom" style="padding: 16px 20px; border-bottom: 1px solid #e4e6eb;">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold" style="color: #1a1a2e;">
                                <i class="fas fa-clock me-2" style="color: #3D204E;"></i> Recent Orders
                            </h5>
                            <a href="/orders" class="view-all-link">View All →</a>
                        </div>
                    </div>
                    
                    <div id="recentOrdersList">
                        <!-- Recent orders will be populated here -->
                        <div class="order-item">
                            <div class="order-info">
                                <div class="order-id">#ORD-2024-001</div>
                                <div class="order-date">January 15, 2024</div>
                            </div>
                            <div class="order-status status-delivered">Delivered</div>
                            <div class="order-total">$95.97</div>
                        </div>
                        <div class="order-item">
                            <div class="order-info">
                                <div class="order-id">#ORD-2024-002</div>
                                <div class="order-date">February 20, 2024</div>
                            </div>
                            <div class="order-status status-shipped">Shipped</div>
                            <div class="order-total">$94.96</div>
                        </div>
                        <div class="order-item">
                            <div class="order-info">
                                <div class="order-id">#ORD-2024-003</div>
                                <div class="order-date">March 10, 2024</div>
                            </div>
                            <div class="order-status status-processing">Processing</div>
                            <div class="order-total">$48.98</div>
                        </div>
                        <div class="order-item">
                            <div class="order-info">
                                <div class="order-id">#ORD-2024-004</div>
                                <div class="order-date">March 25, 2024</div>
                            </div>
                            <div class="order-status status-pending">Pending</div>
                            <div class="order-total">$39.99</div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="quick-actions-grid">
                    <a href="/shop" class="quick-action-card">
                        <div class="quick-action-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="quick-action-title">Continue Shopping</div>
                        <div class="quick-action-desc">Browse our faith-inspired products</div>
                    </a>
                    <a href="/profile" class="quick-action-card">
                        <div class="quick-action-icon">
                            <i class="fas fa-user-edit"></i>
                        </div>
                        <div class="quick-action-title">Edit Profile</div>
                        <div class="quick-action-desc">Update your account information</div>
                    </a>
                    <a href="/orders" class="quick-action-card">
                        <div class="quick-action-icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        <div class="quick-action-title">Track Order</div>
                        <div class="quick-action-desc">Check your order status</div>
                    </a>
                    <a href="/contact" class="quick-action-card">
                        <div class="quick-action-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <div class="quick-action-title">Support</div>
                        <div class="quick-action-desc">Get help with your account</div>
                    </a>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-lg-4">
                <!-- Profile Card -->
                <div class="profile-card">
                    <div class="profile-card-header">
                        <div class="profile-avatar">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <div class="profile-name"><?= esc($user['firstname'] . ' ' . $user['lastname']) ?></div>
                        <div class="profile-email"><?= esc($user['emailaddress']) ?></div>
                    </div>
                    <div class="profile-info">
                        <div class="profile-info-item">
                            <span class="profile-info-label">Member Since</span>
                            <span class="profile-info-value"><?= date('F j, Y', strtotime($user['created_at'])) ?></span>
                        </div>
                        <div class="profile-info-item">
                            <span class="profile-info-label">Account Status</span>
                            <span class="profile-info-value">
                                <?php if ($user['status'] == 1 || $user['status'] == 'active'): ?>
                                    <span style="color: #28a745;">✓ Active</span>
                                <?php else: ?>
                                    <span style="color: #ffc107;">⏳ Pending</span>
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="profile-info-item">
                            <span class="profile-info-label">Email Verification</span>
                            <span class="profile-info-value">
                                <?php if ($user['email_verified'] == 1): ?>
                                    <span style="color: #28a745;">✓ Verified</span>
                                <?php else: ?>
                                    <span style="color: #dc3545;">✗ Unverified</span>
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="profile-info-item">
                            <span class="profile-info-label">Account Type</span>
                            <span class="profile-info-value"><?= esc($user['usertype']) ?></span>
                        </div>
                    </div>
                </div>

                <!-- Wishlist Preview -->
                <div class="recent-orders-card">
                    <div class="card-header-custom" style="padding: 16px 20px; border-bottom: 1px solid #e4e6eb;">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold" style="color: #1a1a2e;">
                                <i class="fas fa-heart me-2" style="color: #dc3545;"></i> Wishlist
                            </h5>
                            <a href="/wishlist" class="view-all-link">View All →</a>
                        </div>
                    </div>
                    <div class="wishlist-items">
                        <div class="wishlist-item">
                            <div class="wishlist-item-image">
                                <i class="fas fa-book"></i>
                            </div>
                            <div class="wishlist-item-info">
                                <div class="wishlist-item-name">Daily Devotional</div>
                                <div class="wishlist-item-price">$24.99</div>
                            </div>
                            <div class="wishlist-item-actions">
                                <a href="/cart" class="btn-icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </a>
                                <a href="#" class="btn-icon remove-wishlist">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <div class="wishlist-item">
                            <div class="wishlist-item-image">
                                <i class="fas fa-mug-hot"></i>
                            </div>
                            <div class="wishlist-item-info">
                                <div class="wishlist-item-name">Faith Inspirational Mug</div>
                                <div class="wishlist-item-price">$19.99</div>
                            </div>
                            <div class="wishlist-item-actions">
                                <a href="/cart" class="btn-icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </a>
                                <a href="#" class="btn-icon remove-wishlist">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <div class="wishlist-item">
                            <div class="wishlist-item-image">
                                <i class="fas fa-tshirt"></i>
                            </div>
                            <div class="wishlist-item-info">
                                <div class="wishlist-item-name">Christian Faith T-Shirt</div>
                                <div class="wishlist-item-price">$34.99</div>
                            </div>
                            <div class="wishlist-item-actions">
                                <a href="/cart" class="btn-icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </a>
                                <a href="#" class="btn-icon remove-wishlist">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->include('templates/footer'); ?>

<script>
$(document).ready(function() {
    // Remove wishlist item
    $('.remove-wishlist').on('click', function(e) {
        e.preventDefault();
        const $item = $(this).closest('.wishlist-item');
        
        Swal.fire({
            title: 'Remove from wishlist?',
            text: "This item will be removed from your wishlist.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, remove it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $item.fadeOut(300, function() {
                    $(this).remove();
                    showNotification('Item removed from wishlist', 'success');
                    
                    // Update wishlist count
                    const newCount = $('.wishlist-item').length;
                    $('#wishlistCount').text(newCount);
                    
                    if (newCount === 0) {
                        $('.wishlist-items').html(`
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-heart"></i>
                                </div>
                                <div class="empty-text">Your wishlist is empty</div>
                            </div>
                        `);
                    }
                });
            }
        });
    });
    
    // Notification function
    function showNotification(message, type) {
        $('.notification-toast').remove();
        const toast = $('<div class="notification-toast" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999; min-width: 250px; padding: 12px 20px; border-radius: 10px; color: white; font-weight: 500; display: none;"></div>');
        const bgColor = type === 'success' ? '#28a745' : '#dc3545';
        toast.css('background', bgColor);
        toast.text(message);
        $('body').append(toast);
        toast.fadeIn(300);
        setTimeout(() => toast.fadeOut(300, () => toast.remove()), 5000);
    }
});
</script>